<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Upload_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('aaglobal_discount_upload_form');
        $this->setTitle($this->__('Upload Discounts CSV'));

    }



    protected function _prepareForm()
    {
          $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            //'action'  => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'action'    => $this->getUrl('*/*/uploadcsv'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => $this->__('Upload Discounts CSV'),
            'class'     => 'fieldset-wide',
        ));
        $fieldset->addField('file', 'file', array(
            'label'     => $this->__('Fishbowl CSV (All Discounts)'),
            'class'     => 'disable',
            'required'  => true,
            'name'      => 'file',
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }  
}
