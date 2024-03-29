<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'flslider_sliders` (
    `id_slider` int(11) NOT NULL AUTO_INCREMENT,
    `id_shop` int(2) NOT NULL,
    `name` varchar(100) NOT NULL,
    `settings` text NOT NULL,
    `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
    `date_start` DATETIME,
    `date_end` DATETIME,
    PRIMARY KEY  (`id_slider`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'flslider_devices` (
    `id_device` int(11) NOT NULL AUTO_INCREMENT,
    `id_slider` int(11) NOT NULL,
    `device` int(2) NOT NULL,
    PRIMARY KEY  (`id_device`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'flslider_slides` (
    `id_slide` int(11) NOT NULL AUTO_INCREMENT,
    `id_device` int(11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `order_slide` int(2) NOT NULL,
    `settings` text,
    `date_start` DATETIME,
    `date_end` DATETIME,
    `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
    PRIMARY KEY  (`id_slide`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'flslider_slides_objects` (
    `id_slide_object` int(11) NOT NULL AUTO_INCREMENT,
    `id_slide` int(11) NOT NULL,
    `type` varchar(50) NOT NULL,
    `attributes` text,
    PRIMARY KEY  (`id_slide_object`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
