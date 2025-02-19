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

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Payment\Test\Fixture\Cc;
use Magento\Mtf\ObjectManager;

/**
 * Selecting payment method.
 */
class SelectPaymentMethodStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Payment information.
     *
     * @var string
     */
    protected $payment;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param CheckoutOnepage $checkoutOnepage
     * @param array $payment
     */
    public function __construct(FixtureFactory $fixtureFactory, CheckoutOnepage $checkoutOnepage, array $payment)
    {
        $this->checkoutOnepage = $checkoutOnepage;
        if (isset($payment['cc']) && !($payment['cc'] instanceof Cc)) {
            $payment['cc'] = $fixtureFactory->create('Mage\Payment\Test\Fixture\Cc', ['dataset' => $payment['cc']]);
        }
        $this->payment = $payment;
    }

    /**
     * Run step that selecting payment method.
     *
     * @return array
     */
    public function run()
    {
        if ($this->payment['method'] !== 'free') {
            $this->checkoutOnepage->getPaymentMethodsBlock()->selectPaymentMethod($this->payment);
        }
        $this->checkoutOnepage->getPaymentMethodsBlock()->clickContinue();

        return ['payment' => $this->payment];
    }
}
