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

namespace Mage\Checkout\Test\TestStep;

use Mage\Catalog\Test\Page\Product\CatalogProductView;
use Mage\Checkout\Test\Page\CheckoutCart;
use Magento\Mtf\Client\Browser;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Adding created products to the cart.
 */
class AddProductsToTheCartStep implements TestStepInterface
{
    /**
     * Array with products.
     *
     * @var array
     */
    protected $products;

    /**
     * Frontend product view page.
     *
     * @var CatalogProductView
     */
    protected $catalogProductView;

    /**
     * Page of checkout page.
     *
     * @var CheckoutCart
     */
    protected $checkoutCart;

    /**
     * Interface Browser.
     *
     * @var Browser
     */
    protected $browser;

    /**
     * @constructor
     * @param CatalogProductView $catalogProductView
     * @param CheckoutCart $checkoutCart
     * @param Browser $browser
     * @param array $products
     */
    public function __construct(
        CatalogProductView $catalogProductView,
        CheckoutCart $checkoutCart,
        Browser $browser,
        array $products
    ) {
        $this->products = $products;
        $this->catalogProductView = $catalogProductView;
        $this->checkoutCart = $checkoutCart;
        $this->browser = $browser;
    }

    /**
     * Add products to the cart.
     *
     * @return void
     */
    public function run()
    {
        // Ensure that shopping cart is empty
        $this->checkoutCart->open()->getCartBlock()->clearShoppingCart();

        foreach ($this->products as $product) {
            $this->browser->open($_ENV['app_frontend_url'] . $product->getUrlKey() . '.html');
            $this->catalogProductView->getViewBlock()->addToCart($product);
            $this->catalogProductView->getMessagesBlock()->waitSuccessMessage();
        }
    }
}
