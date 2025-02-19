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

use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Checkout\Test\Page\Adminhtml\CheckoutAgreementNew;
use Mage\Checkout\Test\Fixture\CheckoutAgreement;

/**
 * Fill and save checkout agreement step.
 */
class FillAndSaveCheckoutAgreementStep implements TestStepInterface
{
    /**
     * Checkout agreement new page.
     *
     * @var CheckoutAgreementNew
     */
    protected $agreementNew;

    /**
     * CheckoutAgreement fixture.
     *
     * @var CheckoutAgreement
     */
    protected $checkoutAgreement;

    /**
     * @constructor
     * @param CheckoutAgreementNew $agreementNew
     * @param CheckoutAgreement $checkoutAgreement
     */
    public function __construct(CheckoutAgreementNew $agreementNew, CheckoutAgreement $checkoutAgreement)
    {
        $this->agreementNew = $agreementNew;
        $this->checkoutAgreement = $checkoutAgreement;
    }

    /**
     * Fill and save checkout agreement step.
     *
     * @return array
     */
    public function run()
    {
        $this->agreementNew->getAgreementsForm()->fill($this->checkoutAgreement);
        $this->agreementNew->getPageActionsBlock()->save();

        return ['checkoutAgreement' => $this->checkoutAgreement];
    }
}
