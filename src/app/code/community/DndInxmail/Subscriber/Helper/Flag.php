<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/02/2016
 * @copyright              Copyright (c) 2016 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Flag extends Mage_Core_Helper_Abstract
{
    const UNSUBSCRIBED_TIME = 'dndinxmail_subscriber_last_unsubscribed_time';
    const UNSUBSCRIBED_TIME_BY_STORE = 'dndinxmail_subscriber_last_unsubscribed_time_by_store';

    /**
     * @return Mage_Core_Model_Flag
     */
    public function getLastUnsubscribedTimeFlag()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::UNSUBSCRIBED_TIME))->loadSelf();
    }

    /**
     * @param $storeId
     * @return Mage_Core_Model_Flag
     */
    public function getLastUnsubscribedTimeFlagByStore()
    {
        return Mage::getModel('core/flag', array('flag_code' => self::UNSUBSCRIBED_TIME_BY_STORE))->loadSelf();
    }

    /**
     * @param $storeId
     * @return int|null
     */
    public function getLastUnsubscribedTime($storeId = null)
    {
        $timeByStore = $this->getLastUnsubscribedTimeByStore($storeId);
        if ($timeByStore) {
            return $timeByStore;
        }
        $flag = $this->getLastUnsubscribedTimeFlag();
        if (!$flag->getId()) {
            return null;
        }

        return (int) $flag->getFlagData();
    }

    /**
     * @param $storeId
     *
     * @return int|null
     */
    public function getLastUnsubscribedTimeByStore($storeId)
    {
        $flag = $this->getLastUnsubscribedTimeFlagByStore();
        if (!$flag->getId()) {
            return null;
        }

        $data = $flag->getFlagData();
        if (!is_array($data) || !isset($data[$storeId])) {
            return null;
        }

        return (int) $data[$storeId];
    }

    /**
     * @param null|int $time
     * @param null|int $storeId
     *
     * @throws Exception
     */
    public function saveLastUnsubscribedTimeFlag($time = null, $storeId = null)
    {
        if (!$time) {
            $time = time();
        }

        $flag = $this->getLastUnsubscribedTimeFlagByStore($storeId);
        $data = $flag->getFlagData();
        if (!is_array($data)) {
            $data = array();
        }
        $data[$storeId] = $time;
        $flag->setFlagData($data)->save();
    }
}