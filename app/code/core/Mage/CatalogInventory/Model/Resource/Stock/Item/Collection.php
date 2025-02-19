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
 * @package     Mage_CatalogInventory
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Stock item collection resource model
 *
 * @category    Mage
 * @package     Mage_CatalogInventory
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_CatalogInventory_Model_Resource_Stock_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('cataloginventory/stock_item');
    }

    /**
     * Add stock filter to collection
     *
     * @param mixed $stock
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function addStockFilter($stock)
    {
        if ($stock instanceof Mage_CatalogInventory_Model_Stock) {
            $this->addFieldToFilter('main_table.stock_id', $stock->getId());
        } else {
            $this->addFieldToFilter('main_table.stock_id', $stock);
        }
        return $this;
    }

    /**
     * Add product filter to collection
     *
     * @param array $products
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function addProductsFilter($products)
    {
        $productIds = array();
        foreach ($products as $product) {
            if ($product instanceof Mage_Catalog_Model_Product) {
                $productIds[] = $product->getId();
            } else {
                $productIds[] = $product;
            }
        }
        if (empty($productIds)) {
            $productIds[] = false;
            $this->_setIsLoaded(true);
        }
        $this->addFieldToFilter('main_table.product_id', array('in' => $productIds));
        return $this;
    }

    /**
     * Join Stock Status to collection
     *
     * @param int $storeId
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function joinStockStatus($storeId = null)
    {
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $this->getSelect()->joinLeft(
            array('status_table' => $this->getTable('cataloginventory/stock_status')),
                'main_table.product_id=status_table.product_id'
                . ' AND main_table.stock_id=status_table.stock_id'
                . $this->getConnection()->quoteInto(' AND status_table.website_id=?', $websiteId),
            array('stock_status')
        );

        return $this;
    }

    /**
     * Add Managed Stock products filter to collection
     *
     * @param boolean $isStockManagedInConfig
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function addManagedFilter($isStockManagedInConfig)
    {
        if ($isStockManagedInConfig) {
            $this->getSelect()->where('(manage_stock = 1 OR use_config_manage_stock = 1)');
        } else {
            $this->addFieldToFilter('manage_stock', 1);
        }

        return $this;
    }

    /**
     * Add filter by quantity to collection
     *
     * @param string $comparsionMethod
     * @param float $qty
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    public function addQtyFilter($comparsionMethod, $qty)
    {
        $methods = array(
            '<'  => 'lt',
            '>'  => 'gt',
            '='  => 'eq',
            '<=' => 'lteq',
            '>=' => 'gteq',
            '<>' => 'neq'
        );
        if (!isset($methods[$comparsionMethod])) {
            Mage::throwException(
                Mage::helper('cataloginventory')->__('%s is not a correct comparsion method.', $comparsionMethod)
            );
        }

        return $this->addFieldToFilter('main_table.qty', array($methods[$comparsionMethod] => $qty));
    }

    /**
     * Initialize select object
     *
     * @return Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
     */
    protected function _initSelect()
    {
        return parent::_initSelect()->getSelect()
            ->join(
                array('cp_table' => $this->getTable('catalog/product')),
                'main_table.product_id = cp_table.entity_id',
                array('type_id')
            );
    }
}
