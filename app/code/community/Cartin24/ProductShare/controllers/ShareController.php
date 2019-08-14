<?php
/**
 * Cartin24
 * @package    Cartin24_ProductShare
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
 
class Cartin24_ProductShare_ShareController extends Mage_Adminhtml_Controller_action
{
	 public function gridAction()
    {
    	$this->loadLayout();
    	$this->renderLayout();
    }
	
}
