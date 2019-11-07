<?php

class Tsg_AutoLoadImage_Model_Import extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('tsg_autoloadimage/import');
    }

    public function importSource()
    {
        $uploadedFile = $_FILES['filename']['tmp_name'];
        $handle = fopen($uploadedFile, "r");
        if ($handle === false) {
            throw new Exception('Неможливо вікрити CSV-файл!');

            return;
        }
        $headFile = fgetcsv($handle, 1000, ",");
        $nonExist = Mage::helper('tsg_autoloadimage/check')->checkField($headFile);
        if ($nonExist !== '')
        {
            throw new Exception('В файлі не знайдено поля '. $nonExist);

            return;
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $item = 0;
            $importData = Mage::getModel('tsg_autoloadimage/import');
            foreach ($headFile as $value) {
                $importData->setData($value,$data[$item]);
                $item++;
            }
            $checkSku = Mage::helper('tsg_autoloadimage/check')->checkSku($importData->getSku());
            $checkLink = Mage::helper('tsg_autoloadimage/check')->checkLink($importData->getLink());
            if ($checkSku and $checkLink) {
                $importData->setData('start_datetime',Mage::getModel('core/date')->date('Y-m-d H:i:s'));
                $importData->save();
            }
        }
        fclose($handle);
    }

}

