<?php

class Tsg_AutoLoadImage_Model_Resource_Import_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('tsg_autoloadimage/import','id');
    }
}