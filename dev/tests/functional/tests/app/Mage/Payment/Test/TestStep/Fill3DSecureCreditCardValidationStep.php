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

namespace Mage\Payment\Test\TestStep;

use Mage\Checkout\Test\Page\CheckoutOnepage;
use Mage\Payment\Test\Fixture\ValidationPassword;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\ObjectManager;

/**
 * Fill 3D secure credit card validation.
 */
class Fill3DSecureCreditCardValidationStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Cc fixture.
     *
     * @var ValidationPassword
     */
    protected $validationPassword;

    /**
     * @constructor
     * @param CheckoutOnepage $checkoutOnepage
     * @param ValidationPassword $validationPassword
     */
    public function __construct(CheckoutOnepage $checkoutOnepage, ValidationPassword $validationPassword)
    {
        $this->checkoutOnepage = $checkoutOnepage;
        $this->validationPassword = $validationPassword;
    }

    /**
     * Fill 3D secure credit card validation.
     *
     * @return void
     */
    public function run()
    {
        $centinelForm = $this->checkoutOnepage->getReviewBlock()->getCentinelForm();
        $centinelForm->fillPass($this->validationPassword);
        $centinelForm->submitCode();
    }
}
