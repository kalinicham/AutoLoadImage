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
        $uploadItem = Mage::getModel('tsg_autoloadimage/import')
            ->getCollection()
            ->addFieldToFilter('status',array('in'=>array(self::QUEUE,self::RETRY)))
            ->setOrder('start_datetime','ASC')
            ->getFirstItem();

        if (Mage::helper('tsg_autoloadimage/check')->checkDir()) {

            $product = Mage::getModel('catalog/product');
            $id = $product->getIdBySku($uploadItem->getSku());
            $product->load($id);
            $dateTime = Mage::getModel('core/date')->date('Y-m-d H:i:s');
            $urlToImage = $uploadItem->getLink();
            $importDir = Mage::getBaseDir('media') . DS . $this->catalog . DS ;
            $filename = basename($urlToImage);
            $completeSaveLoc = $importDir.$filename;
                try {
                   if (!file_exists($completeSaveLoc)) {
                       file_put_contents($completeSaveLoc, file_get_contents($urlToImage));
                   }else {
                       file_put_contents($completeSaveLoc,$completeSaveLoc);
                   }
                }catch (Exception $e){
                    $error = "The link $urlToImage does not work ($dateTime) - $e";
                    Mage::log($error,null,'tsg_import_image.log');

                    ($urlToImage->getStatus() == self::RETRY) ? $uploadItem->setStatus(self::ERROR) : $uploadItem->setStatus(self::RETRY);

                    return;
                }


            try {
                $product->addImageToMediaGallery($completeSaveLoc, array('image','thumbnail','small_image'), true);
                $product->save();
                $uploadItem->setStatus(self::UPLOADED);
                $uploadItem->setData('end_datetime',Mage::getModel('core/date')->date('Y-m-d H:i:s'));
                $uploadItem->save();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }
}
