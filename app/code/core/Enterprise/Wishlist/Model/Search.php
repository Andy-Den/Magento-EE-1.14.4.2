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
 * @package     Enterprise_Wishlist
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Wishlist search module
 *
 * @category    Enterprise
 * @package     Enterprise_Wishlist
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Wishlist_Model_Search
{
    /**
     * Retrieve wishlist search results by search strategy
     *
     * @param Enterprise_Wishlist_Model_Search_Strategy_Interface $strategy
     * @return Mage_Wishlist_Model_Resource_Wishlist_Collection
     */
    public function getResults(Enterprise_Wishlist_Model_Search_Strategy_Interface $strategy)
    {
        /* @var Mage_Wishlist_Model_Resource_Wishlist_Collection $collection */
        $collection = Mage::getModel('wishlist/wishlist')->getCollection();
        $collection->addFieldToFilter('visibility', array('eq' => 1));
        $strategy->filterCollection($collection);
        return $collection;
    }
}
