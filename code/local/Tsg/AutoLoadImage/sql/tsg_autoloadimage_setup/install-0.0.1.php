<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('tsg_autoloadimage/import_image');

$table = $installer->getConnection()->newTable($tableName)
    ->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'identity'  =>  true,
        'unsigned'  =>  true,
        'nullable'  =>  false,
        'primary'   =>  true
    ),'Id')
    ->addColumn('id_product',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable'  =>  false,
    ),'id product')
    ->addColumn('status',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable'  =>  false,
        'default'   =>  0
    ),'Status load')
    ->addColumn('sku',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable'  =>  false,
    ),'sku product')
    ->addColumn('link',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable'  =>  false,
    ),'Image url')
    ->addColumn('start_datetime',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable'  =>  false,
    ),'Start data_time upload')
    ->addColumn('end_datetime',Varien_Db_Ddl_Table::TYPE_DATETIME,null,array(
        'nullable'  =>  false,
    ),'End data_time upload');

$installer->getConnection()->createTable($table);
$installer->endSetup();