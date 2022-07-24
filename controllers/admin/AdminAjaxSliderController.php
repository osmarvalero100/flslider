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
 * @property Slider $object
 */
class AdminAjaxSliderController extends ModuleAdminController
{
    public function ajaxProcessSave()
    {
        $data = FLSHelper::getRequestData();

        if (isset($data->id) && $data->id != null) {
            $slider = new Slider((int)$data->id);
        } else {
            $slider = new Slider();
        }

        $slider->name = $data->name;
        $slider->id_shop = $this->context->shop->id;
        $slider->setSettings($data->settings);
        if (!empty($data->date_start))
            $slider->date_end = $data->date_start;
        if (!empty($data->date_end))
            $slider->date_end = $data->date_end;
        if (isset($data->active))
            $slider->active = $data->active;

        try {
            $slider->save();
            // Si es un nuevo slider se le crea un slide por defecto para cada dispositivo
            if (!isset($data->id) || $data->id == null) {
                Device::createDefaultDeviceSlide($slider->id);
            }
            http_response_code(201);
            $this->ajaxDie(json_encode($slider));
        } catch (Exception $e) {
            http_response_code(400);
            $data = ['errors' => $e->getMessage()];
            $this->ajaxDie(json_encode($data));
        }
    }
    
    public function ajaxProcessGetEditById()
    {
        if (empty(Tools::getValue('id'))) {
            http_response_code(400);
            $this->ajaxDie(json_encode(['errors' => 'Se requiere un id de Slider']));
        }
        
        $slider = Slider::getSliderEdit((int) Tools::getValue('id'));
        if (empty($slider)) {
            http_response_code(400);
            $this->ajaxDie(json_encode(['errors' => 'Slider Not Found']));
        }
        $this->ajaxDie(json_encode($slider));
    }

    public function ajaxProcessDelete() {
        $data = FLSHelper::getRequestData();
        if (empty($data->id)) {
            http_response_code(400);
            $this->ajaxDie(json_encode(['errors' => 'Se requiere un id de Slider']));
        }
        $slider = new Slider((int) $data->id);
        if (empty($slider->id)) {
            http_response_code(404);
            $this->ajaxDie(json_encode(['errors' => 'Slider '.$data->id.' Not Found']));
        }
        
        $slider->remove();
        http_response_code(204);
        exit;
    }
    
}