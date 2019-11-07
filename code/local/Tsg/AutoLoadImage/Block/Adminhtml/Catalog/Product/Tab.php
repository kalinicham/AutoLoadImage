<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Catalog_Product_Tab
    extends Mage_Adminhtml_Block_Template
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function _construct()
    {
        parent::_construct();
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Import Image');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Click here to add Surprise');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    public function getTabClass()
    {
        return 'ajax';
    }

    public function getSkipGenerateContent()
    {
        return true;
    }

    public function getTabUrl()
    {
        return $this->getUrl('*/*/import', array('_current' => true));
    }
}


