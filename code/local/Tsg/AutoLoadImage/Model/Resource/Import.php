<?php

class Tsg_AutoLoadImage_Model_Resource_Import extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_autoloadimage/import_image','id');
    }
}
