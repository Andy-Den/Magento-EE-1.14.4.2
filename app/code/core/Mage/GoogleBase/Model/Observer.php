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
 * @package     Mage_GoogleBase
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Google Base Observer
 *
 * @deprecated after 1.5.1.0
 * @category    Mage
 * @package     Mage_GoogleBase
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_GoogleBase_Model_Observer
{
    /**
     * Update product item in Google Base
     *
     * @param Varien_Object $observer
     * @return Mage_GoogleBase_Model_Observer
     */
    public function saveProductItem($observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            if (Mage::getStoreConfigFlag('google/googlebase/observed', $product->getStoreId())) {
                $collection = Mage::getResourceModel('googlebase/item_collection')
                    ->addProductFilterId($product->getId())
                    ->load();
                foreach ($collection as $item) {
                    $product = Mage::getSingleton('catalog/product')
                        ->setStoreId($item->getStoreId())
                        ->load($item->getProductId());
                    Mage::getModel('googlebase/item')->setProduct($product)->updateItem();
                }
            }
        } catch (Exception $e) {
            if (Mage::app()->getStore()->isAdmin()) {
                Mage::getSingleton('adminhtml/session')->addNotice(
                    Mage::helper('googlebase')->__("Cannot update Google Base Item for Store '%s'", Mage::app()->getStore($item->getStoreId())->getName())
                );
            } else {
                throw $e;
            }
        }
        return $this;
    }

    /**
     * Delete product item from Google Base
     *
     * @param Varien_Object $observer
     * @return Mage_GoogleBase_Model_Observer
     */
    public function deleteProductItem($observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            if (Mage::getStoreConfigFlag('google/googlebase/observed', $product->getStoreId())) {
                $collection = Mage::getResourceModel('googlebase/item_collection')
                    ->addProductFilterId($product->getId())
                    ->load();
                foreach ($collection as $item) {
                    $item->deleteItem()->delete();
                }
            }
        } catch (Exception $e) {
            if (Mage::app()->getStore()->isAdmin()) {
                Mage::getSingleton('adminhtml/session')->addNotice(
                    Mage::helper('googlebase')->__("Cannot update Google Base Item for Store '%s'", Mage::app()->getStore($item->getStoreId())->getName())
                );
            } else {
                throw $e;
            }
        }
        return $this;
    }
}
