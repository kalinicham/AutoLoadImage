<?php

use Varien_Event_Observer as Event;

class Tsg_AutoLoadImage_Model_Observer
{
     /**
     * @param Event $observer
     */

     public function addButtonImportImages (Event $observer)
     {
        $block = $observer->getBlock();
        if ($block->getType() == "adminhtml/catalog_product") {
            $block->addButton('add_import_image', array(
                'label'   => Mage::helper('catalog')->__('Import Image'),
                'onclick' => "setLocation('{$block->getUrl('*/tsg_images/import')}')",
                'class'   => 'button'
            ));
        }
     }
}
