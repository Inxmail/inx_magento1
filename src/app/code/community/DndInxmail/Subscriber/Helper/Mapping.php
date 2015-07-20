<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          06/05/2015
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Mapping extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     * @var null
     */
    protected $_mapping = null; // Mapping object

    // Fields for customer attributes
    /**
     * @var array
     */
    protected $_customerAttributes = array(
        'entity_id',
        'website_id',
        'group_id',
        'store_id',
        'created_at',
        'updated_at',
        'is_active',
        'prefix',
        'firstname',
        'lastname',
        'gender',
        'dob'
    );

    // Fields for dynamics attributes
    /**
     * @var array
     */
    protected $_dynamicAttributes = array(
        'first_order',
        'last_order',
        'total_orders',
        'avg_orders',
        'last_connection'
    );

    /**
     * Get the mapping fields
     *
     * @return array Mapping fields with Magento attributeq in key and Inxmail attribute in value
     */
    public function getMappingFields()
    {
        if ($this->_mapping == null) {

            $mapping = array();
            foreach ($this->_customerAttributes as $cAttribute) {
                $cValue = $this->getCustomerAttributeConfig($cAttribute);
                if ($cValue != '' && $cValue != null) {
                    $mapping[$cAttribute] = $cValue;
                }
            }
            foreach ($this->_dynamicAttributes as $dAttribute) {
                $dValue = $this->getDynamicAttributeConfig($dAttribute);
                if ($dValue != '' && $dValue != null) {
                    $mapping[$dAttribute] = $dValue;
                }
            }

            $this->_mapping = $mapping;

        }

        return $this->_mapping;
    }

    /**
     * Check if attribute from mapping is dynamic
     *
     * @param string $attribute Attribute code
     *
     * @return boolean
     */
    public function isDynamicAttribute($attribute)
    {
        return (in_array($attribute, $this->_dynamicAttributes)) ? true : false;
    }

    /**
     * Get customer attribute's Inxmail column from Magento configuration
     *
     * @param string $attribute Attribute key
     *
     * @return mixed Attribute value
     */
    public function getCustomerAttributeConfig($attribute)
    {
        return Mage::getStoreConfig('dndinxmail_subscriber_mapping/mapping_customer/' . $attribute);
    }

    /**
     * Get dynamic attribute's Inxmail column from Magento configuration
     *
     * @param string $attribute Attribute key
     *
     * @return mixed Attribute value
     */
    public function getDynamicAttributeConfig($attribute)
    {
        return Mage::getStoreConfig('dndinxmail_subscriber_mapping/mapping_dynamics/' . $attribute);
    }

}