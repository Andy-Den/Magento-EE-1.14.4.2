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
 * @package     Mage_Downloadable
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$installer->addAttribute('catalog_product', 'links_exist', array(
        'type'                      => 'int',
        'backend'                   => '',
        'frontend'                  => '',
        'label'                     => '',
        'input'                     => '',
        'class'                     => '',
        'source'                    => '',
        'global'                    => true,
        'visible'                   => false,
        'required'                  => false,
        'user_defined'              => false,
        'default'                   => '0',
        'searchable'                => false,
        'filterable'                => false,
        'comparable'                => false,
        'visible_on_front'          => false,
        'unique'                    => false,
        'apply_to'                  => 'downloadable',
        'is_configurable'           => false,
        'used_in_product_listing'   => 1
    ));

$newAttributeId = $installer->getAttributeId('catalog_product', 'links_exist');
$entityTypeId = $installer->getEntityTypeId('catalog_product');
$newAttributeTable = $installer->getAttributeTable($entityTypeId, 'links_exist');

$defaultValue = 1;
$installer->run("
INSERT INTO `{$newAttributeTable}`
    (entity_id, entity_type_id, attribute_id, value)
     SELECT distinct product_id,
        '{$entityTypeId}' AS entity_type_id,
        '{$newAttributeId}' AS attribute_id,
        '{$defaultValue}' AS value
    FROM `{$installer->getTable('downloadable/link')}`
");

$installer->endSetup();
