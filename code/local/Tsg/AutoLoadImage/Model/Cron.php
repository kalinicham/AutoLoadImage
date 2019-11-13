<?php

class Tsg_AutoLoadImage_Model_Cron
{
    const QUEUE = 0;
    const UPLOADED = 1;
    const ERROR = 2;
    const RETRY = 3;

    protected $catalog = 'tmp';

    public function uploadImage()
    {
        /** @var Tsg_AutoLoadImage_Model_Import $uploadItems */
        $uploadItems = Mage::getModel('tsg_autoloadimage/import')
            ->getCollection()
            ->addFieldToFilter('status', array('in' => array(self::QUEUE, self::RETRY)))
            ->setOrder('status', 'ASC')
            ->setOrder('start_datetime', 'ASC')
            ->setPageSize(10);


        if ($uploadItems->count() > 0) {
            /** @var Tsg_AutoLoadImage_Helper_Check $helperCheck */
            $helperCheck = Mage::helper('tsg_autoloadimage/check');
            if (!$helperCheck->checkDir()) {

                return;
            }
            /** @var Mage_Catalog_Model_Product $product */
            $product = Mage::getModel('catalog/product');
            foreach ($uploadItems as $item) {
                $id = $item->getIdProduct();
                $product->load($id);
                $urlToImage = $item->getLink();
                $importDir = Mage::getBaseDir('media') . DS . $this->catalog . DS;
                $lastGalleryItemId = $product->getMediaGalleryImages()->getLastItem()->getId();
                $file_ext = ltrim(substr(basename($urlToImage), -4, 4), '.');
                $filename = "tsg_import_$id" . "_" . $item->getId() . "_$lastGalleryItemId.$file_ext";
                $completeFile = $importDir . $filename;
                /** @var Mage_Core_Model_Date $dateTime */
                $dateTime = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');

                if (file_get_contents($urlToImage) !== false) {
                    file_put_contents($completeFile, file_get_contents($urlToImage));
                }else {
                    $error = "The link $urlToImage does not work ($dateTime)";
                    Mage::log($error, null, 'tsg_import_image.log');
                    ($item->getStatus() == self::RETRY) ? $item->setStatus(self::ERROR) : $item->setStatus(self::RETRY);
                    $item->setData('end_datetime', $dateTime);
                    $item->save();

                    continue;
                }

                try {
                    $product->addImageToMediaGallery($completeFile, null, true,false);
                    $product->save();
                    $item->setStatus(self::UPLOADED);
                    $item->setData('end_datetime', $dateTime);
                    $item->save();
                } catch (Exception $e) {
                    Mage::log($e->getMessage());
                }
            }
        }
    }
}
