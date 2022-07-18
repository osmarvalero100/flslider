<?php

class Helper {

    public static function getUriImages()
    {
        return _MODULE_DIR_ .'flslider/images/';
    }
    public static function getPathImages()
    {
        return _PS_ROOT_DIR_ .'/modules/flslider/images/';
    }
    public static function listDevices()
    {
        return [
            1 => 'desktop',
            2 => 'tablet',
            4 => 'mobile',
        ];
    }
    public static function allowImageExt()
    {
        return ['png', 'jpg', 'jpeg', 'gif'];
    }

    public static function uploadImage($image, $idSlider, $convertToWebp = true) {
        $data = [];
        $extImg = str_replace('image/', '', $image['type']);
        $name = $name = uniqid();
        $folderSlider = Helper::getPathImages().$idSlider;

        try {
            if (!is_dir($folderSlider))
                mkdir( $folderSlider, 0777, true );
        } catch (\Throwable $th) {
            die(json_encode(['errors' => 'Error creando directorio de slider. Permiso denegado.']));
        }

        $pathImage = $folderSlider.'/'.$name.'.'.$extImg;
        if(move_uploaded_file($_FILES['img_object']['tmp_name'], $pathImage)) {
            $data['src'] = Helper::getUriImages().$idSlider.'/'.$name.'.'.$extImg;
            if ($convertToWebp) {
                if (Helper::imageCreateWebp($pathImage)) {
                    $data['srcset'] = Helper::getUriImages().$idSlider.'/'.$name.'.webp';
                }
            }
        } else {
            $data['errors'] = ['upload_image'=>false];
        }

        return $data;
    }

    /**
     * Convert image to webp
     * @param string $source    Path image
     * @param int    $quality   Quality (0 - 100)
     */
    public static function imageCreateWebp($source, $quality = 80)
    {
        $dir = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        $destination = $dir.DIRECTORY_SEPARATOR.$name.'.webp';
        $info = getimagesize($source);
        $isAlpha = false;
        
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
        elseif ($isAlpha = $info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($isAlpha = $info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        } else {
            return $source;
        }
        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        return imagewebp($image, $destination, $quality);
    }

    public static function getRequestData() {
        $json = file_get_contents('php://input');
        return json_decode($json);
    }
}