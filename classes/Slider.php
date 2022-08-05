<?php

require_once(_PS_MODULE_DIR_.'/flslider/classes/FLSHelper.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Slide.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Device.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/SlideObjects.php');

class Slider extends ObjectModel
{
    public $id;

    /** @var int Shop id */
    public $id_shop;

    /** @var string name */
    public $name;

    /** @var string */
    public $settings;

    /** @var int */
    public $id_employee;

    /** @var bool */
    public $active = false;

    /** @Column(type="datetime") */
    public $date_start;

    /** @Column(type="datetime") */
    public $date_end;

    /** @var array */
    public $devices;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'flslider_sliders',
        'primary' => 'id_slider',
        'fields' => [
            'id_shop' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
            'name' => ['type' => self::TYPE_STRING, 'required' => true],
            'settings' => ['type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCleanHtml'],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'date_start' => ['type' => self::TYPE_DATE],
            'date_end' => ['type' => self::TYPE_DATE],
        ],
    ];

    /**
     * Slider constructor.
     *
     * @param int|null $idSlider
     * @param int|null $idLang
     * @param int|null $idShop
     */
    public function __construct($idSlider = null, $idLang = null, $idShop = null)
    {
        parent::__construct($idSlider, $idLang, $idShop);
    }

    public function getSettings() {
        if (empty($this->settings)) {
            return [];
        }

        return json_decode($this->settings);
    }

    public function setSettings($data)
    {
        $this->settings = json_encode($data);
    }

    public static function getAll($idShop = null)
	{
        if (!$idShop)
            $idShop = Context::getContext()->shop->id;

        $sql = 'SELECT id_slider, id_shop, `name`, settings, active, date_start, date_end
                FROM `'._DB_PREFIX_.'flslider_sliders`
                WHERE id_shop ='. (int) $idShop;

		$result = Db::getInstance()->ExecuteS($sql);

		if (!$result)
			return [];
		
		return $result;
	}

    public static function getSliderEdit($idSlider)
    {
        // Slider
        $slider = new Slider($idSlider);
        if (!$slider->id)
            return null;
        
        $slider->devices = Device::getDeviceEdit((int) $slider->id);

        return $slider;
    }

    public function remove()
    {
        $devices = Device::getDeviceEdit((int) $this->id);
        if (!empty($devices)) {
            foreach ($devices as $d) {
                if (!empty($d->slides)) {
                    foreach ($d->slides as $s) {
                        if (!empty($s->slideObjects)) {
                            foreach ($s->slideObjects as $so) {
                                $so->delete();
                            }
                        }
                        $s->delete();
                    }
                }
                $d->delete();
            }
        }
        FLSHelper::deleteImagesSlider($this->id);
        if (!$this->delete())
            return false;
        return true;
    }

    public static function getFrontSliderById($idSlider, $idShop=null)
    {
        if (!$idShop)
            $idShop = Context::getContext()->shop->id;

        $sql = 'SELECT id_slider, id_shop, `name`, settings
                FROM `'._DB_PREFIX_.'flslider_sliders`
                WHERE id_slider ='.$idSlider.' AND id_shop ='. (int) $idShop;
        
		$result = Db::getInstance()->getRow($sql);
        $result['settings'] = json_decode($result['settings'], true);
        $result['styles'] = Slider::getStyles($result['settings']);
        $result['slides'] = [];
        $sliderDeviceId = Device::getFrontSliderDeviceId($idSlider);
        if (!empty($sliderDeviceId)) {
            $slides = Slide::getFrontSlides($sliderDeviceId);
            if (!empty($slides)) {
                $result['slides'] = $slides;
            }
        }
		if (!$result)
			return [];
		
		return $result;
    }

    public static function getStyles($settings)
    {   $styles = '';
        $devices = FLSHelper::listDevices();
        $device =  $devices[Context::getContext()->getDevice()];
        
        foreach ($settings[$device]['styles'] as $prop => $value) {
            $styles .= $prop.':'.$value.';';
        }

        return $styles;
    }

    

}
