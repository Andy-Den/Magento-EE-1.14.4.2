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
 * @package     Mage_Api
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 *
 * @category   Mage
 * @package    Mage_Api
 * @author     Magento Core Team <core@magentocommerce.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$installer->run("
    CREATE TABLE `{$installer->getTable('api/session')}` (
        `user_id` mediumint(9) UNSIGNED NOT NULL,
        `logdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `sessid` varchar(40) NOT NULL DEFAULT '',
        KEY `API_SESSION_USER` (`user_id`),
        KEY `API_SESSION_SESSID` (`sessid`),
        CONSTRAINT `FK_API_SESSION_USER` FOREIGN KEY (`user_id`) REFERENCES `{$installer->getTable('api/user')}` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Api Sessions';
");

$insertStmt = "INSERT INTO
    `{$installer->getTable('api/session')}` (`user_id`, `logdate`, `sessid`)
    SELECT `user_id`, `logdate`, `sessid` FROM `{$installer->getTable('api/user')}`";
$installer->run($insertStmt);
$installer->getConnection()->dropColumn($installer->getTable('api/user'), 'logdate');
$installer->getConnection()->dropColumn($installer->getTable('api/user'), 'sessid');

$installer->endSetup();
