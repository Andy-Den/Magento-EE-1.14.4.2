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
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Mage\Catalog\Test\Constraint;

use Mage\Catalog\Test\Fixture\CatalogCategory;
use Mage\Catalog\Test\Page\Adminhtml\CatalogCategoryIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that not displayed category in backend catalog category tree.
 */
class AssertCategoryAbsenceOnBackend extends AbstractConstraint
{
    /**
     * Assert that category is not displayed in backend catalog category tree.
     *
     * @param CatalogCategoryIndex $catalogCategoryIndex
     * @param CatalogCategory $category
     * @return void
     */
    public function processAssert(CatalogCategoryIndex $catalogCategoryIndex, CatalogCategory $category)
    {
        $catalogCategoryIndex->open();
        \PHPUnit_Framework_Assert::assertFalse(
            $catalogCategoryIndex->getTreeCategories()->isCategoryVisible($category),
            'Category is displayed in backend catalog category tree.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Category is not displayed in backend catalog category tree.';
    }
}
