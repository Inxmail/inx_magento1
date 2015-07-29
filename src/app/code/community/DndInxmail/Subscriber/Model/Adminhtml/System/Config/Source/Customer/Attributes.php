<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Alexander Velykzhanin
 * @last_modified          29/07/2015
 * @copyright              Copyright (c) 2015 Flagbit GmbH & Co. KG
 * @author                 Flagbit GmbH & Co. KG : https://www.flagbit.de/
 * @license                http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Customer_Attributes
{

    /**
     * @var
     */
    protected $_options;


    /**
     * Attributes that we don't need to map(will not be used or are mapped automatically
     *
     * @var array
     */
    protected $_attributesToSkip = array(
        'disable_auto_group_change',
        'email',
        'default_billing',
        'default_shipping',
        'password_hash',
        'reward_update_notification',
        'reward_warning_notification',
        'rp_token',
        'rp_token_created_at',
    );


    /**
     * @return array
     */
    protected function _getStaticAttributes()
    {
        $helper = Mage::helper('dndinxmail_subscriber');

        return array(
            array(
                'label' => $helper->__('Customer ID'),
                'value' => 'entity_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Update Date'),
                'value' => 'updated_at',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
                ),
            ),
            array(
                'label' => $helper->__('Customer is active'),
                'value' => 'is_active',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN,
                ),
            ),
            array(
                'label' => $helper->__('Creation Date'),
                'value' => 'created_at',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
                ),
            ),
            array(
                'value' => 'group_id',
                'label' => $helper->__('Group ID'),
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Store ID'),
                'value' => 'store_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
            array(
                'label' => $helper->__('Website ID'),
                'value' => 'website_id',
                'params' => array(
                    'data-type' => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
                ),
            ),
        );
    }


    /**
     * Get product attributes
     *
     * @return array Product attributes
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $attributes = Mage::getModel('customer/entity_attribute_collection');
            // Static columns that are not attributes
            $results = $this->_getStaticAttributes();

            $typeMapping = $this->getTypeMapping();

            foreach ($attributes as $attribute) {
                $code = $attribute->getAttributeCode();
                if (in_array($code, $this->_attributesToSkip)) {
                    continue;
                }
                $label       = $attribute->getFrontendLabel();
                $backendType = $attribute->getBackendType();
                if ($backendType == 'static') {
                    continue;
                } elseif ($attribute->getFrontendInput() == 'boolean') {
                    $type = Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN;
                } else {
                    $type = $typeMapping[$backendType];
                }
                if (!$label) {
                    $label .= $code;
                }
                $results[] = array(
                    'label' => $label,
                    'value' => $code,
                    'params' => array(
                        'data-type'  => $type,
                    ),
                );
            }

            uasort($results, function($a, $b) {
                return $a['label'] > $b['label'];
            });

            $helper = Mage::helper('dndinxmail_subscriber');
            $groupedOptions  = array(
                Inx_Api_Recipient_Attribute::DATA_TYPE_DATE => array(
                    'label' => $helper->__('Type Date'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE  => array(
                    'label' => $helper->__('Type Float'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER => array(
                    'label' => $helper->__('Type Integer'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_STRING  => array(
                    'label' => $helper->__('Type Text'),
                    'value' => array(),
                ),
                Inx_Api_Recipient_Attribute::DATA_TYPE_BOOLEAN => array(
                    'label' => $helper->__('Type Yes/No'),
                    'value' => array(),
                ),
            );

            foreach ($results as $result) {
                $groupedOptions[$result['params']['data-type']]['value'][] = $result;
            }

            foreach ($groupedOptions as $type => $groupedOption) {
                if (!count($groupedOption['value'])) {
                    unset($groupedOptions[$type]);
                }
            }

            $this->_options = $groupedOptions;
        }

        return $this->_options;
    }


    /**
     * @return array
     */
    static public function getTypeMapping()
    {
        return array(
            'varchar'  => Inx_Api_Recipient_Attribute::DATA_TYPE_STRING,
            'datetime' => Inx_Api_Recipient_Attribute::DATA_TYPE_DATE,
            'int'      => Inx_Api_Recipient_Attribute::DATA_TYPE_INTEGER,
            'text'     => Inx_Api_Recipient_Attribute::DATA_TYPE_STRING,
            'decimal'  => Inx_Api_Recipient_Attribute::DATA_TYPE_DOUBLE,
        );
    }
}


