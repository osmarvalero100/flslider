<?php

class Device extends ObjectModel
{
    public $id;

    /** @var int Slide id */
    public $id_slide;

    /** @var int */
    public $device;

    /** @var array */
    public $slides;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'flslider_devices',
        'primary' => 'id_device',
        'fields' => [
            'id_slider' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
            'device' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
        ],
    ];

    /**
     * Slide constructor.
     *
     * @param int|null $idSlide
     * @param int|null $idLang
     * @param int|null $idShop
     */
    public function __construct($idDevice = null, $idLang = null, $idShop = null)
    {
        parent::__construct($idDevice, $idLang, $idShop);
    }

    public static function getDeviceEdit($idSlider)
    {
        $devices = [];
        $sql = 'SELECT id_device
        FROM `'._DB_PREFIX_.'flslider_devices`
        WHERE id_slider = '.$idSlider;
        $results = Db::getInstance()->ExecuteS($sql);

        if (!empty($results)) {
            foreach ($results as $key => $device) {
                $objDevice = new Device((int) $device['id_device']);
                $objDevice->slides = Slide::getSlidesEdit((int) $objDevice->id);
                $devices[] = $objDevice;
            }
        }

        return $devices;
    }

    public static function createDefaultDeviceSlide($idSlider)
    {
        foreach (FLSHelper::listDevices() as $key=>$value) {
            $device = new Device();
            $device->id_slider = $idSlider;
            $device->device = $key;
            $device->save();
            
            $slide = new Slide();
            $slide->id_device = $device->id;
            $slide->name = 'Slide 1';
            $slide->order_slide = 1;
            $slide->setSettings([]);
            $slide->save();
        }
    }
    public static function deleteByIdSlider($idSlider)
    {
        $sql = 'DELETE FROM `'._DB_PREFIX_.'flslider_devices`
        WHERE id_slider = '.$idSlider;
        Db::getInstance()->ExecuteS($sql);
    }

    public static function getFrontSliderDeviceId($idSlider) {
        $device = Context::getContext()->getDevice();
        $sql = 'SELECT id_device
                FROM `'._DB_PREFIX_.'flslider_devices`
                WHERE id_slider ='.$idSlider.' AND device ='. $device;
		return Db::getInstance()->getValue($sql);
    }

}
