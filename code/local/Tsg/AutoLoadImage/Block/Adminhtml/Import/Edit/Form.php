<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset(
            'base_fieldset',  array(
            'legend' => Mage::helper('cms')->__('General information to Import'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('filename', 'file', array(
                'name'  => 'filename',
                'label' => Mage::helper('adminhtml')->__('Import file'),
                'required' => true,
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
