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

namespace Mage\Review\Test\TestCase;

use Magento\Mtf\TestCase\Scenario;

/**
 * Preconditions:
 * 1. Create simple product.
 * 2. Create custom rating type.
 *
 * Steps:
 * 1. Open frontend.
 * 2. Go to product page.
 * 3. Click "Be the first to review this product".
 * 4. Fill data according to dataset.
 * 5. Click "Submit review".
 * 6. Perform all assertions.
 *
 * @group Reviews_and_Ratings_(MX)
 * @ZephyrId MPERF-7382
 */
class CreateProductReviewFrontendEntityTest extends Scenario
{
    /**
     * Run create frontend product rating test.
     *
     * @return void
     */
    public function test() {
        $this->executeScenario();
    }

    /**
     * Delete all ratings after test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->objectManager->create('Mage\Review\Test\TestStep\DeleteAllRatingsStep')->run();
    }
}
