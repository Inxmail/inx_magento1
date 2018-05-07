<?php

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
