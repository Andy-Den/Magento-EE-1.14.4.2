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

namespace Enterprise\Reward\Test\Fixture\RewardRate;

use Mage\Customer\Test\Fixture\CustomerGroup as CustomerGroupFixture;
use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Prepare data for customer_group_id field in reward fixture.
 *
 * Data keys:
 *  - dataset
 */
class CustomerGroup extends DataSource
{
    /**
     * Customer Group fixture.
     *
     * @var CustomerGroupFixture
     */
    protected $customerGroup;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            /** @var CustomerGroupFixture $customerGroup */
            $customerGroup = $fixtureFactory->createByCode('customerGroup', ['dataset' => $data['dataset']]);
            if (!$customerGroup->hasData('customer_group_id')) {
                $customerGroup->persist();
            }
            $this->customerGroup = $customerGroup;
            $this->data = $customerGroup->getCustomerGroupCode();
        }
    }

    /**
     * Return customer group fixture.
     *
     * @return CustomerGroupFixture
     */
    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }
}
