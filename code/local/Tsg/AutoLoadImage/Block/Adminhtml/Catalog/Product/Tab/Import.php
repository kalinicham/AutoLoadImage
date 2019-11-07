<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Catalog_Product_Tab_Import extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('product');
        $this->setDefaultSort('sku');
        $this->setUseAjax(true);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/import', array('_current' => true));
    }

    protected function getCurrentAction() {
        return Mage::registry('surprise_block');
    }

  /*  protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_category') {
            $productIds = $this->getSelectedCategory();
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }*/

    public function _prepareCollection() {
        $collection = Mage::getModel('tsg_autoloadimage/import')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $helper = Mage::helper('cms');

        $this->addColumn('sku', array(
            'header'    => $helper->__('Sku'),
            'align'     => 'left',
            'index'     => 'sku',
            'width'     => '20'
        ));

        $this->addColumn('link', array(
            'header'    => $helper->__('Url Image'),
            'align'     => 'left',
            'index'     => 'link',
            'width'     => '80'
        ));

        $this->addColumn('start_datetime', array(
            'header'    => $helper->__('Start datetime'),
            'align'     => 'left',
            'index'     => 'start_datetime',
            'width'     => '20'
        ));

        $this->addColumn('end_datetime', array(
            'header'    => $helper->__('End date'),
            'align'     => 'left',
            'index'     => 'end_datetime',
            'width'     => '20'
        ));

        $this->addColumn('status', array(
            'header'    => $helper->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'width'     => '20',
            'type'      => 'options',
            'options'   => array(
                0       => $helper->__('Queue'),
                1       => $helper->__('Uploaded'),
                2       => $helper->__('Error'),
                3       => $helper->__('Retry'),
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getTabLabel()
    {
        return $this->__('Products');
    }

    public function getTabTitle()
    {
        return $this->__('Products');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}