<?php

class DndInxmail_Subscriber_Model_Synchronization extends Mage_Core_Model_Abstract
{

    protected $_inxmailSession;

    protected $_customers = array();

    /**
     * @param array $emails
     * @param $inxmailList
     */
    public function synchronizeCustomers(array $emails, $inxmailList)
    {
        if (empty($emails)) {
            return;
        }

        $synchronizeHelper = Mage::helper('dndinxmail_subscriber/synchronize');
        if (!$synchronizeHelper->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData(
                '## Inxmail session does not exist',
                __FUNCTION__
            );

            return;
        }

        $customers = $this->_getCustomersByEmails($emails);

        $recipientContext      = $synchronizeHelper->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);
        $batchChannel          = $recipientContext->createBatchChannel();

        foreach ($emails as $email) {
            $vars = array();
            $customer = null;
            if (isset($this->_customers[$email])) {
                $customer = $this->_customers[$email];
                $vars = $synchronizeHelper->getCustomerAttributesForInxmail($customer);
            }

            $recipientRowSet = $recipientContext->select(
                $inxmailList,
                null,
                "email LIKE \"" . $email . "\"",
                null,
                Inx_Api_Order::ASC
            );
            $isSubscribed = ($recipientRowSet->next()) ? true : false;

            if (!$isSubscribed) {
                $batchChannel->createRecipient($email, true);
            }

            $batchChannel->selectRecipient($email, true);

            if (!is_null($customer)) {
                foreach ($vars as $attributeName => $attributeValue) {
                    try {
                        $recipientMetaData->getUserAttribute($attributeName);
                        $batchChannel->write($recipientMetaData->getUserAttribute($attributeName), $attributeValue);
                    } catch (Inx_Api_Recipient_AttributeNotFoundException $e) {
                        continue;
                    }
                }
            }

            if (!$isSubscribed) {
                $batchChannel->write($subscriptionAttribute, date("c"));
            }
        }

        $batchChannel->executeBatch();

        Mage::helper('dndinxmail_subscriber/config')->setIsSynchronized(true);
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
        $customerCollection->addFieldToFilter('email', array('in' => $emails));
        $customerCollection->getSelect()
            ->group('e.email');

        $customers = array();
        foreach ($customerCollection as $customer) {
            $customers[$customer->getEmail()] = $customer;
        }

        return $customers;
    }
}
 