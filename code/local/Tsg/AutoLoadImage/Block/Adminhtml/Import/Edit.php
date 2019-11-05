<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
     /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->_removeButton('delete')
            ->_removeButton('reset')
            ->_updateButton('save','label', $this->__('Import Data'))
            ->_updateButton('save', 'id', 'upload_button');
    }


    protected function _construct()
    {
        parent::_construct();

        $this->_objectId    = 'import_id';
        $this->_blockGroup  = 'tsg_autoloadimage';
        $this->_controller  = 'adminhtml_import';
    }

    public function getHeaderText()
    {
        return Mage::helper('tsg_autoloadimage')->__('Import Image');
    }
}