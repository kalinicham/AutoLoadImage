<?php

class Tsg_AutoLoadImage_Model_Cron
{
    protected $catalog = 'upload';

    public function uploadImage()
    {
        $uploadItem = Mage::getModel('tsg_autoloadimage/import')->getCollection()
            ->addFieldToFilter('status',array('in'=>array(0,3)))
            ->setOrder('start_datetime','ASC')
            ->getFirstItem();
        if (Mage::helper('tsg_autoloadimage/check')->checkDir()) {
            $product = Mage::getModel('catalog/product');
            $id = $product->getIdBySku($uploadItem->getSku());
            $product->load($id);
            $urlToImage = $uploadItem->getLink();
            $importDir = Mage::getBaseDir('media') . DS . $this->catalog . DS ;
            $filename = basename($urlToImage);
            $completeSaveLoc = $importDir.$filename;

            if(!file_exists($completeSaveLoc)){
                try {
                    file_put_contents($completeSaveLoc,file_get_contents($urlToImage));
                }catch (Exception $e){
                    // файл не скачивается
                }
            }else{
                if ($uploadItem->getStatus() == '3') {
                    $uploadItem->setStatus('2');
                }else{
                    $uploadItem->setStatus('3');
                }
                return;
            }

            try {
                $product->addImageToMediaGallery($completeSaveLoc, array('image','thumbnail','small_image'), true);
                $product->save();
                $uploadItem->setStatus('1');
                $uploadItem->setData('end_datetime',Mage::getModel('core/date')->date('Y-m-d H:i:s'));
                $uploadItem->save();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }
}
