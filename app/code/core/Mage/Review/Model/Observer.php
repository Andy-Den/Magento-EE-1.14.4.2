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
 * @package     Mage_Review
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Review Observer Model
 *
 * @category   Mage
 * @package    Mage_Review
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Review_Model_Observer
{
    /**
     * Add review summary info for tagged product collection
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Review_Model_Observer
     */
    public function tagProductCollectionLoadAfter(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getCollection();
        Mage::getSingleton('review/review')
            ->appendSummary($collection);

        return $this;
    }

    /**
     * Cleanup product reviews after product delete
     *
     * @param   Varien_Event_Observer $observer
     * @return  Mage_CatalogIndex_Model_Observer
     */
    public function processProductAfterDeleteEvent(Varien_Event_Observer $observer)
    {
        $eventProduct = $observer->getEvent()->getProduct();
        if ($eventProduct && $eventProduct->getId()) {
            Mage::getResourceSingleton('review/review')->deleteReviewsByProductId($eventProduct->getId());
        }

        return $this;
    }

    /**
     * Append review summary before rendering html
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Review_Model_Observer
     */
    public function catalogBlockProductCollectionBeforeToHtml(Varien_Event_Observer $observer)
    {
        $productCollection = $observer->getEvent()->getCollection();
        if ($productCollection instanceof Varien_Data_Collection) {
            $productCollection->load();
            Mage::getModel('review/review')->appendSummary($productCollection);
        }

        return $this;
    }
}
