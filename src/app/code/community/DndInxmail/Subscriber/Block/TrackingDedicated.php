<?php

class DndInxmail_Subscriber_Block_TrackingDedicated extends Mage_Customer_Block_Newsletter
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('dndinxmail/newsletter/tracking_dedicated.phtml');
    }

    public function getInxTrackingPermission()
    {
        return $this->getSubscriptionObject()->getInxTrackingPermission();
    }

    public function getAction()
    {
        return $this->getUrl('dndinxmail_subscriber/permission/commit');
    }

}
