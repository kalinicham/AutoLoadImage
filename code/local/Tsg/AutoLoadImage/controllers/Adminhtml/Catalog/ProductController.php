<?php

class Tsg_AutoLoadImage_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function importAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}