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
 * @category    Enterprise
 * @package     Enterprise_Staging
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/** @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->changeColumn(
    $installer->getTable('enterprise_staging/staging_log'),
    'ip',
    'ip',
    'varbinary(16) COMMENT \'Ip\''
);

$installer->getConnection()->update(
    $installer->getTable('enterprise_staging/staging_log'),
    array(
         'ip' => new Zend_Db_Expr('UNHEX(HEX(CAST(ip as UNSIGNED INT)))')
    )
);

$installer->endSetup();
