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

/* @var $installer Mage_Sales_Model_Entity_Setup */
$installer = $this;
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order_grid'), 'updated_at', 'datetime default NULL');
$installer->getConnection()->addKey($installer->getTable('sales_flat_order_grid'), 'IDX_UPDATED_AT' ,'updated_at');
$installer->run("
    UPDATE {$installer->getTable('sales_flat_order_grid')} AS g
        JOIN {$installer->getTable('sales_flat_order')} AS o ON g.entity_id=o.entity_id
        SET g.updated_at=o.updated_at
");
