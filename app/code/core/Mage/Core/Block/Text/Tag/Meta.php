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
 * @category    Mage
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


class Mage_Core_Block_Text_Tag_Meta extends Mage_Core_Block_Text
{
    protected function _toHtml()
    {
        if (!$this->getContentType()) {
            $this->setContentType('text/html; charset=utf-8');
        }
        $this->addText('<meta http-equiv="Content-Type" content="'.$this->getContentType().'"/>'."\n");
        $this->addText('<title>'.$this->getTitle().'</title>'."\n");
        $this->addText('<meta name="title" content="'.$this->getTitle().'"/>'."\n");
        $this->addText('<meta name="description" content="'.$this->getDescription().'"/>'."\n");
        $this->addText('<meta name="keywords" content="'.$this->getKeywords().'"/>'."\n");
        $this->addText('<meta name="robots" content="'.$this->getRobots().'"/>'."\n");

        return parent::_toHtml();
    }
}
