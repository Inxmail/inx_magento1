<?php

/**
 * @category               Module Helper
 * @package                DndInxmail_Subscriber
 * @dev                    Merlin
 * @last_modified          08/03/2013
 * @copyright              Copyright (c) 2012 Agence Dn'D
 * @author                 Agence Dn'D - Conseil en creation de site e-Commerce Magento : http://www.dnd.fr/
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DndInxmail_Subscriber_Helper_Segment extends DndInxmail_Subscriber_Helper_Abstract
{

    /**
     * Get customer segment to synchronize
     *
     * @return string ID separated by commas
     */
    public function getCustomerSegmentsConfig()
    {
        $segments = Mage::getStoreConfig('dndinxmail_subscriber_mapping/mapping_segments/customer_segment');

        return $this->formatCustomerSegments($segments);
    }

    /**
     * Get array of segments
     *
     * @param string $groups
     *
     * @return array
     */
    public function formatCustomerSegments($segments)
    {
        return array_filter(explode(',', $segments));
    }

    /**
     * Get Magento customer segment name
     *
     * @param int $segmentId Magento segment ID
     *
     * @return string
     */
    public function getSegmentName($segmentId)
    {
        $resource        = Mage::getSingleton('core/resource');
        $read            = $resource->getConnection('core_read');
        $customerSegment = $resource->getTableName('enterprise_customersegment/segment');
        $query           = "SELECT `$customerSegment`.`name` as `segment_name` FROM `$customerSegment` WHERE `$customerSegment`.`segment_id` = $segmentId";

        try {
            if (!$result = $read->query($query)) {
                return false;
            }
            if (!$segmentName = $result->fetch()) {
                return false;
            }

            return (isset($segmentName['segment_name'])) ? $segmentName['segment_name'] : false;;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Format Magento Segment ID to Inxmail list name
     *
     * @param int $segmentId Magento segment ID
     *
     * @return string Inxmail list name
     */
    public function formatInxmailListName($segmentId)
    {
        $name = $this->getSegmentName($segmentId);

        return ($name) ? DndInxmail_Subscriber_Helper_Group::DNDINXMAIL_INXMAIL_LIST_CUTOMER_SEGMENT_PREFIX . $name : DndInxmail_Subscriber_Helper_Group::DNDINXMAIL_INXMAIL_LIST_CUTOMER_SEGMENT_PREFIX . $segmentId;
    }

    /**
     * Get customer from Magento segment
     *
     * @param int $segmentId Magento segment ID
     *
     * @return array Array with customer email
     */
    public function getCustomersFromSegment($segmentId)
    {
        $customers = Mage::getResourceModel('enterprise_customersegment/report_customer_collection');
        $customers->addNameToSelect()->addSegmentFilter($segmentId)->addWebsiteFilter(Mage::registry('filter_website_ids'))->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');

        if ($customers->count() <= 0) {
            return false;
        }

        $emails = array();

        foreach ($customers as $customer) {
            $emails[] = $customer->getEmail();
        }

        return (count($emails) > 0) ? $emails : false;
    }

}