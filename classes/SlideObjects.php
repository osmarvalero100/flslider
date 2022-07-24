<?php

class SlideObjects extends ObjectModel
{
    public $id;

    /** @var int Device id */
    public $id_device;

    /** @var string type */
    public $type;

    /** @var string */
    public $attributes;


    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'flslider_slides_objects',
        'primary' => 'id_slide_object',
        'fields' => [
            'id_slide' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
            'type' => ['type' => self::TYPE_STRING, 'required' => true],
            'attributes' => ['type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCleanHtml'],
        ],
    ];

    /**
     * Slide constructor.
     *
     * @param int|null $idSlide
     * @param int|null $idLang
     * @param int|null $idShop
     */
    public function __construct($idSlideObject = null, $idLang = null, $idShop = null)
    {
        parent::__construct($idSlideObject, $idLang, $idShop);
    }

    public function getAttributes() {
        if (empty($this->attributes)) {
            return [];
        }

        return json_decode($this->attributes);
    }

    public function setAttributes($data)
    {
        $this->attributes = json_encode($data);
    }

    public static function getAllBySlide($idSlide)
    {
        $sql = 'SELECT id_slide_object, id_slide, `type`, attributes
        FROM `'._DB_PREFIX_.'flslider_slides_objects`
        WHERE id_slide = '.$idSlide;

        $result = Db::getInstance()->ExecuteS($sql);
		
		return $result;
    }
    public static function getSlideObjectsEdit($idSlide)
    {
        $slideObjects = [];
        $sql = 'SELECT id_slide_object
        FROM `'._DB_PREFIX_.'flslider_slides_objects`
        WHERE id_slide = '.$idSlide;

        $results = Db::getInstance()->ExecuteS($sql);

        if (!empty($results)) {
            foreach ($results as $so) {
                $objSlide = new SlideObjects((int) $so['id_slide_object']);
                $slideObjects[] = $objSlide;
            }
        }

        return $slideObjects;
    }

    public static function getFrontObjectsBySlideId($idSlide)
    {
        $sql = 'SELECT id_slide_object, id_slide, `type`, attributes
        FROM `'._DB_PREFIX_.'flslider_slides_objects`
        WHERE id_slide = '.$idSlide;

        $result = Db::getInstance()->ExecuteS($sql);
        foreach($result as $key => $object) {
            $result[$key]['attributes'] = json_decode($object['attributes'], true);
        }
		
		return $result;
    }

}
