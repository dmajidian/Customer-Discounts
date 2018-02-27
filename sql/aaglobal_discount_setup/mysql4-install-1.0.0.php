<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('aaglobal_discount/discount'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')

    ->addColumn('customer', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
        'nullable'  => true,
    ), 'Customer ID')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
        'nullable'  => true,
    ), 'Type of Discount')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_REAL, 0, array(
        'nullable'  => true,
    ), 'Value')

    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
        'nullable'  => true,
    ), 'Product Skus')
    ->addColumn('category', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
        'nullable'  => true,
    ), 'Categories')
    ->addColumn("datetime", Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), "Datetime")
;
$installer->getConnection()->createTable($table);

$installer->endSetup();
