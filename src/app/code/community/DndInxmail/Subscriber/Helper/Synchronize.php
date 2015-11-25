<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @dev                    Alexander Velykzhanin
 * @last_modified          05/08/2015
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Synchronize extends DndInxmail_Subscriber_Helper_Abstract
{


    /**
     *
     */
    const DNDINXMAIL_API_URL = 'dndinxmail_subscriber_general/api/url'; // Inxmail API Url
    /**
     *
     */
    const DNDINXMAIL_API_USER = 'dndinxmail_subscriber_general/api/user'; // Inxmail API User
    /**
     *
     */
    const DNDINXMAIL_API_PASSWORD = 'dndinxmail_subscriber_general/api/password'; // Inxmail API Password

    /**
     *
     */
    const DNDINXMAIL_INXMAIL_LIST_ID = 'dndinxmail_subscriber_general/general/inxmail_list'; // Inxmail list ID

    /**
     *
     */
    const DNDINXMAIL_CUSTOMER_MAPPING_STATUS_CREATED = 'created'; // Customer mapping created status
    /**
     *
     */
    const DNDINXMAIL_CUSTOMER_MAPPING_STATUS_DELETED = 'deleted'; // Customer mapping deleted status
    /**
     * Stores synchronization error notifications
     */
    const DND_INXMAIL_ADMIN_NOTIFICATION = 'dndinxmail_subscriber_general/general/notifications';

    /**
     * @var null
     */
    protected $_inxmailSession = null; // Inxmail session

    /**
     * @var null
     */
    protected $_listContextManager = null; // Inxmail ListContextManager
    /**
     * @var null
     */
    protected $_recipientContext = null; // Inxmail RecipientContext

    /**
     * @var array
     */
    protected $_dynamicAttributes = array(); // Mapping dynamic attributes

    /**
     * Contains cache for loaded attributes
     *
     * @var array
     */
    protected $_attributes = array();

    /**
     * Open an Inxmail session
     *
     * @return mixed Inxmail session or false
     */
    public function openInxmailSession()
    {
        if (!$this->isInxmailSession()) {
            $url  = $this->getConfig(self::DNDINXMAIL_API_URL);
            $user = $this->getConfig(self::DNDINXMAIL_API_USER);
            $pass = $this->getConfig(self::DNDINXMAIL_API_PASSWORD);

            try {
                Inx_Apiimpl_Loader::registerAutoload();

                $this->_inxmailSession = Inx_Api_Session::createRemoteSession($url, $user, $pass);
            }
            catch (Inx_Api_LoginException $e) {
                if (!Mage::helper('dndinxmail_subscriber/error')->getIsSilentError()) {
                    $message = Mage::helper('dndinxmail_subscriber/log')->__('Inxmail API Error: %s', $e->getMessage());
                    Mage::getSingleton('adminhtml/session')->addError($message);
                    Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getTraceAsString(), __FUNCTION__);
                    Mage::helper('dndinxmail_subscriber/log')->logData('## URL: ' . $url . ' || USER: ' . $user . ' || PASS: ' . $pass, __FUNCTION__);
                }

                return false;
            }
            catch (Exception $e) {
                if (!Mage::helper('dndinxmail_subscriber/error')->getIsSilentError()) {
                    $message = Mage::helper('dndinxmail_subscriber/log')->__('Inxmail API Error: %s', $e->getMessage());
                    Mage::getSingleton('adminhtml/session')->addError($message);
                    Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);
                    Mage::helper('dndinxmail_subscriber/log')->logData('## URL: ' . $url . ' || USER: ' . $user . ' || PASS: ' . $pass, __FUNCTION__);
                }

                return false;
            }

        }

        return $this->_inxmailSession;
    }

    /**
     * Close the Inxmail session if exist
     *
     * @return boolean true
     */
    public function closeInxmailSession()
    {
        if ($this->isInxmailSession()) {
            $this->_inxmailSession->close();
            $this->_inxmailSession     = null;
            $this->_listContextManager = null;
            $this->_recipientContext   = null;
        }

        return true;
    }

    /**
     * Get the current Inxmail session
     *
     * @param string $param
     *
     * @return mixed Inxmail session or false
     */
    public function getInxmailSession()
    {
        return ($this->isInxmailSession()) ? $this->_inxmailSession : false;
    }

    /**
     * Check if there is a current opened Inxmail session
     *
     * @param string $param
     *
     * @return boolean
     */
    public function isInxmailSession()
    {
        return ($this->_inxmailSession == null) ? false : true;
    }

    /**
     * Get the ListContextManager. If not set, get it from the current Inxmail session
     *
     * @return mixed ListContextManager object or false
     */
    public function getListContextManager()
    {
        if ($this->isInxmailSession()) {
            if ($this->_listContextManager == null) {
                $this->_listContextManager = $this->getInxmailSession()->getListContextManager();
            }

            return $this->_listContextManager;
        }

        return false;
    }

    /**
     * Get the RecipientContext. If not set, get it from the current Inxmail session
     *
     * @return mixed RecipientContext object or false
     */
    public function getRecipientContext()
    {
        if ($this->isInxmailSession()) {
            if ($this->_recipientContext == null) {
                $this->_recipientContext = $this->getInxmailSession()->createRecipientContext();
            }

            return $this->_recipientContext;
        }

        return false;
    }

    /**
     * Subscribe email address to Inxmail
     * If email is linked to customer send additionnal data else send email as guest
     *
     * @param string $email Email address
     * @param boolean $trigger Trigger message in Inxmail
     * @param object $inxmailList Inxmail list
     *
     * @return boolean
     */
    public function subscribeCustomer($email, $trigger = true, $inxmailList)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        /** @var null|Mage_Customer_Model_Customer $customer */
        $customer      = $this->getCustomerByEmail($email);
        $vars          = array();

        if ($customer != false) {
            $vars = $this->getCustomerAttributesForInxmail($customer);
        }

        $recipientContext      = $this->getRecipientContext();
        $subscriptionManager   = $session->getSubscriptionManager();
        $recipientMetaData     = $recipientContext->getMetaData();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);

        $batchChannel    = $recipientContext->createBatchChannel();
        $recipientRowSet = $recipientContext->select($inxmailList, null, "email LIKE \"" . $email . "\"", null, Inx_Api_Order::ASC);
        $isSubscribed    = ($recipientRowSet->next()) ? true : false;

        if (!$isSubscribed && $trigger == true) {
            $sourceIdentifier = Mage::helper('dndinxmail_subscriber/version')->getSourceIdentifierString();
            $subscriptionManager->processSubscription($sourceIdentifier, null, $inxmailList, $email);
        }

        if (!$isSubscribed && $trigger == false) {
            $batchChannel->createRecipient($email, true);
        }

        $batchChannel->selectRecipient($email, true);

        if ($customer != false) {
            foreach ($vars as $attributeName => $attributeValue) {
                try {
                    $recipientMetaData->getUserAttribute($attributeName);
                    $batchChannel->write($recipientMetaData->getUserAttribute($attributeName), $attributeValue);
                }
                catch (Inx_Api_Recipient_AttributeNotFoundException $e) {
                    continue;
                }
            }
        }

        if (!$isSubscribed) {
            $batchChannel->write($subscriptionAttribute, date("c"));
        }

        $batchChannel->executeBatch();

        return true;
    }

    /**
     * @param Mage_Customer_Model_Customer $customer
     *
     * @return array
     */
    public function getCustomerAttributesForInxmail(Mage_Customer_Model_Customer $customer)
    {
        $vars = array();

        $email = $customer->getEmail();
        $mappingHelper = Mage::helper('dndinxmail_subscriber/mapping');
        $fields = $mappingHelper->getMappingFields();
        foreach ($fields as $magentoField => $config) {
            $inxmailColumn = $config['inxmail_column'];
            if ($mappingHelper->isDynamicAttribute($magentoField)) {
                $dynamicData = $this->getDynamicData($magentoField, $email);
                if ($dynamicData !== false) {
                    $vars[$inxmailColumn] = $dynamicData;
                }

                continue;
            }
            $attributeType = $config['attribute_type'];

            $value = null;
            if ($attributeType === 'customer') {
                $value = $customer->getData($magentoField);
            } elseif ($attributeType === 'customer_address') {
                $customerAddress = $customer->getDefaultBillingAddress();

                if ($customerAddress && $customerAddress->getId()) {
                    $value = $customerAddress->getData($magentoField);
                }
            }

            if ($value != null) {
                $value = $this->_processAttributesValue($magentoField, $value, $attributeType);
                $vars[$inxmailColumn] = $value;
            }
        }
        return $vars;
    }

    /**
     * Set unsubscribe status to email address in Inxmail list
     *
     * @param string $email Email address
     * @param boolean $trigger Trigger message in Inxmail
     * @param object $inxmailList Inxmail list
     *
     * @return boolean
     */
    public function unsubscribeCustomer($email, $trigger = true, $inxmailList)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        if (!$trigger) {
            $this->subscribeCustomer($email, $trigger, $inxmailList);
        }

        $recipientContext    = $this->getRecipientContext();
        $subscriptionManager = $session->getSubscriptionManager();

        $batchChannel = $recipientContext->createBatchChannel();

        if ($trigger) {
            $sourceIdentifier = Mage::helper('dndinxmail_subscriber/version')->getSourceIdentifierString();
            $subscriptionManager->processUnsubscription($sourceIdentifier, null, $inxmailList, $email);
        }
        else {
            $batchChannel->selectRecipient($email);
            $batchChannel->unsubscribe($inxmailList);
        }

        $batchChannel->executeBatch();

        return true;
    }


    /**
     * Remove email address from Inxmail list
     *
     * @param string $email Email address
     * @param object $inxmailList Inxmail list
     *
     * @return boolean
     */
    public function removeCustomer($email, $inxmailList)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        $recipientContext  = $this->getRecipientContext();
        $recipientMetaData = $recipientContext->getMetaData();

        $batchChannel = $recipientContext->createBatchChannel();

        $recipientRowSet = $recipientContext->select($inxmailList, null, "email LIKE \"" . $email . "\"", null, Inx_Api_Order::ASC);
        if ($recipientRowSet->next()) {
            $recipientRowSet->updateDatetime($recipientMetaData->getSubscriptionAttribute($inxmailList), null);
            $recipientRowSet->commitRowUpdate();
        }

        $recipientRowSetUns = $recipientContext->selectUnsubscriber($inxmailList, null, "email LIKE \"" . $email . "\"", null, Inx_Api_Order::ASC);
        if ($recipientRowSetUns->next()) {
            $recipientRowSetUns->resubscribe(null);
            $recipientRowSetUns->commitRowUpdate();
            $recipientRowSetUns->updateDatetime($recipientMetaData->getSubscriptionAttribute($inxmailList), null);
            $recipientRowSetUns->commitRowUpdate();
        }

        $batchChannel->executeBatch();

        return true;
    }

    /**
     * Get the customer by email address
     *
     * @param string $email Email address
     *
     * @return mixed Customer obejct form email address or false
     */
    public function getCustomerByEmail($email)
    {
        if(Mage::app()->getStore()->getCode() == Mage_Core_Model_Store::ADMIN_CODE) {
            $websites = Mage::app()->getWebsites();
            $website  = reset($websites);
            $website  = (count($website) > 0) ? $website->getId() : Mage::app()->getWebsite()->getId();
        } else {
            $website  = Mage::app()->getWebsite()->getId();
        }

        $customer = Mage::getModel('customer/customer')->setWebsiteId($website)->loadByEmail($email);

        return ($customer->getId() !== null) ? $customer : false;
    }

    /**
     * Delete all subscribers from Inxmail list
     *
     * @throws Exception
     *
     * @return mixed true or Exception
     */
    public function truncateInxmailList()
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);
            throw new Exception('Inxmail session does not exist');
        }

        if (!$listid = (int)$this->getSynchronizeListId()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## No list defined in configuration', __FUNCTION__);
            throw new Exception('No list defined in configuration');
        }

        $listContextManager    = $session->getListContextManager();
        $inxmailList           = $listContextManager->get($listid);
        $recipientContext      = $this->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();
        $emailAttribute        = $recipientMetaData->getEmailAttribute();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);

        $batchChannel = $recipientContext->createBatchChannel();

        $recipientRowSetUns = $recipientContext->selectUnsubscriber($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);
        while ($recipientRowSetUns->next()) {
            $recipientRowSetUns->resubscribe(null);
            $recipientRowSetUns->commitRowUpdate();
        }

        $recipientRowSet = $recipientContext->select($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);
        while ($recipientRowSet->next()) {
            $batchChannel->selectRecipient($recipientRowSet->getString($emailAttribute));
            $batchChannel->write($subscriptionAttribute, null);
        }

        $batchChannel->executeBatch();

        $recipientRowSet->close();
        $recipientContext->close();
        $this->closeInxmailSession();

        return true;
    }

    /**
     * Delete all subscribers from Specific Inxmail list
     *
     * @throws Exception
     *
     * @return mixed true or Exception
     */
    public function truncateSpecificInxmailList($inxmailList)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);
            throw new Exception('Inxmail session does not exist');
        }

        $recipientContext      = $this->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();
        $emailAttribute        = $recipientMetaData->getEmailAttribute();
        $subscriptionAttribute = $recipientMetaData->getSubscriptionAttribute($inxmailList);

        $batchChannel = $recipientContext->createBatchChannel();

        $recipientRowSetUns = $recipientContext->selectUnsubscriber($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);
        while ($recipientRowSetUns->next()) {
            $recipientRowSetUns->resubscribe(null);
            $recipientRowSetUns->commitRowUpdate();
        }

        $recipientRowSet = $recipientContext->select($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);
        while ($recipientRowSet->next()) {
            $batchChannel->selectRecipient($recipientRowSet->getString($emailAttribute));
            $batchChannel->write($subscriptionAttribute, null);
        }

        $batchChannel->executeBatch();

        return true;
    }

    /**
     * Synchronize Magento newsletter subscribers to Inxmail list
     *
     * @throws Exception
     *
     * @return mixed true or Exception
     */
    public function synchronizeSubscribers()
    {
        if (!$this->truncateInxmailList()) {
            Mage::helper('dndinxmail_subscriber/log')->logData('## Error truncating Inxmail list ', __FUNCTION__);
            throw new Exception('Error truncating Inxmail list');
        }

        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);
            throw new Exception('Inxmail session does not exist');
        }

        if (!$listid = (int)$this->getSynchronizeListId()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## No list defined in configuration', __FUNCTION__);
            throw new Exception('No list defined in configuration');
        }

        $listContextManager = $session->getListContextManager();
        $inxmailList        = $listContextManager->get($listid);
        $subscribers        = Mage::getResourceModel('newsletter/subscriber_collection');

        foreach ($subscribers as $subscriber) {
            $email  = $subscriber->getSubscriberEmail();
            $status = $subscriber->getStatus();
            $this->switchActionToSubscriberStatus($status, $email, false, $inxmailList);
        }

        $this->closeInxmailSession();

        return true;
    }

    /**
     * Get unsubscribed customer from inxmail
     *
     * @return mixed Unsubscribed emails or false
     */
    public function getUnsubscribedCustomers($storeId)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return array();
        }

        if (!$listid = (int)$this->getSynchronizeListId($storeId)) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## No list defined in configuration', __FUNCTION__);

            return array();
        }

        try {
            $unsubscribed       = array();
            $listContextManager = $session->getListContextManager();
            $inxmailList        = $listContextManager->get($listid);
            $recipientContext   = $this->getRecipientContext();
            $recipientMetaData  = $recipientContext->getMetaData();
            $emailAttribute     = $recipientMetaData->getEmailAttribute();

            $batchChannel = $recipientContext->createBatchChannel();

            $recipientRowSet = $recipientContext->selectUnsubscriber($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);

            while ($recipientRowSet->next()) {
                $unsubscribed[] = $recipientRowSet->getString($emailAttribute);
            }

            $batchChannel->executeBatch();
            $recipientContext->close();
        }
        catch (Exception $e) {

        }

        $this->closeInxmailSession();

        return $unsubscribed;
    }

    /**
     * @return array|bool
     */
    public function unsubscribeCustomersFromGroups()
    {
        $groupHelper = Mage::helper('dndinxmail_subscriber/group');

        $groupsConfig = $groupHelper->getCustomerGroupsConfig();
        if (count($groupsConfig) <= 0) return array();

        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        try {

            $contextListManager = $this->getListContextManager();
            $recipientContext   = $this->getRecipientContext();
            $recipientMetaData  = $recipientContext->getMetaData();
            $emailAttribute     = $recipientMetaData->getEmailAttribute();
            $batchChannel       = $recipientContext->createBatchChannel();
            $unsubscribed       = array();

            foreach ($groupsConfig as $groupId) {

                $listName = $groupHelper->formatInxmailListName($groupId);

                if ($inxmailList = $contextListManager->findByName($listName)) {
                    $recipientRowSet = $recipientContext->selectUnsubscriber($inxmailList, null, null, $emailAttribute, Inx_Api_Order::ASC);
                    while ($recipientRowSet->next()) {
                        $unsubscribed[] = $recipientRowSet->getString($emailAttribute);
                    }
                }

            }

            $batchChannel->executeBatch();
            $recipientContext->close();

        }
        catch (Exception $e) {
            return false;
        }

        $this->closeInxmailSession();

        $this->unsubscribeCustomersFromInxmail($unsubscribed);

        return true;
    }

    /**
     * Unsubscribe Inxmail email in Magento
     *
     * @param array $unsubscribed Unsubscribed emails
     *
     * @return boolean
     */
    public function unsubscribeCustomersFromInxmail($unsubscribed = array())
    {
        if (count($unsubscribed) <= 0) return false;

        foreach ($unsubscribed as $email) {
            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
            if (!$subscriber instanceof Varien_Object || !$subscriber->getId()) continue;

            if ($subscriber->isSubscribed()) {
                $subscriber->unsubscribe();
            }
        }

        return true;
    }

    /**
     * Get Inxmail columns
     *
     * @return array Inxmail columns name
     */
    public function getInxmailColumns()
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return array(
                array(
                    'name' => $this->__('No column available'),
                    'id'   => ''
                )
            );
        }

        $recipientContext  = $this->getRecipientContext();
        $recipientMetaData = $recipientContext->getMetaData();

        $batchChannel = $recipientContext->createBatchChannel();

        $attrIterator = $recipientMetaData->getAttributeIterator();

        $columns[] = array(
            'id'   => '',
            'name' => Mage::helper('dndinxmail_subscriber')->__('Disabled'),
            'type' => ''
        );
        while ($attrIterator->hasNext()) {
            $attr = $attrIterator->current();
            if ($attr->getName() != '' && $attr->getName() != null && $attr->getType() == Inx_Api_Recipient_Attribute::USER_ATTRIBUTE_TYPE) {
                $columns[] = array(
                    'id'   => htmlspecialchars($attr->getName()),
                    'name' => $attr->getName(),
                    'type' => $attr->getDataType()
                );
            }
            $attrIterator->next();
        }

        $batchChannel->executeBatch();
        $recipientContext->close();
        $this->closeInxmailSession();

        return $columns;
    }

    /**
     * Get all Inxmail lists
     *
     * @return array Inxmail lists
     */
    public function getInxmailLists()
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return array(
                array(
                    'name' => $this->__('No list available'),
                    'id'   => ''
                )
            );
        }

        $contextListManager = $this->getListContextManager();
        $inxmailLists       = $contextListManager->selectAll();

        $lists = array();

        $lists[] = array(
            'id'   => '',
            'name' => Mage::helper('dndinxmail_subscriber')->__('No list selected')
        );
        for ($i = 0; $i < $inxmailLists->size(); $i++) {

            $list            = $inxmailLists->get($i);
            $listId          = $list->getId();
            $listName        = $list->getName();
            $specificGroup   = DndInxmail_Subscriber_Helper_Group::DNDINXMAIL_INXMAIL_LIST_CUTOMER_GROUP_PREFIX;
            $specificSegment = DndInxmail_Subscriber_Helper_Group::DNDINXMAIL_INXMAIL_LIST_CUTOMER_SEGMENT_PREFIX;
            $specific        = (preg_match("/($specificGroup|$specificSegment)/", $listName)) ? true : false;

            if ($listName != Inx_Api_List_SystemListContext::NAME && !$specific) {
                $lists[] = array(
                    'id'   => $listId,
                    'name' => $listName
                );
            }

        }

        $inxmailLists->close();
        $this->closeInxmailSession();

        return $lists;
    }

    /**
     * Get data for customer attributes
     *
     * @param $field
     * @param $value
     * @param $attributeType
     *
     * @return string
     */
    protected function _processAttributesValue($field, $value, $attributeType)
    {

        if ($field == 'gender') {
            $gender = '';
            if ($value == '2') {
                $gender = 'f';
            }
            elseif ($value == '1') {
                $gender = 'm';
            }

            return $gender;
        }

        $attribute = $this->_getAttribute($field, $attributeType);

        if (!is_null($attribute) && $attribute->usesSource()) {
            if ($attribute->getFrontendInput() === 'select') {
                $value = $attribute->getSource()
                    ->getOptionText($value);
            } elseif ($attribute->getFrontendInput() === 'multiselect') {
                $exploded = explode(',', $value);
                $values = array();
                foreach ($exploded as $singleValue) {
                    $optionText = $attribute->getSource()
                        ->getOptionText($singleValue);

                    if (is_array($optionText)) {
                        $values[] = $optionText['label'];
                    } else {
                        $values[] = $optionText;
                    }

                }
                $value = implode(',', $values);
            }
        }

        return $value;
    }


    /**
     * @param $field
     * @param $attributeType
     *
     * @return null|Mage_Eav_Model_Entity_Attribute
     */
    protected function _getAttribute($field, $attributeType)
    {
        if (!array_key_exists($attributeType, $this->_attributes)) {
            $attributes = array();
            if ($attributeType === 'customer_address') {
                $attributeCollection = Mage::getResourceModel('customer/address_attribute_collection');
            } else {
                $attributeCollection = Mage::getResourceModel('customer/attribute_collection');
            }

            foreach ($attributeCollection as $attribute) {
                $attributes[$attribute->getAttributeCode()] = $attribute;
            }

            $this->_attributes[$attributeType] = $attributes;
        }

        $attribute = null;
        if (array_key_exists($field, $this->_attributes[$attributeType])) {
            $attribute = $this->_attributes[$attributeType][$field];
        }

        return $attribute;
    }



    /**
     * Get data for dynamic attributes
     *
     * @param string $attribute Attribute code
     * @param string $email Email address
     *
     * @return mixed Value of attribute or false
     */
    public function getDynamicData($attribute, $email)
    {
        $collection = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('email', array('eq' => $email));

        $entityType  = Mage::getModel('eav/entity_type')->loadByCode('order');
        $entityTable = $collection->getTable($entityType->getEntityTable());

        switch ($attribute) {

            case 'first_order':
                $collection->getSelect()->joinLeft($entityTable, '`e`.entity_id = `' . $entityTable . '`.customer_id', array($attribute => 'MIN(' . $entityTable . '.created_at)'));
                break;

            case 'last_order':
                $collection->getSelect()->joinLeft($entityTable, '`e`.entity_id = `' . $entityTable . '`.customer_id', array($attribute => 'MAX(' . $entityTable . '.created_at)'));
                break;

            case 'total_orders':
                $collection->getSelect()->joinLeft($entityTable, '`e`.entity_id = `' . $entityTable . '`.customer_id', array($attribute => 'COUNT(' . $entityTable . '.base_grand_total)'));
                break;

            case 'avg_orders':
                $collection->getSelect()->joinLeft($entityTable, '`e`.entity_id = `' . $entityTable . '`.customer_id', array($attribute => 'AVG(' . $entityTable . '.base_subtotal)'));
                break;

            case 'last_connection':
                if ($customer = $this->getCustomerByEmail($email)) {
                    $logCustomer = Mage::getModel('log/customer')->loadByCustomer($customer);

                    return $logCustomer->getLastVisitAt();
                }

                return false;
                break;

        }

        $collection->groupByAttribute('entity_id');

        $customer = $collection->getFirstItem()->toArray();

        return (isset($customer[$attribute])) ? $customer[$attribute] : false;
    }

    /**
     * Synchronize Magento customer group to Inxmail lists
     *
     * @param array $customerGroups Array with Magento customer group
     *
     * @return boolean
     */
    public function synchronizeCustomerGroups($customerGroups)
    {
        $groupHelper = Mage::helper('dndinxmail_subscriber/group');

        foreach ($customerGroups as $status => $groups) {

            switch ($status) {

                case self::DNDINXMAIL_CUSTOMER_MAPPING_STATUS_CREATED:
                    foreach ($groups as $group) {
                        $listName    = $groupHelper->formatInxmailListName($group);
                        $description = $groupHelper->getGroupName($group);
                        $description = ($description != false) ? $description : null;
                        $this->createInxmailList($listName, $description);
                    }
                    break;

                case self::DNDINXMAIL_CUSTOMER_MAPPING_STATUS_DELETED:
                    foreach ($groups as $group) {
                        $listName = $groupHelper->formatInxmailListName($group);
                        $this->deleteInxmailList($listName);
                    }
                    break;

            }

        }

        return true;
    }

    /**
     * Create an Inxmail list
     *
     * @param string $listName List name
     * @param string $description List description
     *
     * @return boolean
     */
    public function createInxmailList($listName, $description = null)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        $contextListManager = $this->getListContextManager();

        if (!$contextListManager->findByName($listName)) {
            $list = $contextListManager->createStandardList();
            $list->updateName($listName);
            if ($description) $list->updateDescription($description);
            $list->commitUpdate();
        }

        $this->closeInxmailSession();

        return true;
    }

    /**
     * Delete an Inxmail list
     *
     * @param string $listName List name
     *
     * @return boolean
     */
    public function deleteInxmailList($listName)
    {
        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        $contextListManager = $this->getListContextManager();

        if ($list = $contextListManager->findByName($listName)) {
            try {
                $contextListManager->remove($list->getId());

                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        $this->closeInxmailSession();

        return false;
    }

    /**
     * Synchronize Magento customers to Inxmail
     *
     * @return boolean
     */
    public function synchronizeCustomerGroupToInxmail()
    {
        $groupHelper = Mage::helper('dndinxmail_subscriber/group');

        $groupsConfig = $groupHelper->getCustomerGroupsConfig();
        if (count($groupsConfig) <= 0) return false;

        if (!$session = $this->openInxmailSession()) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData('## Inxmail session does not exist', __FUNCTION__);

            return false;
        }

        $contextListManager = $this->getListContextManager();

        $this->doMappingCheck();

        foreach ($groupsConfig as $groupId) {

            $listName = $groupHelper->formatInxmailListName($groupId);
            $emails   = $groupHelper->getCustomersFromGroup($groupId);

            if (!$list = $contextListManager->findByName($listName)) {
                $list = $contextListManager->createStandardList();
                $list->updateName($listName);
                $description = $groupHelper->getGroupName($groupId);
                $list->updateDescription($description);
                $list->commitUpdate();
            }
            else {
                $this->truncateSpecificInxmailList($list);
            }

            if (!$emails) continue;

            $inxmailList = $contextListManager->get($list->getId());

            /** @var Mage_Newsletter_Model_Resource_Subscriber_Collection $subscriberCollection */
            $subscriberCollection = Mage::getModel('newsletter/subscriber')->getCollection();
            $subscriberCollection->useOnlySubscribed()
                ->addFieldToFilter('subscriber_email', array('in' => $emails));
            $subscriberCollection->getSelect()->group('main_table.subscriber_email');

            foreach ($subscriberCollection as $subscriber) {
                if (!$subscriber->isSubscribed()) {
                    continue;
                }
                $this->subscribeCustomer($subscriber->getEmail(), false, $inxmailList);
            }
        }

        $this->closeInxmailSession();

        return true;
    }


    /**
     * @return bool
     */
    public function doMappingCheck()
    {
        $hasErrors = false;
        $errors    = array();
        /** @var DndInxmail_Subscriber_Helper_Mapping $mappingHelper */
        $mappingHelper = Mage::helper('dndinxmail_subscriber/mapping');
        /** @var DndInxmail_Subscriber_Helper_Log $logHelper */
        $logHelper = Mage::helper('dndinxmail_subscriber/log');

        $fields = $mappingHelper->getMappingFields();
        $recipientContext      = $this->getRecipientContext();
        $recipientMetaData     = $recipientContext->getMetaData();

        foreach ($fields as $magentoField => $config) {
            if ($mappingHelper->isDynamicAttribute($magentoField)) {
                continue;
            }
            $inxmailColumn = $config['inxmail_column'];
            $customerAttribute = Mage::getModel('eav/entity_attribute')->loadByCode('customer', $magentoField);
            $customerAddressAttribute = Mage::getModel('eav/entity_attribute')
                ->loadByCode('customer_address', $magentoField);
            if (!$customerAttribute->getId() && !$customerAddressAttribute->getId()) {
                $errors[] = sprintf(
                    "'%s' magento attribute not found during synchronization for '%s' column",
                    $magentoField,
                    $inxmailColumn
                );
                $hasErrors = true;
            }

            try {
                $recipientMetaData->getUserAttribute($inxmailColumn);
            } catch (Inx_Api_Recipient_AttributeNotFoundException $e) {
                $errors[] = sprintf(
                    "'%s' inxmail column not found during synchronization for '%s' magento field",
                    $inxmailColumn,
                    $magentoField
                );
                $hasErrors = true;
            }
        }

        $currentNotifications = Mage::getStoreConfig(self::DND_INXMAIL_ADMIN_NOTIFICATION);
        if ($hasErrors && !empty($errors)) {
            foreach ($errors as $error) {
                $logHelper->logData($error);
            }
        }

        $errorsJson = Mage::helper('core')->jsonEncode($errors);
        if ($currentNotifications !== $errorsJson) {
            $config = new Mage_Core_Model_Config();
            $config->saveConfig(self::DND_INXMAIL_ADMIN_NOTIFICATION, $errorsJson);
            $config->cleanCache();
        }

        return $hasErrors;
    }

    /**
     * Initiate an action based on the subscriber status
     *
     * @param string $status Subscriber status
     * @param string $email Email address
     * @param string $trigger Trigger message in Inxmail
     * @param object $inxmailList Inxmail list
     *
     * @return boolean true
     */
    public function switchActionToSubscriberStatus($status, $email, $trigger = true, $inxmailList)
    {
        switch ($status) {

            case Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED:
                $this->subscribeCustomer($email, $trigger, $inxmailList);
                break;

            case Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED:
                $this->unsubscribeCustomer($email, $trigger, $inxmailList);
                break;

            case Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE:
            case Mage_Newsletter_Model_Subscriber::STATUS_UNCONFIRMED:
                break;

        }

        return true;
    }

    /**
     * Get the Inxmail list to work with
     *
     * @return int List ID
     */
    public function getSynchronizeListId($storeId = null)
    {
        return ($this->getConfig(self::DNDINXMAIL_INXMAIL_LIST_ID, $storeId) == '' || $this->getConfig(self::DNDINXMAIL_INXMAIL_LIST_ID, $storeId) == null) ? false : $this->getConfig(self::DNDINXMAIL_INXMAIL_LIST_ID, $storeId);
    }

}