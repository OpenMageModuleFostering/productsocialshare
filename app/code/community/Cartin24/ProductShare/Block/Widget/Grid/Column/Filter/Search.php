
<?php

/**
 * Cartin24
 * @package    Cartin24_ProductShare
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Cartin24_ProductShare_Block_Widget_Grid_Column_Filter_Search extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Text
{
    
    public function getCondition()
    {
        if ($this->getValue()) {
        	$value = $this->getValue();
        	$value = str_replace(' ', '%', $value);
        	$value = str_replace('-', '%', $value);
        	return array('like' => '%'.$value.'%');
        }
    }
}
