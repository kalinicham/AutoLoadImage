<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Catalog_Product_Tab_Renderer_Size extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $size = $row->getSize();
        if ($size/pow(1024,2) > 1) {

            return "<span>1.68 Mb</span>";
        }else{

            return "<span>423 kb</span>";
        }
    }
}
