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
 * @package     Mage_System
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */
class Mage_System_Dirs
{

    public static function rm($dirname)
    {
        if(is_array($dirname)) {
            $dirname = $dirname[1];
        }
        // Sanity check
        if (!@file_exists($dirname)) {
            return false;
        }

        // Simple delete for a file
        if (@is_file($dirname) || @is_link($dirname)) {
            return unlink($dirname);
        }

        // Create and iterate stack
        $stack = array($dirname);
        while ($entry = array_pop($stack)) {
            // Watch for symlinks
            if (@is_link($entry)) {
                @unlink($entry);
                continue;
            }

            // Attempt to remove the directory
            if (@rmdir($entry)) {
                continue;
            }

            // Otherwise add it to the stack
            $stack[] = $entry;
            $dh = opendir($entry);
            while (false !== $child = readdir($dh)) {
                // Ignore pointers
                if ($child === '.' || $child === '..') {
                    continue;
                }
                // Unlink files and add directories to stack
                $child = $entry . DIRECTORY_SEPARATOR . $child;
                if (is_dir($child) && !is_link($child)) {
                    $stack[] = $child;
                } else {
                    @unlink($child);
                }
            }
            @closedir($dh);
        }
        return true;
    }


    public static function mkdirStrict($path, $recursive = true, $mode = 0777)
    {
        $exists = file_exists($path);
        if($exists && is_dir($path)) {
            return true;
        }
        if($exists && !is_dir($path)) {
            $path = Mage_System_Dirs::getFilteredPath($path);
            throw new Exception("'{$path}' already exists, should be a dir, not a file!");
        }
        $out = @mkdir($path, $mode, $recursive);
        if(false === $out) {
            $path = Mage_System_Dirs::getFilteredPath($path);
            throw new Exception("Can't create dir: '{$path}'");
        }
        return true;
    }

    public static function copyFileStrict($source, $dest)
    {
        $exists = file_exists($source);
        if(!$exists) {
            throw new Exception('No file exists: '.$exists);
        }

    }

    /**
     * Replace full path to relative
     *
     * @param $path
     * @return string
     */
    public static function getFilteredPath($path)
    {
        $dir = pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_DIRNAME);
        $position = strpos($path, $dir);
        if ($position !== false && $position < 1) {
            $path = substr_replace($path, '.', 0, strlen($dir));
        }
        return $path;
    }
}
