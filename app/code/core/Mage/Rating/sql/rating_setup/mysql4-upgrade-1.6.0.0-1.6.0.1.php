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
 * @package     Mage_Rating
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


$installer->getConnection()->changeColumn(
    $installer->getTable('rating/rating_option_vote'),
    'remote_ip_long',
    'remote_ip_long',
    'varbinary(16)'
);

$installer->getConnection()->changeColumn(
    $installer->getTable('rating/rating_option_vote'),
    'remote_ip',
    'remote_ip',
    'varchar(50)'
);

$installer->getConnection()->update(
    $installer->getTable('rating/rating_option_vote'),
    array(
         'remote_ip_long' => new Zend_Db_Expr('UNHEX(HEX(CAST(remote_ip_long as UNSIGNED INT)))')
    )
);

$installer->endSetup();

