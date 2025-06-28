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

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once(dirname(__FILE__) . '/integrations/pspagebuilder/FLSliderWidgetPsPageBuilder.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slider.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/FLSHelper.php');

class FlSlider extends Module
{
    protected $config_form = false;

    public $adminControllers = [
        'adminAjaxSlider' => 'AdminAjaxSlider',
        'adminAjaxSlide' => 'AdminAjaxSlide',
        'adminAjaxSlideObjects' => 'AdminAjaxSlideObjects',
    ];

    public function __construct()
    {
        $this->name = 'flslider';
        $this->tab = 'slideshows';
        $this->version = '1.0.0';
        $this->author = 'Osmar';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('FL Slider');
        $this->description = $this->l('Slider Optimizado para Prestashop. Crea sliders personalizados para tu tienda con imágenes y elementos interactivos.');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        $this->tabs = array(
            array(
                'class_name' => 'AdminFLSlider',
                'ParentClassName' => 'IMPROVE',
                'name' => array(
                    'en-US' => 'FL Slider',
                    'es-ES' => 'FL Slider',
                    'es-CO' => 'FL Slider',
                    'es-MX' => 'FL Slider',
                    'es-EC' => 'FL Slider',
                ),
                'visible' => true,
                'icon' => 'panorama'
            )
        );
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        require_once __DIR__ . '/sql/install.php';
        $widgetPageBuilder = new FLSliderWidgetPsPageBuilder();
        Configuration::updateValue('OPTIMIZEDSLIDER_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayFLSlider') &&
            $widgetPageBuilder->add('pspagebuilder');
    }

    public function uninstall()
    {
        //require_once __DIR__ . '/sql/uninstall.php';
        Configuration::deleteByName('OPTIMIZEDSLIDER_LIVE_MODE');
        $widgetPageBuilder = new FLSliderWidgetPsPageBuilder();
        $widgetPageBuilder->remove('pspagebuilder');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitOptimizedsliderModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitOptimizedsliderModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'OPTIMIZEDSLIDER_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'OPTIMIZEDSLIDER_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'OPTIMIZEDSLIDER_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'OPTIMIZEDSLIDER_LIVE_MODE' => Configuration::get('OPTIMIZEDSLIDER_LIVE_MODE', true),
            'OPTIMIZEDSLIDER_ACCOUNT_EMAIL' => Configuration::get('OPTIMIZEDSLIDER_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'OPTIMIZEDSLIDER_ACCOUNT_PASSWORD' => Configuration::get('OPTIMIZEDSLIDER_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
        $this->context->controller->addJS($this->_path.'views/lib/flsconfirm/flsconfirm.js');
        $this->context->controller->addCSS($this->_path.'views/lib/flsconfirm/flsconfirm.css');

        $this->context->controller->addCSS($this->_path.'views/lib/flstoast/flstoast.css');
        $this->context->controller->addJS($this->_path.'views/lib/flstoast/flstoast.js');
        
        if (Module::isEnabled('pspagebuilder')) {
            $this->context->controller->addCSS($this->_path.'integrations/pspagebuilder/styles.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayFLSlider($params)
    {
        return $this->showFrontSlider($params['id_flslider']);
    }

    public function showFrontSlider($idSlider)
    {
        // $cacheKey = 'flslider_front_slider_'.$idSlider;

        // if (!Cache::isStored($cacheKey)) {
        //     $slider = Slider::getFrontSliderById($idSlider);
        //     if (empty($slider)) {
        //         return '';
        //     }
        //     $this->context->smarty->assign([
        //         'slider' => $slider,
        //         'fls_image_uri' => FLSHelper::getUriImages(),
        //     ]);
        //     $html = $this->display(__FILE__, 'views/templates/front/slider.tpl');
        //     Cache::store($cacheKey, $html);
        // } else {
        //     $html = Cache::retrieve($cacheKey);
        // }

        $slider = Slider::getFrontSliderById($idSlider);
        if (empty($slider)) {
            return '';
        }
        $this->context->smarty->assign([
            'slider' => $slider,
            'fls_image_uri' => FLSHelper::getUriImages(),
        ]);
        $html = $this->display(__FILE__, 'views/templates/front/slider.tpl');

        return $html;
    }
}
