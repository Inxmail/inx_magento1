<?php
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

