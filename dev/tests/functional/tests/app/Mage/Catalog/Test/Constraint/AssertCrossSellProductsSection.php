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

use Mage\Catalog\Test\Fixture\CatalogProductSimple;
use Mage\Catalog\Test\Page\Product\CatalogProductView;
use Mage\Checkout\Test\Page\CheckoutCart;
use Magento\Mtf\Client\Browser;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Assert that products are displayed in cross-sell section.
 */
class AssertCrossSellProductsSection extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'middle';
    /* end tags */

    /**
     * Assert that products are displayed in cross-sell section.
     *
     * @param Browser $browser
     * @param CheckoutCart $checkoutCart
     * @param CatalogProductSimple $product
     * @param CatalogProductView $catalogProductView
     * @param InjectableFixture[] $crossSellProducts
     * @return void
     */
    public function processAssert(
        Browser $browser,
        CheckoutCart $checkoutCart,
        CatalogProductSimple $product,
        CatalogProductView $catalogProductView,
        array $crossSellProducts
    ) {
        $checkoutCart->open()->getCartBlock()->clearShoppingCart();

        $browser->open($_ENV['app_frontend_url'] . $product->getUrlKey() . '.html');
        $catalogProductView->getViewBlock()->addToCart($product);
        $errors = [];
        $crosssellBlock = $checkoutCart->getCrosssellBlock();
        foreach ($crossSellProducts as $crossSellProduct) {
            if (!$crosssellBlock->getItemBlock($crossSellProduct)->isVisible()) {
                $errors[] = "Product {$crossSellProduct->getName()} is absent in cross-sell section.";
            }
        }

        \PHPUnit_Framework_Assert::assertEmpty($errors, implode(" ", $errors));
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products are displayed in cross-sell section.';
    }
}
