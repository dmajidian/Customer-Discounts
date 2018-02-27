<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('aaglobal_discount_discount_form');
        $this->setTitle($this->__('Discount Information'));
    }



    protected function _prepareForm()
    {
        $model = Mage::registry('aaglobal_discount');
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            //'action'  => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => $this->__('Discount Details'),
            'class'     => 'fieldset-wide',
        ));

        if ($model->getId())
        {
            $fieldset->addField('id', 'hidden', array(
                'name'  => 'id',
                'value' => $model->getId(),
            ));
        }

        $fieldset->addType('customtype', 'AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Name');
        $fieldset->addField('containerCustomer', 'customtype', array(
            'name'      => 'containerCustomer',
            'value'     => $model->getCustomer(),
            'label'     => $this->__('Customer'),
            'index'     => ''
        ));

        $fieldset->addType('customtype', 'AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Products');
        $fieldset->addField('containerProducts', 'customtype', array(

            'value'     => $model->getSku(),
            'label'     => $this->__('Product(s)'),
            'index'     => 'sku',

        ));


        $fieldset->addType('customtype', 'AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Categories');
        $fieldset->addField('containerCategory', 'customtype', array(
            'name'      => 'containerCategory',
            'value'     => $model->getCategory(),

            'label'     => $this->__('Category(s)'),

        ));


        //$form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }  
}
