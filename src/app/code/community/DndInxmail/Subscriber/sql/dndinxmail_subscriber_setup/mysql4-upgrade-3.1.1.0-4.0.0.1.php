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

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();
$table = 'newsletter/subscriber';
$attribute = 'inx_tracking_permission';

$installer->getConnection()
    ->addColumn(
        $installer->getTable($table),
        $attribute,
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'default' => 0,
            'comment' => 'inxmail tracking permission'
        )
    );

$installer->endSetup();

