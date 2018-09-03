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

/**
 * Class DndInxmail_Subscriber_PermissionController
 * Demo controller for single transfer of tracking permission without subscribe/sync anything else
 */
class DndInxmail_Subscriber_PermissionController extends Mage_Core_Controller_Front_Action
{
    public function commitAction()
    {
        $email = $this->getRequest()->getParam('email', false);
        if (!$email) {
            try{
                $session = Mage::getSingleton('customer/session');
                if (!$session->isLoggedIn()) {
                    $this->_redirect('newsletter/manage/');
                }
                $email = $session->getCustomer()->getEmail();

            } catch (\Exception $e) {
                Mage::logException($e);
            }
        }
        $granted = $this->getRequest()->getParam('tracking_permission', false);

        if ($email !== false) {
            $store = Mage::app()->getStore();
            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
            $subscriber->setInxTrackingPermission($granted);
            $subscriber->setNotSyncInxmail(true);
            $subscriber->save();

            /** @var DndInxmail_Subscriber_Helper_Synchronize $synchronize */
            $synchronize = Mage::helper('dndinxmail_subscriber/synchronize');

            $listId = $synchronize->getSynchronizeListId($store->getId());
            $synchronize->commitTrackingPermission($email, (int)$listId, $granted);
        }

        $this->_redirect('newsletter/manage/');
    }
}
