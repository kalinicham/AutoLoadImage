<?php

class Tsg_AutoLoadImage_Adminhtml_Tsg_ImagesController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_redirect('*/catalog_product/index');
    }

    public function importAction()
    {
        $this->loadLayout();
        $this->_title($this->__("Import Images"));
        $this->_addContent($this->getLayout()->createBlock('tsg_autoloadimage/adminhtml_import_edit'));
        $this->renderLayout();
    }

    public function startAction()
    {
        $data = $this->getRequest()->getPost();
         if ($data) {
             /** @var Tsg_AutoLoadImage_Model_Import $importModel */
             $importModel = Mage::getModel('tsg_autoloadimage/import');
             try {
                 $importModel->importSource();
             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
             }
         }
        $this->_redirectReferer();
    }
}