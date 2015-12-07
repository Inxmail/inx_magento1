<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          4/12/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Synchronization extends Mage_Core_Model_Abstract
{

    protected $_inxmailSession;

    protected $_customers = array();

    /**
     * @param array $emails
     * @param $inxmailList
     * @param $store
     */
    public function synchronizeCustomers(array $emails, $inxmailList, $store = null)
    {
        if (empty($emails)) {
            return;
        }

        $synchronizeHelper = Mage::helper('dndinxmail_subscriber/synchronize');
        try {
            $synchronizeHelper->openInxmailSession();
        } catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionMessage($e, __FUNCTION__);

            return;
        }

        if (is_null($store)) {
            $store = Mage::app()->getStore();
        }
        $customers = $this->_getCustomersByEmails($emails);
        $subscriberCollection = Mage::getModel('newsletter/subscriber')->getCollection();
        $subscriberCollection->addFieldToFilter('subscriber_email', array('in' => $emails))
            ->addStoreFilter($store->getId());

        $recipientContext      = $synchronizeHelper->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);
        $batchChannel          = $recipientContext->createBatchChannel();
        foreach ($subscriberCollection as $subscriber) {
            $subscriptionEmail = $subscriber->getEmail();
            $customer = null;

            $recipientRowSet = $recipientContext->select(
                $inxmailList,
                null,
                "email LIKE \"" . $subscriptionEmail . "\"",
                null,
                Inx_Api_Order::ASC
            );
            $inxmailSubscriber = $recipientRowSet->next();
            $isSubscribed = ($inxmailSubscriber) ? true : false;

            if ($isSubscribed && !$subscriber->isSubscribed()) {
                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED)
                    ->setNotSyncInxmail(true);
                $subscriber->save();
            } elseif ($subscriber->isSubscribed()) {
                $batchChannel->createRecipient($subscriptionEmail, true);
                $batchChannel->selectRecipient($subscriptionEmail, true);
                if (isset($customers[$subscriptionEmail])) {
                    $customer = $customers[$subscriptionEmail];
                    $vars = $synchronizeHelper->getCustomerAttributesForInxmail($customer);

                    foreach ($vars as $attributeName => $attributeValue) {
                        try {
                            $recipientMetaData->getUserAttribute($attributeName);
                            $batchChannel->write($recipientMetaData->getUserAttribute($attributeName), $attributeValue);
                        } catch (Inx_Api_Recipient_AttributeNotFoundException $e) {
                            continue;
                        }
                    }
                }
                $batchChannel->write($subscriptionAttribute, date("c"));
            }
        }
        $batchChannel->executeBatch();

        Mage::helper('dndinxmail_subscriber/config')->setIsSynchronized(true, 'stores', $store->getId());
    }

    /**
     * @param $emails
     *
     * @return array|Mage_Customer_Model_Customer[]
     */
    protected function _getCustomersByEmails($emails)
    {
        /** @var Mage_Customer_Model_Resource_Customer_Collection $customerCollection */
        $customerCollection = Mage::getModel('customer/customer')->getCollection();
        $customerCollection->addNameToSelect()
            ->addFieldToFilter('email', array('in' => $emails))
            ->addAttributeToSelect('*');
        $customerCollection->getSelect()
            ->group('e.email');

        $customers = array();
        foreach ($customerCollection as $customer) {
            $customers[$customer->getEmail()] = $customer;
        }

        return $customers;
    }
}
 