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
 * @package     Mage_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * SEO Categories Sitemap block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Seo_Sitemap_Category extends Mage_Catalog_Block_Seo_Sitemap_Abstract
{

    /**
     * Initialize categories collection
     *
     * @return Mage_Catalog_Block_Seo_Sitemap_Category
     */
    protected function _prepareLayout()
    {
        $helper = Mage::helper('catalog/category');
        /* @var $helper Mage_Catalog_Helper_Category */
        $collection = $helper->getStoreCategories('name', true, false);
        $this->setCollection($collection);
        return $this;
    }

    /**
     * Get item URL
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getItemUrl($category)
    {
        $helper = Mage::helper('catalog/category');
        /* @var $helper Mage_Catalog_Helper_Category */
        return $helper->getCategoryUrl($category);
    }

}
