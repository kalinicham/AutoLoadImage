<?php

class Tsg_AutoLoadImage_Block_Adminhtml_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Tsg_AutoLoadImage_Block_Adminhtml_Import_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/tsg_images/start'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset(
            'base_fieldset',  array(
            'legend' => Mage::helper('cms')->__('General information to Import'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('filename', 'file', array(
                'name'  => 'filename',
                'label' => 'Import file',
                'title' => 'Import file',
                'required' => true
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
