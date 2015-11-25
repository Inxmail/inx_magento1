<?php

class DndInxmail_Subscriber_Helper_Config extends DndInxmail_Subscriber_Helper_Abstract
{
    const CONFIG_IS_SYNCHRONIZED = 'dndinxmail_subscriber/syncrhonize_subscribers/is_synchronized';

    /**
     * @return bool
     */
    public function isSynchronized()
    {
        return $this->getConfig(self::CONFIG_IS_SYNCHRONIZED);
    }

    /**
     * @param $value
     * @param string $scope
     * @param null $scopeId
     */
    public function setIsSynchronized($value, $scope = 'stores', $scopeId = null)
    {
        if (is_null($scopeId)) {
            $scopeId = Mage::app()->getStore()->getId();
        }
        $config = Mage::app()->getConfig();
        $config ->saveConfig(self::CONFIG_IS_SYNCHRONIZED, $value, $scope, $scopeId);
    }
}
 