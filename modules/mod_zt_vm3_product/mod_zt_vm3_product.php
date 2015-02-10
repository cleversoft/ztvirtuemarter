<?php
defined('_JEXEC') or die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
* featured/Latest/Topten/Random Products Module
*
* @version $Id: mod_zt_vm3_product.php 2789 2011-02-28 12:41:01Z oscar $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2010 - Patrick Kohl
* @copyright (C) 2011 - The VirtueMart Team
* @author Max Milbers, Valerie Isaksen, Alexander Steiner
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/


defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');

VmConfig::loadConfig();
VmConfig::loadJLang('mod_zt_vm3_product', true);

// Setting
$max_items = 		$params->get( 'max_items', 2 ); //maximum number of items to display
$layout = $params->get('layout','default');
$category_id = 		$params->get( 'virtuemart_category_id', null ); // Display products from this category only
$filter_category = 	(bool)$params->get( 'filter_category', 0 ); // Filter the category
$display_style = 	$params->get( 'display_style', "div" ); // Display Style
$products_per_row = $params->get( 'products_per_row', 1 ); // Display X products per Row
$show_price = 		(bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_addtocart = 	(bool)$params->get( 'show_addtocart', 1 ); // Display the "Add-to-Cart" Link?
$headerText = 		$params->get( 'headerText', '' ); // Display a Header Text
$footerText = 		$params->get( 'footerText', ''); // Display a footerText
$Product_group = 	$params->get( 'product_group', 'featured'); // Display a footerText

$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',vRequest::getInt('virtuemart_currency_id',0) );


/* Load  VM fonction */
if (!class_exists( 'mod_zt_vm3_product' )) require('helper.php');

$vendorId = vRequest::getInt('vendorid', 1);

if ($filter_category ) $filter_category = TRUE;

$productModel = VmModel::getModel('Product');

$products = $productModel->getProductListing($Product_group, $max_items, $show_price, true, false,$filter_category, $category_id);
$productModel->addImages($products);

$totalProd = 		count( $products);
if(empty($products)) return false;
$currency = CurrencyDisplay::getInstance( );

if ($show_addtocart) {
	vmJsApi::jPrice();
	vmJsApi::cssSite();
}
ob_start();

/* Load tmpl default */
require(JModuleHelper::getLayoutPath('mod_zt_vm3_product',$layout));
$output = ob_get_clean();

echo $output;
?>
