<?php

/*
 * 2007-2015 PrestaShop
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
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @version  Release: $Revision: 13573 $
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slider.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slide.php');

/**
 * @property Slide $object
 */
class AdminAjaxSlideController extends ModuleAdminController
{
    public function ajaxProcessSave()
    {
        $data = FLSHelper::getRequestData();
        
        if (isset($data->id) && $data->id != null) {
            $slide = new Slide((int) $data->id);
        } else {
            $slide = new Slide();
        }

        $slide->name = $data->name;
        $slide->id_device = $data->id_device;
        $slide->order_slide = $data->order_slide;
        $slide->setSettings($data->settings);
        if (!empty($data->date_start))
            $slide->date_end = $data->date_start;
        if (!empty($data->date_end))
            $slide->date_end = $data->date_end;
        
        try {
            $slide->save();
            $this->ajaxDie(json_encode($slide));
        } catch (Exception $e) {
            http_response_code(400);
            $data = ['errors' => $e->getMessage()];
            $this->ajaxDie(json_encode($data));
        }
    }

    public function ajaxProcessDelete() {
        $data = FLSHelper::getRequestData();
        if (empty($data->id)) {
            http_response_code(400);
            $this->ajaxDie(json_encode(['errors' => 'Se requiere un id de Slider']));
        }
        $slide = new Slide((int) $data->id);
        if (empty($slide->id)) {
            http_response_code(404);
            $this->ajaxDie(json_encode(['errors' => 'Slider '.$data->id.' Not Found']));
        }
        
        $slider->remove();
        http_response_code(204);
        exit;
    }
    
}