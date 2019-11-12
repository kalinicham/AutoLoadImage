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
        /**
         * @var Tsg_AutoLoadImage_Helper_Check $helperCheck
         * @var Tsg_AutoLoadImage_Helper_Data $helperData
         * @var Mage_Catalog_Model_Product $product
         */

        $helperCheck = Mage::helper('tsg_autoloadimage/check');
        $helperData = Mage::helper('tsg_autoloadimage/data');

        $uploadedFile = $_FILES['filename']['tmp_name'];
        $handle = fopen($uploadedFile, "r");
        if ($handle === false) {
            Mage::throwException(
                Mage::helper('tsg_autoloadimage/data')->__('Unable to open CSV file')
            );

            return;
        }

        $headFile = fgetcsv($handle, 1000, ",");
        $nonExist = $helperCheck->checkField($headFile);

        if ($nonExist !== '')
        {
            Mage::throwException(
                Mage::helper('tsg_autoloadimage/data')->__('No field(s) found in the file - ') .$nonExist
            );

            return;
        }

        $product = Mage::getModel('catalog/product');
        $numberLine = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $numberLine++;
            /** @var Tsg_AutoLoadImage_Model_Import $importData */
            $importData = Mage::getModel('tsg_autoloadimage/import');
            $item = 0;
            foreach ($headFile as $value) {
                $importData->setData($value,$data[$item]);
                $item++;
            }
            $sku = $importData->getSku();
            $id = $product->getIdBySku($sku);
            if ($id) {
                $checkLink = $helperCheck->checkLink($importData->getLink());
                if ($checkLink) {
                    $importData->setData('id_product',$id);
                    $importData->setData('start_datetime',Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));
                    $importData->save();
                }else{
                    Mage::getSingleton('adminhtml/session')->addError(
                        $helperData->__("Error line: $numberLine - The link in the is not an image")
                    );
//                Mage::log("Error line: $numberLine - The link in the is not an image",null,'tsg_import.log');
                }
            }else{

                Mage::getSingleton('adminhtml/session')->addError(
                    $helperData->__("Error line: $numberLine - Unknown value $sku")
                );
//                Mage::log("Error line: $numberLine - Unknown value $sku",null,'tsg_import.log');
            }
        }
        fclose($handle);
        Mage::getSingleton('adminhtml/session')->addSuccess('The file imported.');
    }

}

