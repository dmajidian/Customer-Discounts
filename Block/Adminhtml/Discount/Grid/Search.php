<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
 class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Search extends Mage_Adminhtml_Block_Widget_Form
 {
     public function _construct()
     {
         parent::_construct();
         //$this->setTemplate('vendor/productuploader/form.php');
     }

     protected function _prepareForm()
     {
         $form = new Varien_Data_Form(array(
             'id'     => 'edit_form',
             'method' => 'post',
             'action' => $this->getUrl('*/*/search', array('_current' => true)),
         ));

         $fieldset = $form->addFieldset('my_fieldset', array('legend' => 'Search'));
         $fieldset->addField('email', 'text', array(
             'label' => 'Email',
             'name'  => 'email',
             'required' => true,
             'value' => '',
         ));
         $fieldset->addField('submit', 'submit', array(
             'required'  => true,
             'value'  => 'Search',
             'class' => 'searchButton',
          /*   'after_element_html' => '<small>Press to search</small>',*/
             'tabindex' => 1
         ));
         $this->setForm($form);
         $form->setUseContainer(true);

         return parent::_prepareForm();
     }
 }
