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
require_once(_PS_MODULE_DIR_.'/flslider/classes/FLSHelper.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slider.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slide.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/SlideObjects.php');

/**
 * @property SlideObjects $object
 */
class AdminAjaxSlideObjectsController extends ModuleAdminController
{
    public function ajaxProcessSave()
    {
        $data = FLSHelper::getRequestData();

        if (isset($data->id) && $data->id != null) {
            $slideObject = new SlideObjects((int) $data->id);
        } else {
            $slideObject = new SlideObjects();
        }

        $slideObject->id_slide = (int) $data->id_slide;
        $slideObject->type = $data->type;
        //$slideObject->setAttributes($data->attributes);
        $slideObject->attributes = $data->attributes;
        try {
            $slideObject->save();
            $this->ajaxDie(json_encode($slideObject));
        } catch (Exception $e) {
            http_response_code(400);
            $data = ['errors' => $e->getMessage()];
            $this->ajaxDie(json_encode($data));
        }
    }
    
    public function ajaxProcessUploadImage()
    {
        $idSlider = Tools::getvalue('id_slider');
        
        if (!empty($_FILES['img_object'])) {
            $extImg = str_replace('image/', '', $_FILES['img_object']['type']);
            if(!in_array($extImg, FLSHelper::allowImageExt())) {
                $this->ajaxDie(json_encode(['errors' => 'Image extension invalid']));
            }

            $uploadImage = FLSHelper::uploadImage($_FILES['img_object'], $idSlider);
            if (!empty($uploadImage['errors'])) {
                http_response_code(400);
                $this->ajaxDie(['errors' => $uploadImage['errors']]);
            }

            $this->ajaxDie(json_encode($uploadImage));
        }
    }

    public function ajaxProcessDelete() {
        $data = FLSHelper::getRequestData();
        if (empty($data->id)) {
            http_response_code(400);
            $this->ajaxDie(json_encode(['errors' => 'Se requiere un id de Slider']));
        }
        $slideObject = new SlideObjects((int) $data->id);
        if (empty($slideObject->id)) {
            http_response_code(404);
            $this->ajaxDie(json_encode(['errors' => 'SlideObject '.$data->id.' Not Found']));
        }
        var_dump($slideObject->getAttributes());
        
        //$slideObject->remove();
        http_response_code(204);
        exit;
    }
}