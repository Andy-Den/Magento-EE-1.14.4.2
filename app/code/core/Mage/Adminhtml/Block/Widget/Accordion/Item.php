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
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Accordion item
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Widget_Accordion_Item extends Mage_Adminhtml_Block_Widget
{
    protected $_accordion;

    public function __construct()
    {
        parent::__construct();
    }

    public function setAccordion($accordion)
    {
        $this->_accordion = $accordion;
        return $this;
    }

    public function getTarget()
    {
        return ($this->getAjax()) ? 'ajax' : '';
    }

    public function getTitle()
    {
        $title  = $this->getData('title');
        $url    = $this->getContentUrl() ? $this->getContentUrl() : '#';
        $title  = '<a href="'.$url.'" class="'.$this->getTarget().'">'.$title.'</a>';

        return $title;
    }

    public function getContent()
    {
        $content = $this->getData('content');
        if (is_string($content)) {
            return $content;
        }
        if ($content instanceof Mage_Core_Block_Abstract) {
            return $content->toHtml();
        }
        return null;
    }

    public function getClass()
    {
        $class = $this->getData('class');
        if ($this->getOpen()) {
            $class.= ' open';
        }
        return $class;
    }

    protected function _toHtml()
    {
        $content = $this->getContent();
        $html = '<dt id="dt-'.$this->getHtmlId().'" class="'.$this->getClass().'">';
        $html.= $this->getTitle();
        $html.= '</dt>';
        $html.= '<dd id="dd-'.$this->getHtmlId().'" class="'.$this->getClass().'">';
        $html.= $content;
        $html.= '</dd>';
        return $html;
    }
}
