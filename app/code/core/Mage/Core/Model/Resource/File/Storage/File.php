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


/**
 * Model for synchronization from DB to filesystem
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Core_Model_Resource_File_Storage_File
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_mediaBaseDirectory = null;

    /**
     * List of files/directories that should be ignored when cleaning and reading files from the filesystem
     * @var array
     */
    protected $_ignoredFiles;

    /**
     * Files at storage
     *
     * @var array
     */
    public function getMediaBaseDirectory()
    {
        if (is_null($this->_mediaBaseDirectory)) {
            $this->_mediaBaseDirectory = Mage::helper('core/file_storage_database')->getMediaBaseDir();
        }

        return $this->_mediaBaseDirectory;
    }

    /**
     * Collect files and directories recursively
     *
     * @param  string$dir
     * @return array
     */
    public function getStorageData($dir = '')
    {
        $files          = array();
        $directories    = array();
        $currentDir     = $this->getMediaBaseDirectory() . $dir;
        $ignoredFiles = array_merge(array('.', '..'), $this->_getIgnoredFiles());

        if (is_dir($currentDir)) {
            $dh = opendir($currentDir);
            if ($dh) {
                while (($file = readdir($dh)) !== false) {
                    if (in_array($file, $ignoredFiles)) {
                        continue;
                    }

                    $fullPath = $currentDir . DS . $file;
                    $relativePath = $dir . DS . $file;
                    if (is_dir($fullPath)) {
                        $directories[] = array(
                            'name' => $file,
                            'path' => str_replace(DS, '/', ltrim($dir, DS))
                        );

                        $data = $this->getStorageData($relativePath);
                        $directories = array_merge($directories, $data['directories']);
                        $files = array_merge($files, $data['files']);
                    } else {
                        $files[] = $relativePath;
                    }
                }
                closedir($dh);
            }
        }

        return array('files' => $files, 'directories' => $directories);
    }

    /**
     * Clear files and directories in storage
     *
     * @param  string $dir
     * @return Mage_Core_Model_Mysql4_File_Storage_File
     */
    public function clear($dir = '')
    {
        $currentDir = $this->getMediaBaseDirectory() . $dir;
        $ignoredFiles = array_merge(array('.', '..'), $this->_getIgnoredFiles());

        if (is_dir($currentDir)) {
            $dh = opendir($currentDir);
            if ($dh) {
                while (($file = readdir($dh)) !== false) {
                    if (in_array($file, $ignoredFiles)) {
                        continue;
                    }

                    $fullPath = $currentDir . DS . $file;
                    if (is_dir($fullPath)) {
                        $this->clear($dir . DS . $file);
                    } else {
                        @unlink($fullPath);
                    }
                }
                closedir($dh);
                @rmdir($currentDir);
            }
        }

        return $this;
    }

    /**
     * Returns list of files/directories that should be ignored when cleaning and reading files from the filesystem
     * @return array
     */
    protected function _getIgnoredFiles()
    {
        if (null === $this->_ignoredFiles) {
            $ignored = (string)Mage::app()->getConfig()
                ->getNode(Mage_Core_Model_File_Storage::XML_PATH_MEDIA_RESOURCE_IGNORED);
            $this->_ignoredFiles = $ignored ? explode(',', $ignored) : array();
        }
        return $this->_ignoredFiles;
    }

    /**
     * Save directory to storage
     *
     * @param  array $dir
     * @return bool
     */
    public function saveDir($dir)
    {
        if (!isset($dir['name']) || !strlen($dir['name'])
            || !isset($dir['path'])
        ) {
            return false;
        }

        $path = (strlen($dir['path']))
            ? $dir['path'] . DS . $dir['name']
            : $dir['name'];
        $path = Mage::helper('core/file_storage_database')->getMediaBaseDir() . DS . str_replace('/', DS, $path);

        if (!file_exists($path) || !is_dir($path)) {
            if (!@mkdir($path, 0777, true)) {
                Mage::throwException(Mage::helper('core')->__('Unable to create directory: %s', $path));
            }
        }

        return true;
    }

    /**
     * Save file to storage
     *
     * @param  string $filePath
     * @param  string $content
     * @param  bool $overwrite
     * @return bool
     */
    public function saveFile($filePath, $content, $overwrite = false)
    {
        $filename = basename($filePath);
        $path = $this->getMediaBaseDirectory() . DS . str_replace('/', DS ,dirname($filePath));

        if (!file_exists($path) || !is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        $ioFile = new Varien_Io_File();
        $ioFile->cd($path);

        if (!$ioFile->fileExists($filename) || ($overwrite && $ioFile->rm($filename))) {
            $ioFile->streamOpen($filename);
            $ioFile->streamLock(true);
            $result = $ioFile->streamWrite($content);
            $ioFile->streamUnlock();
            $ioFile->streamClose();

            if ($result !== false) {
                return true;
            }

            Mage::throwException(Mage::helper('core')->__('Unable to save file: %s', $filePath));
        }

        return false;
    }
}
