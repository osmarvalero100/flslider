<?php

defined('_PS_VERSION_') or exit;

require_once(_PS_MODULE_DIR_.'/flslider/classes/FLSHelper.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slider.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slide.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Device.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/SlideObjects.php');

class AdminFLSliderController extends ModuleAdminController {

    public function __construct() {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function initContent()
    {
        //$this->context->smarty->assign('flslider_dir', $this->module->getLocalPath());
        Media::addJsDefL('fls_image_uri', $this->module->getPathUri().'images/');
        
        if (Tools::getValue('edit')){
            $this->content .= $this->editSlider(Tools::getValue('edit'));
            return parent::initContent();
        }
        $this->content .= $this->displayStats();
        return parent::initContent();
    }

    public function displayStats()
    {
        $tpl_path = $this->getTemplatePath().'main.tpl';
        $sliders = Slider::getAll();

        $this->context->smarty->assign(array(
            'sliders' => $sliders,
            'module_name' => $this->module->name,
            'ajaxUrlFLSlider' => Context::getContext()->link->getAdminLink('AdminFLSlider'),
            'ajaxUrlSlider' => Context::getContext()->link->getAdminLink('AdminAjaxSlider'),
            'ajaxUrlSlide' => Context::getContext()->link->getAdminLink('AdminAjaxSlide'),
            'ajaxUrlSlideObjects' => Context::getContext()->link->getAdminLink('AdminAjaxSlideObjects'),
        ));
        return $this->context->smarty->fetch($tpl_path);
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme = false);
        $this->addCSS('https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css');
        $this->addJS('https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js');

        $js_path = _MODULE_DIR_ . $this->module->name.'/views/js';
        $ajaxUrlSlider = Context::getContext()->link->getAdminLink('AdminAjaxSlider');
        $ajaxUrlSlide = Context::getContext()->link->getAdminLink('AdminAjaxSlide');
        $ajaxUrlSlideObjects = Context::getContext()->link->getAdminLink('AdminAjaxSlideObjects');
        Media::addJsDef([
            'ajaxUrlSlider' => $ajaxUrlSlider,
            'ajaxUrlSlide' => $ajaxUrlSlide,
            'ajaxUrlSlideObjects' => $ajaxUrlSlideObjects,
        ]);
        
        $this->context->controller->addJqueryUI('ui.draggable');
        //$this->context->controller->addJqueryUI('ui.resizable');
        $this->addJS($js_path . '/admin/helper.js');
        $this->addJS($js_path . '/admin/slider.js');
        $this->addJS($js_path . '/admin/slide.js');
        $this->addJS($js_path . '/admin/slide-device.js');
        $this->addJS($js_path . '/admin/slide-objects.js');
        if (Tools::getValue('edit') != null) {
            $this->addJS($js_path . '/admin/edit-slider.js');
        }
        
    }

    public function editSlider($idSlider) {
        $tpl_path = $this->getTemplatePath().'edit-slider.tpl';
        $js_path = _MODULE_DIR_ . $this->module->name.'/views/js';

        $this->context->smarty->assign(array(
            'id_slider' => $idSlider,
            'js_path' => $js_path,
            'ajaxUrlFLSlider' => Context::getContext()->link->getAdminLink('AdminFLSlider'),
            'ajaxUrlSlider' => Context::getContext()->link->getAdminLink('AdminAjaxSlider'),
        ));

        Media::addJsDef(
            [
                'idSlider' => Tools::getValue('edit'),
                'editSlider' => json_encode(Slider::getSliderEdit($idSlider)), 
            ]
        );

        return $this->context->smarty->fetch($tpl_path);
    }

}