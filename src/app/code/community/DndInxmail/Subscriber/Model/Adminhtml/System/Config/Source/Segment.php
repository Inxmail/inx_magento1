<?php

/**
 * @category               Module Model
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          08/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Model_Adminhtml_System_Config_Source_Segment
{

    /**
     * @var
     */
    protected $_options;

    /**
     * @return array
     */
    public function toOptionArray()
    {

        $segments = Mage::getResourceModel('enterprise_customersegment/segment_collection')->addFieldToFilter('is_active', array('eq' => 1))->load();

        if (!$this->_options) {
            $this->_options[] = array(
                'value' => '',
                'label' => ''
            );
            foreach ($segments as $segment) {
                $this->_options[] = array(
                    'value' => $segment->getId(),
                    'label' => $segment->getName()
                );
            }
        }

        return $this->_options;
    }

}
