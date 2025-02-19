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
 * @package     Enterprise_SalesArchive
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Order archive collection
 *
 * @category    Enterprise
 * @package     Enterprise_SalesArchive
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_SalesArchive_Model_Resource_Order_Collection extends Mage_Sales_Model_Resource_Order_Grid_Collection
{
    /**
     * Collection initialization
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setMainTable('enterprise_salesarchive/order_grid');
    }

    /**
     * Generate select based on order grid select for getting archived order fields.
     *
     * @param Zend_Db_Select $gridSelect
     * @return Zend_Db_Select
     */
    public function getOrderGridArchiveSelect(Zend_Db_Select $gridSelect)
    {
        $select = clone $gridSelect;
        $select->reset('from');
        $select->from(array('main_table' => $this->getTable('enterprise_salesarchive/order_grid')), array());
        return $select;
    }
}
