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

namespace Enterprise\Connect\Test\TestCase;

use Enterprise\Connect\Test\Constraint\AssertChannelTextPresent;
use Mage\Admin\Test\Fixture\User;
use Mage\Connect\Test\Fixture\Connect;
use Mage\Connect\Test\Page\ConnectManager;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;


class UpgradeTest extends Injectable
{
    /* tags */
    const TEST_TYPE = 'upgrade';
    /* end tags */

    /**
     * Connect Manager page.
     *
     * @var ConnectManager
     */
    protected $connectManagerPage;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Prepare configuration settings for test.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->fixtureFactory = $fixtureFactory;
        $config = \Magento\Mtf\ObjectManagerFactory::getObjectManager()->get('Magento\Mtf\Config\GlobalConfig');
        $adminCred['username'] = $config->get('application/0/backendLogin/0/value');
        $adminCred['password'] = $config->get('application/0/backendPassword/0/value');
        $newVersion['Mage_All_Latest'] = $config->get('version/0/value');
        $adminFixture = $this->fixtureFactory->createByCode('user', ['data' => $adminCred]);
        $connectFixture = $this->fixtureFactory->createByCode('connect',
            ['dataset' => 'enterpise_connect', 'data' => $newVersion]);
        return ['adminUser' => $adminFixture, 'connect' => $connectFixture];
    }

    /**
     * Injection data.
     *
     * @param ConnectManager $connectManagerPage
     */
    public function __inject(
        ConnectManager $connectManagerPage
    )
    {
        $this->connectManagerPage = $connectManagerPage;
    }

    /**
     * Upgrade Magento via Magento Connect Manager.
     *
     * @param AssertChannelTextPresent $assertChannelTextPresent
     * @param User $adminUser
     * @param Connect $connect
     * @return array
     */
    public function test(AssertChannelTextPresent $assertChannelTextPresent, User $adminUser, Connect $connect)
    {
        $this->connectManagerPage->open();
        $this->connectManagerPage->getConnectLogin()->loginToConnectManager($adminUser);
        $this->connectManagerPage->getConnectNavigation()->openSettingsTabs();
        $this->connectManagerPage->getConnectSettings()->setChannelCred($connect);
        $this->connectManagerPage->getMessages()->getSuccessMessages();
        $this->connectManagerPage->getConnectNavigation()->openExtensionsTabs();
        $assertChannelTextPresent->processAssert($this->connectManagerPage);
        $this->connectManagerPage->getConnectContent()->checkForUpgrades();
        $this->connectManagerPage->getConnectContent()->selectPackages($connect);
        $this->connectManagerPage->getConnectContent()->commitChanges();
    }
}
