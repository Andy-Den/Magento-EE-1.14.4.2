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

namespace Mage\Sales\Test\TestStep;

use Mage\Sales\Test\Fixture\Order;
use Mage\Sales\Test\Page\Adminhtml\SalesOrderIndex;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Open order step.
 */
class OpenOrderStep implements TestStepInterface
{
    /**
     * Sales order index page.
     *
     * @var SalesOrderIndex
     */
    protected $orderIndex;

    /**
     * Order instance.
     *
     * @var Order
     */
    protected $order;

    /**
     * @constructor
     * @param Order $order
     * @param SalesOrderIndex $orderIndex
     */
    public function __construct(Order $order, SalesOrderIndex $orderIndex)
    {
        $this->orderIndex = $orderIndex;
        $this->order = $order;
    }

    /**
     * Open order.
     *
     * @return void
     */
    public function run()
    {
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $this->order->getId()]);
    }
}
