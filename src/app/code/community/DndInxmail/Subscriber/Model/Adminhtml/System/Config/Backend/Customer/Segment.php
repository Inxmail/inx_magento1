<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          08/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Backend_Customer_Segment extends Mage_Core_Model_Config_Data
{

    /**
     * Format attributes to synchronize in Inxmail after saving in admin
     *
     * @return boolean
     */
    protected function _afterSave()
    {
        if (!Mage::helper('dndinxmail_subscriber')->isDndInxmailEnabled() || !Mage::helper('enterprise_customersegment')->isEnabled()) return false;

        $value = $this->getValue();

        $synchronize   = Mage::helper('dndinxmail_subscriber/synchronize');
        $segmentHelper = Mage::helper('dndinxmail_subscriber/segment');

        $newSegments = $segmentHelper->formatCustomerSegments($value);
        $oldSegments = $segmentHelper->getCustomerSegmentsConfig();

        $created = array_filter(array_diff($newSegments, $oldSegments));

        $deleted = array_filter(array_diff($oldSegments, $newSegments));

        $segments = array(
            DndInxmail_Subscriber_Helper_Synchronize::DNDINXMAIL_CUSTOMER_MAPPING_STATUS_CREATED => $created,
        );

        if (count($created) == 0 && count($deleted) == 0) return false;

        try {
            $synchronize->synchronizeCustomerSegments($segments);
        }
        catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionData($e->getMessage(), __FUNCTION__);

            return false;
        }

        return true;
    }

}