
<?php

/**
 * Cartin24
 * @package    Cartin24_ProductShare
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
 
class Cartin24_ProductShare_Block_Share_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
   public function __construct()
    {
        parent::__construct();
        $this->setId('ProductGrid');
        $this->_parentTemplate = $this->getTemplate();
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('updated_at');
    }

    protected function _getStore()
    {
        $storeId = $this->getRequest()->getParam('store');
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
    	
    	$storeId   = $this->getRequest()->getParam('store');
        $websiteId = Mage::getModel('core/store')->load($storeId)->getWebsiteId();

        $store = mage::getModel('core/store')->load($storeId); //$this->_getStore();
        
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*');
                
       
        if ($store->getId()) {
            $collection->addStoreFilter($store);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $storeId);
        }        
      
		$visibility = array(
		   Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
		   Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
		);
		$collection->addAttributeToFilter('visibility', $visibility);
        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
                
        return $this;
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField('websites',
                    'catalog/product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left');
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareColumns()
    {    	
       
        $this->addColumn('entity_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        ));
        
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('catalog')->__('Name'),
                'index' => 'name',
                'filter'    => 'productshare/widget_grid_column_filter_search'
        ));
 			$this->addColumn('image',
            array(
                'header'=> Mage::helper('catalog')->__('Image'),
                'index' => 'image',
                'width'     => '70',
         		 'renderer' => 'Cartin24_ProductShare_Block_Adminhtml_Share_Grid_Renderer_Image',
        ));
        
        $this->addColumn('sku',
            array(
                'header'=> Mage::helper('catalog')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
        ));
		
		$this->addColumn('type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '70px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_type')->getOptionArray(),
        ));

        $this->addColumn('status',
            array(
                'header'=> Mage::helper('catalog')->__('Status'),
                'width' => '70px',
                'index' => 'status',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
		
		$this->addColumn('updated_at',
            array(
                'header'=> Mage::helper('catalog')->__('Updated At'),
                'index' => 'updated_at',
        ));
		
		$this->addColumn('action', array(
            'header' => Mage::helper('sales')->__('Share'),
            'renderer'  => 'Cartin24_ProductShare_Block_Widget_Grid_Column_Renderer_ProductShare',
            'index' => 'content',
            'filter' => false,
            'align' => 'center'
        ));
        
        return parent::_prepareColumns();
    }
    
    public function getGridParentHtml() {
        $templateName = Mage::getDesign()->getTemplateFilename($this->_parentTemplate, array('_relative' => true));
        return $this->fetchView($templateName);
    }
}
