<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

$installer = $this;

/* @var $installer Mage_Sales_Model_Entity_Setup */
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'subtotal_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'subtotal_canceled', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'tax_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'tax_canceled', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'shipping_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'shipping_canceled', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_subtotal_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_subtotal_canceled', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_tax_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_tax_canceled', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_shipping_refunded', 'decimal(12,4) NULL');
$installer->getConnection()->addColumn($this->getTable('sales_order'), 'base_shipping_canceled', 'decimal(12,4) NULL');

$installer->addAttribute('order', 'subtotal_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'subtotal_canceled', array('type'=>'static'));
$installer->addAttribute('order', 'tax_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'tax_canceled', array('type'=>'static'));
$installer->addAttribute('order', 'shipping_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'shipping_canceled', array('type'=>'static'));
$installer->addAttribute('order', 'base_subtotal_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'base_subtotal_canceled', array('type'=>'static'));
$installer->addAttribute('order', 'base_tax_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'base_tax_canceled', array('type'=>'static'));
$installer->addAttribute('order', 'base_shipping_refunded', array('type'=>'static'));
$installer->addAttribute('order', 'base_shipping_canceled', array('type'=>'static'));
