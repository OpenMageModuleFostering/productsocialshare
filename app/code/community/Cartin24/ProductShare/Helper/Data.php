
<?php

/**
 * Cartin24
 * @package    Cartin24_ProductShare
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Cartin24_ProductShare_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getStoreId()
	{
		return Mage::getSingleton('admin/session')->getUser()->getstore_id();	
	}
	
	
	public function getStore()
	{
		return mage::getModel('core/store')->load($this->getStoreId());
	}
	
	public function getWebsiteId()
	{
		return $this->getStore()->getWebsiteId();
	}
	
}
