<?php
/**
 *  Magento Inxmail Module
 *
 *  @link http://flagbit.de
 *  @link https://www.inxmail.de/
 *  @author Flagbit GmbH
 *  @copyright Copyright © 2018 Inxmail GmbH
 *  @license Licensed under the Open Software License version 3.0 (https://opensource.org/licenses/OSL-3.0)
 */

class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Backend_Mapping
    extends Mage_Adminhtml_Model_System_Config_Backend_Serialized_Array
{
    protected function _afterSave()
    {
        try {
            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');
            $synchronize->openInxmailSession(true);
            $synchronize->doMappingCheck();
        } catch (Exception $e) {
            Mage::helper('dndinxmail_subscriber/log')->logExceptionMessage($e);
        }

        return parent::_afterSave();
    }
}
