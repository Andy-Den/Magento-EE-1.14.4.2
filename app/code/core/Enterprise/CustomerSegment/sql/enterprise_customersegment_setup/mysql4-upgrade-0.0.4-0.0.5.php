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
 * @package     Enterprise_CustomerSegment
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

$installer = $this;
/* @var $installer Enterprise_CustomerSegment_Model_Mysql4_Setup */

$installer->startSetup();

$installer->run("
CREATE TABLE `{$this->getTable('enterprise_customersegment_customer')}` (
    `segment_id` int(10) unsigned NOT NULL,
    `customer_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->getConnection()->addConstraint('FK_ENTERPRISE_CUSTOMERSEGMENT_CUSTOMER_SEGMENT',
    $installer->getTable('enterprise_customersegment_customer'), 'segment_id',
    $installer->getTable('enterprise_customersegment_segment'), 'segment_id'
);

$installer->getConnection()->addConstraint('FK_ENTERPRISE_CUSTOMERSEGMENT_CUSTOMER_CUSTOMER',
    $installer->getTable('enterprise_customersegment_customer'), 'customer_id',
    $installer->getTable('customer_entity'), 'entity_id'
);

$installer->endSetup();
