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

namespace Mage\Paypal\Test\TestStep;

use Mage\Checkout\Test\Page\CheckoutOnepageSuccess;
use Mage\Paypal\Test\Fixture\PaypalCustomer;
use Mage\Paypal\Test\Page\Paypal;
use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Paypal\Test\Block\AbstractReview;

/**
 * Continue Pay Pal checkout step.
 */
class ContinuePayPalCheckoutStep implements TestStepInterface
{
    /**
     * Pay Pal page.
     *
     * @var Paypal
     */
    protected $paypalPage;

    /**
     * One page checkout success page.
     *
     * @var CheckoutOnepageSuccess
     */
    protected $checkoutOnepageSuccess;

    /**
     * PayPal customer.
     *
     * @var PaypalCustomer
     */
    protected $customer;

    /**
     * Review block.
     *
     * @var AbstractReview
     */
    protected $reviewBlock;

    /**
     * @constructor
     * @param Paypal $paypalPage
     * @param CheckoutOnepageSuccess $checkoutOnepageSuccess
     * @param PaypalCustomer $paypalCustomer
     */
    public function __construct(
        Paypal $paypalPage,
        CheckoutOnepageSuccess $checkoutOnepageSuccess,
        PaypalCustomer $paypalCustomer
    ) {
        $this->paypalPage = $paypalPage;
        $this->checkoutOnepageSuccess = $checkoutOnepageSuccess;
        $this->customer = $paypalCustomer;
    }

    /**
     * Continue Pay Pal checkout.
     *
     * @return array|null
     */
    public function run()
    {
        $reviewBlockIsPresent = false;
        $sleepingTime = 0;
        while (!$reviewBlockIsPresent and $sleepingTime <= 60) {
            sleep(1);
            $reviewBlockIsPresent = $this->paypalPage->getReviewBlock()->isVisible()
                or $this->paypalPage->getOldReviewBlock()->isVisible();
            $sleepingTime++;
        }
        $this->reviewBlock = $this->paypalPage->getReviewBlock()->isVisible()
            ? $this->paypalPage->getReviewBlock()
            : $this->paypalPage->getOldReviewBlock();
        $this->selectCustomerAddress($this->customer);
        $this->reviewBlock->continueCheckout();
        $successBlock = $this->checkoutOnepageSuccess->getSuccessBlock();

        return ['orderId' => $successBlock->isVisible() ? $successBlock->getGuestOrderId() : null];
    }

    /**
     * Select customer address.
     *
     * @param PaypalCustomer $customer
     * @return void
     */
    protected function selectCustomerAddress(PaypalCustomer $customer)
    {
        if ($this->reviewBlock->checkChangeAddressAbility()) {
            $address = $customer->getDataFieldConfig('address')['source']->getAddresses()[0];
            $this->reviewBlock->getAddressesBlock()->selectAddress($address);
            $this->reviewBlock->waitLoader();
        }
    }
}
