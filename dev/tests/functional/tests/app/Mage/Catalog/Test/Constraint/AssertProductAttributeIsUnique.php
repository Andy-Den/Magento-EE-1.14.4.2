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

use Magento\Mtf\Constraint\AbstractConstraint;
use Mage\Catalog\Test\Fixture\CatalogProductAttribute;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductAttributeNew;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductAttributeIndex;

/**
 * Check whether the attribute is unique.
 */
class AssertProductAttributeIsUnique extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Expected message.
     */
    const UNIQUE_MESSAGE = 'Attribute with the same code already exists';

    /**
     * Check whether the attribute is unique.
     *
     * @param CatalogProductAttribute $attribute
     * @param CatalogProductAttributeNew $attributeNew
     * @param CatalogProductAttributeIndex $catalogProductAttributeIndex
     * @return void
     */
    public function processAssert(
        CatalogProductAttribute $attribute,
        CatalogProductAttributeNew $attributeNew,
        CatalogProductAttributeIndex $catalogProductAttributeIndex
    ) {
        $catalogProductAttributeIndex->open();
        $catalogProductAttributeIndex->getPageActionsBlock()->addNew();
        $attributeNew->getAttributeForm()->fill($attribute);
        $attributeNew->getPageActions()->saveAndContinue();

        $actualMessage = $attributeNew->getMessagesBlock()->getErrorMessages();
        \PHPUnit_Framework_Assert::assertEquals(self::UNIQUE_MESSAGE, $actualMessage);
    }

    /**
     * Return string representation of object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Attribute is unique.';
    }
}
