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

class DndInxmail_Subscriber_Block_Tracking extends Mage_Customer_Block_Newsletter
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('dndinxmail/newsletter/tracking.phtml');
    }

    public function getInxTrackingPermission()
    {
        return $this->getSubscriptionObject()->getInxTrackingPermission();
    }

    public function getAction()
    {
        return $this->getUrl('*/*/save');
    }

}
