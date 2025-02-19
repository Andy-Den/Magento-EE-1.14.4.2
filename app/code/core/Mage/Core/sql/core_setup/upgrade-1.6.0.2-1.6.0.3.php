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
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$connection = $installer->getConnection();
$table = $installer->getTable('core/translate');

$connection->dropIndex($table, $installer->getIdxName(
    'core/translate',
    array('store_id', 'locale', 'string'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
));

$connection->addColumn($table, 'crc_string', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_BIGINT,
    'nullable' => false,
    'default'  => crc32(Mage_Core_Model_Translate::DEFAULT_STRING),
    'comment'  => 'Translation String CRC32 Hash',
));

$connection->addIndex($table, $installer->getIdxName(
    'core/translate',
    array('store_id', 'locale', 'crc_string', 'string'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
), array('store_id', 'locale', 'crc_string', 'string'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE);

$installer->endSetup();
