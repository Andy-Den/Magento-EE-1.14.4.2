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
 * @package     Enterprise_TargetRule
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/** @var Enterprise_TargetRule_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product',  'related_targetrule_position_limit', 'backend_model', 'enterprise_targetrule/catalog_product_attribute_backend_rule');
$installer->updateAttribute('catalog_product',  'related_targetrule_position_behavior', 'backend_model', 'enterprise_targetrule/catalog_product_attribute_backend_rule');
$installer->updateAttribute('catalog_product',  'upsell_targetrule_position_limit', 'backend_model', 'enterprise_targetrule/catalog_product_attribute_backend_rule');
$installer->updateAttribute('catalog_product',  'upsell_targetrule_position_behavior', 'backend_model', 'enterprise_targetrule/catalog_product_attribute_backend_rule');

$installer->endSetup();
