<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_headerText = 'Import Image';
    protected $_blockGroup = 'tsg_autoloadimage';
    protected $_controller = 'adminhtml_import';

    public function __construct()
    {
        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('*/tsg_images/save');
    }

}