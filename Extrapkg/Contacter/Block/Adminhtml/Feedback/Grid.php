<?php

class Extrapkg_Contacter_Block_Adminhtml_Feedback_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('feedbackGrid');
      $this->setDefaultSort('contacter_id');      
      $this->setDefaultDir('DESC');
      $this->setData("feedbackGridfilter", array("type"=>4));
      Mage::getSingleton('adminhtml/session')->setData("feedbackGridfilter", array("type"=>4));
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('contacter/contacter')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('contacter_id', array(
          'header'    => Mage::helper('contacter')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'contacter_id',
      ));
	  
	  $this->addColumn('title', array(
          'header'    => Mage::helper('contacter')->__('Title'),
          'align'     =>'left',
		  'width'     => '20px',
          'index'     => 'title',
		  'type'      => 'options',
          'options'   => array(
              1 => Mage::helper('contacter')->__('Mr.'),
              2 => Mage::helper('contacter')->__('Mrs.'),
              3 => Mage::helper('contacter')->__('Miss'),
          ),
      ));
	  
	  $this->addColumn('first_name', array(
          'header'    => Mage::helper('contacter')->__('Name of customer'),
          'align'     =>'left',
		  'width'     => '150px',
          'index'     => 'first_name',
      ));
	  
	   $this->addColumn('tel', array(
          'header'    => Mage::helper('contacter')->__('Contact phone'),
          'align'     =>'left',
		  'width'     => '200px',
          'index'     => 'tel',
      ));
	  
	  $this->addColumn('email', array(
          'header'    => Mage::helper('contacter')->__('Contact email'),
          'align'     =>'left',
		  'width'     => '250px',
          'index'     => 'email',
      ));
	  
      $this->addColumn('subject', array(
          'header'    => Mage::helper('contacter')->__('Feedback ro Comment Subject'),
          'align'     =>'left',
          'index'     => 'subject',
      ));
      
     
      
      $this->addColumn('type', array(
          'header'    => Mage::helper('contacter')->__('Contact type'),
          'align'     =>'left',          
          'index'     => 'type',
          'type'      => 'options',
          'options'   => array(
              1 => Mage::helper('contacter')->__('Product Enquiry'),
              2 => Mage::helper('contacter')->__('Business Opportunities'),
              3 => Mage::helper('contacter')->__('Corporate Sales'),
              4 => Mage::helper('contacter')->__('Feedback & Comments'),
          ),
      ));
	  
	  $this->addColumn('created_time', array(
          'header'    => Mage::helper('contacter')->__('Creative time'),
          'align'     =>'left',
		  'type'      => 'datetime',
          'index'     => 'created_time',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('contacter')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('contacter')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  */
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('contacter')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('contacter')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('contacter')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('contacter')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('contacter_id');
        $this->getMassactionBlock()->setFormFieldName('contacter');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('contacter')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('contacter')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('contacter/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('contacter')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('contacter')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}