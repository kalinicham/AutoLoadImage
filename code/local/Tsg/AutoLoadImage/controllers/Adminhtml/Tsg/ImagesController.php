<?php

class Tsg_AutoLoadImage_Adminhtml_Tsg_ImagesController extends Mage_Adminhtml_Controller_Action
{
    public function importAction()
    {
        $this->loadLayout();
        $this->_title($this->__("Import Images"));
        $this->_addContent($this->getLayout()->createBlock('tsg_autoloadimage/adminhtml_import_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $param = $this->getRequest()->getParams('filename');

    }

}