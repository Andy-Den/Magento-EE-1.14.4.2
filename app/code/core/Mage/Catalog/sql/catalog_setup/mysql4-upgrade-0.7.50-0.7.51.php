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

/* @var $this Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$this->startSetup();

$this->getConnection()->addColumn($this->getTable('catalog_category_entity'), 'children_count', 'INT NOT NULL');

$sql    = "SELECT * FROM `{$this->getTable('catalog_category_entity')}`";
$data   = $this->getConnection()->fetchAll($sql);

foreach ($data as $row) {
    $sql    = "SELECT COUNT(*) FROM `{$this->getTable('catalog_category_entity')}` WHERE `path` REGEXP '^{$row['path']}\/([0-9]+)$'";
    $count  = (int) $this->getConnection()->fetchOne($sql);

    $this->run("UPDATE `{$this->getTable('catalog_category_entity')}`
        SET `children_count` = $count
        WHERE `entity_id` = {$row['entity_id']}");
}

$this->endSetup();
