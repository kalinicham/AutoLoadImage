<?php

class Tsg_AutoLoadImage_Model_Import extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tsg_autoloadimage/import');
    }

    public static function getWorkingDir()
    {
        return Mage::getBaseDir('var') . DS . 'importexport' . DS;
    }

    public function importSource()
    {
        $uploadedFile = $_FILES['filename']['tmp_name'];
        $handle = fopen($uploadedFile, "r");
        $headFile = fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $item = 0;
            foreach ($headFile as $value) {
                $this->setData($value,$data[$item]);
                $item++;
            }
            $this->save();
        }
        fclose($handle);
    }

}

