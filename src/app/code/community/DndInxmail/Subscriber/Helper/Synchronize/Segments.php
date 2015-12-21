<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          13/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Synchronize_Segments extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     *
     */
    const CUSTOMERS_PER_PASS = 'dndinxmail_subscriber_crons/crons_synchronize_segments/customers_per_pass';

    /**
     * Format emails for synchronization
     *
     * @return array
     */
    public function initSynchronization()
    {
        $pass = array();

        $customersPerPass = $this->getCustomersPerPass();
        $segmentHelper    = Mage::helper('dndinxmail_subscriber/segment');
        $segmentsConfig   = $segmentHelper->getCustomerSegmentsConfig();
        if (count($segmentsConfig) <= 0) {
            return array();
        }
        $segment = 0;

        $isSession = (!$session = Mage::helper('dndinxmail_subscriber/synchronize')->openInxmailSession()) ? false : true;

        foreach ($segmentsConfig as $segmentId) {

            $listName = $segmentHelper->formatInxmailListName($segmentId);
            $emails   = $segmentHelper->getCustomersFromSegment($segmentId);

            if ($isSession) {
                try {
                    if ($list = $session->getListContextManager()->findByName($listName)) {
                        Mage::helper('dndinxmail_subscriber/synchronize')->truncateSpecificInxmailList($list);
                    }
                }
                catch (Exception $e) {

                }
            }

            if (!$emails) {
                continue;
            }

            $currentPass = 0;
            $i           = 0;
            foreach ($emails as $email) {

                $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
                if (!$subscriber instanceof Varien_Object || !$subscriber->getSubscriberId()) {
                    continue;
                }
                if (!$subscriber->isSubscribed()) {
                    continue;
                }

                $pass[$segment][$currentPass][] = $email;

                if ($i % $customersPerPass == $customersPerPass - 1) $currentPass++;

                $i++;
            }

            if ($i == 0) {
                continue;
            }

            $pass[$segment]['total'] = count($pass[$segment]);
            $pass[$segment]['name']  = $listName;

            $segment++;
        }

        $pass['total'] = count($pass);

        Mage::helper('dndinxmail_subscriber/synchronize')->closeInxmailSession();

        return $pass;
    }

    /**
     * Get customer per pass
     *
     * @return int
     */
    public function getCustomersPerPass()
    {
        $config = Mage::getStoreConfig(self::CUSTOMERS_PER_PASS);

        return ($config != '' && $config != null) ? $config : 50;
    }

}