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

namespace Mage\Catalog\Test\Fixture\CatalogAttributeSet;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;
use Mage\Catalog\Test\Fixture\CatalogProductAttribute;

/**
 * Preset for assigned attributes.
 *  Data keys:
 *  - dataset
 *  - attributes
 */
class AssignedAttributes extends DataSource
{
    /**
     * Assigned attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset']) && is_string($data['dataset'])) {
            $dataset = explode(',', $data['dataset']);
            foreach ($dataset as $preset) {
                /** @var CatalogProductAttribute $attribute */
                $attribute = $fixtureFactory->createByCode('catalogProductAttribute', ['dataset' => $preset]);
                $attribute->persist();

                $this->data[] = $attribute->getAttributeCode();
                $this->attributes[] = $attribute;
            }
        } elseif (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute) {
                /** @var CatalogProductAttribute $attribute */
                $this->data[] = $attribute->getAttributeCode();
                $this->attributes[] = $attribute;
            }
        } else {
            $this->data = $data;
        }
    }

    /**
     * Get Attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
