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

class DndInxmail_Subscriber_Block_Adminhtml_Notifications extends Mage_Core_Block_Template
{


    /**
     * @return array
     */
    public function getMessages()
    {
        $errorsJson = Mage::helper('dndinxmail_subscriber/flag')->getAdminNotifications();
        try {
            $errors = Mage::helper('core')->jsonDecode($errorsJson);
        } catch (Exception $e) {
            $errors = array();
        }

        if (!is_array($errors)) {
            $errors = array();
        }

        return $errors;
    }
}
