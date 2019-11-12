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
        /** @var Tsg_AutoLoadImage_Helper_Check $helperCheck */
        $helperCheck = Mage::helper('tsg_autoloadimage/check');

        $uploadedFile = $_FILES['filename']['tmp_name'];
        $handle = fopen($uploadedFile, "r");
        if ($handle === false) {
            Mage::throwException(
                Mage::helper('tsg_autoloadimage/data')->__('Unable to open CSV file')
            );

            return;
        }

        /** @var array|false|null $headFile */
        $headFile = fgetcsv($handle, 1000, ",");

        /** @var string $nonExist */
        $nonExist = $helperCheck->checkField($headFile);

        if ($nonExist !== '')
        {
            Mage::throwException(
                Mage::helper('tsg_autoloadimage/data')->__('No field(s) found in the file - ') .$nonExist
            );

            return;
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = Mage::getModel('catalog/product');
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            /** @var Tsg_AutoLoadImage_Model_Import $importData */
            $importData = Mage::getModel('tsg_autoloadimage/import');
            $item = 0;
            foreach ($headFile as $value) {
                $importData->setData($value,$data[$item]);
                $item++;
            }
            $id = $product->getIdBySku($importData->getSku());
            if ($id) {
               $checkLink = $helperCheck->checkLink($importData->getLink());
                if ($checkLink) {
                    $importData->setData('id_product',$id);
                    $importData->setData('start_datetime',Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));
                    $importData->save();
                }
            }
        }
        fclose($handle);
    }

}

