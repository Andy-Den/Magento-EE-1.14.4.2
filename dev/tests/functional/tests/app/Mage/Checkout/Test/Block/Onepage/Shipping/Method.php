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

namespace Mage\Checkout\Test\Block\Onepage\Shipping;

use Mage\Checkout\Test\Block\Onepage\AbstractOnepage;
use Magento\Mtf\Client\Locator;

/**
 * One page checkout status shipping method block.
 */
class Method extends AbstractOnepage
{
    /**
     * Checkout loader selector.
     *
     * @var string
     */
    protected $waiterSelector = '[id^="shipping"].please-wait';

    /**
     * Shipping method label selector.
     *
     * @var string
     */
    protected $shippingMethodLabel = '//label[contains(., "%s")]';

    /**
     * Shipping method input selector.
     *
     * @var string
     */
    protected $shippingMethodInput = '//dt[contains(.,"%s")]/following-sibling::dd[1]//li[contains(., "%s")]//input';

    /**
     * Continue checkout button.
     *
     * @var string
     */
    protected $continue = '#shipping-method-buttons-container button';

    /**
     * Shipping form selector.
     *
     * @var string
     */
    protected $shippingForm = '#checkout-shipping-method-load';

    /**
     * Css selector for disable continue button.
     *
     * @var string
     */
    protected $disableButton = '//*[@id="shipping-method-buttons-container" and contains(@class,"disabled")]';

    /**
     * Select shipping method.
     *
     * @param array $method
     * @throws \Exception
     * @return void
     */
    public function selectShippingMethod(array $method)
    {
        $this->waitForElementVisible($this->shippingForm);
        $shippingInput = $this->_rootElement->find(
            sprintf($this->shippingMethodInput, $method['shipping_service'], $method['shipping_method']),
            Locator::SELECTOR_XPATH
        );
        if ($shippingInput->isVisible()) {
            $shippingInput->click();
        } else {
            $shippingLabel = $this->_rootElement->find(
                sprintf($this->shippingMethodLabel, $method['shipping_method']),
                Locator::SELECTOR_XPATH
            );
            if (!$shippingLabel->isVisible()) {
                throw new \Exception("{$method['shipping_service']} shipping doesn't exist.");
            }
        }
    }

    /**
     * Click continue button.
     *
     * @return void
     */
    public function clickContinue()
    {
        $this->waitForElementNotVisible($this->disableButton);
        parent::clickContinue();
    }
}
