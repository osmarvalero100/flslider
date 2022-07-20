<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.7.x
 *
 * @package   pspagebuilder
 * @version   5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2022 osmar <@emai:osmarvalero100@gmail.com>
 *               <osmar>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PsWidgetFlSlider extends PsWidgetPageBuilder {

	public $name = 'flslider';
	public $is_footer = 1;
    public $is_header = 1;
    public $module_name = 'flslider';

	public static function getWidgetInfo()
	{
		return array('label' => 'FL Slider', 'explain' => 'Slider optimizado para Prestashop', 'group' => 'images');
	}

    public static function getAllSliders() {
        $sliders = array();
        $query = 'SELECT * FROM `'._DB_PREFIX_.'flslider_sliders`;';
        $sliders_raw = Db::getInstance()->ExecuteS($query);
        foreach ($sliders_raw as $key => $slide) {
            $sliders[$key] = array('value' => $slide['id_slider'], 'text' => $slide['name']);
        }
        return $sliders;
    }

    public static function getSlider($idSlider) {
        $query = 'SELECT * FROM `'._DB_PREFIX_.'flslider_sliders` WHERE id_slider='.(int)$idSlider.';';
        $slider_raw = Db::getInstance()->ExecuteS($query);
        return $slider_raw;
    }

	public function renderForm($data) {
    if (Module::isEnabled($this->module_name)) {
      $sliders = $this->getAllSliders();
    } else {
      return 'Slider is not Installed or enabled';
    }
		$helper = $this->getFormHelper();

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
        array(
          'type' => 'select',
          'label' => $this->l('Select Slider'),
          'name' => 'id_flslider',
          'options' => array(
            'query' => $sliders,
            'id' => 'value',
            'name' => 'text'
          ),
          'default' => '',
        ),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues($data),
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);
		return $helper->generateForm($this->fields_form);
	}

	public function renderContent($setting)
	{
		$setting['slider'] = "<div class='alert-warning alert text-center'><strong>The FL Slider doesn't exist. Maybe you missed to import it. Go to \"Theme Settings\" &rarr; \"Presets\"</strong></div>";
        if (Module::isEnabled($this->module_name)) {
            $setting['slider'] = ['id' => $setting['id_flslider']];
        }

        $output = array (
        'type' => 'flslider',
        'data' => $setting
        );

		return $output;
	}
}
