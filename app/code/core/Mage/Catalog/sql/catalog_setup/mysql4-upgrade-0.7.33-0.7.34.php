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
 * @package     Mage_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$select = $installer->getConnection()->select()
    ->from($installer->getTable('catalog_category_product'), array(
        'category_id',
        'product_id',
        'position',
        'cnt' => 'COUNT(product_id)'
    ))
    ->group('category_id')
    ->group('product_id')
    ->having('cnt > 1');
$rowSet = $installer->getConnection()->fetchAll($select);

foreach ($rowSet as $row) {
    $data = array(
        'category_id'   => $row['category_id'],
        'product_id'    => $row['product_id'],
        'position'      => $row['position']
    );
    $installer->getConnection()->delete($installer->getTable('catalog_category_product'), array(
        $installer->getConnection()->quoteInto('category_id = ?', $row['category_id']),
        $installer->getConnection()->quoteInto('product_id = ?', $row['product_id'])
    ));
    $installer->getConnection()->insert($installer->getTable('catalog_category_product'), $data);
}

$installer->run("
ALTER TABLE `{$installer->getTable('catalog_category_product')}`
    ADD UNIQUE `UNQ_CATEGORY_PRODUCT` (`category_id`, `product_id`);
");

$installer->endSetup();
