<?php
require_once(_PS_MODULE_DIR_.'/flslider/classes/FLSHelper.php');
require_once(_PS_MODULE_DIR_.'/flslider/classes/Device.php');

class Slide extends ObjectModel
{
    public $id;

    /** @var int Device id */
    public $id_device;

    /** @var string name */
    public $name;

    /** @var int */
    public $order_slide;

    /** @var string */
    public $settings;

    /** @var bool */
    public $active = true;

    /** @var array */
    public $slideObjects;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'flslider_slides',
        'primary' => 'id_slide',
        'fields' => [
            'id_device' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
            'name' => ['type' => self::TYPE_STRING, 'required' => true],
            'order_slide' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
            'settings' => ['type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCleanHtml'],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
        ],
    ];

    /**
     * Slide constructor.
     *
     * @param int|null $idSlide
     * @param int|null $idLang
     * @param int|null $idShop
     */
    public function __construct($idSlide = null, $idLang = null, $idShop = null)
    {
        parent::__construct($idSlide, $idLang, $idShop);
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

    public static function getSlidesEdit($idDevice)
    {
        $slides = [];
        $sql = 'SELECT id_slide
        FROM `'._DB_PREFIX_.'flslider_slides`
        WHERE id_device = '.$idDevice;
        $results = Db::getInstance()->ExecuteS($sql);

        if (!empty($results)) {
            foreach ($results as $slide) {
                $objSlide = new Slide((int) $slide['id_slide']);
                $objSlide->slideObjects = SlideObjects::getSlideObjectsEdit((int) $objSlide->id);
                $slides[] = $objSlide;
            }
        }

        return $slides;
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

    public static function getFrontSlides($idDevice)
    {
        $slides = [];
        $sql = 'SELECT id_slide, id_device, `name`, settings, active, order_slide
        FROM `'._DB_PREFIX_.'flslider_slides`
        WHERE id_device = '.$idDevice.' AND active = 1';
        $results = Db::getInstance()->ExecuteS($sql);

        if (!empty($results)) {
            $slides = $results;

            foreach ($results as $key =>$slide) {
                $slides[$key]['objects'] = [];
                $slideObjects = SlideObjects::getFrontObjectsBySlideId((int) $slide['id_slide']);
                if (!empty($slideObjects)) {
                    $slides[$key]['objects'] = $slideObjects;
                }
            }
        }

        return $slides;
    }

}
