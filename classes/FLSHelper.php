<?php

class FLSHelper {

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
    public static function getDeviceName()
    {
        return FLSHelper::listDevices()[Context::getContext()->getDevice()];
    }
    public static function allowImageExt()
    {
        return ['png', 'jpg', 'jpeg', 'gif', 'webp'];
    }

    public static function uploadImage($image, $idSlider, $convertToWebp = true) {
        $data = [];
        $extImg = str_replace('image/', '', $image['type']);
        $name = $name = uniqid();
        $folderSlider = FLSHelper::getPathImages().$idSlider;
        
        if (!is_dir($folderSlider)) {
            if (!mkdir( $folderSlider, 0777, true )) {//0755
                $data['errors'][] = 'Por favor asignar permisos de lectura y escritura en la ruta: '.FLSHelper::getPathImages();
                return $data;
            }
        }
        

        $pathImage = $folderSlider.'/'.$name.'.'.$extImg;
        if(move_uploaded_file($_FILES['img_object']['tmp_name'], $pathImage)) {
            $data['src'] = $name.'.'.$extImg;
            if ($convertToWebp) {
                FLSHelper::imageCreateWebp($pathImage);
            }
            $data['srcset'] = $name.'.webp';
        } else {
            $data['errors'][] = 'Por favor asignar permisos de lectura y escritura en la ruta: '.$pathImage;
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

    public static function deleteDir($dirPath) {
        if (is_dir($dirPath))
            $dir_handle = opendir($dirPath);
        if (!$dir_handle)
            return false;

        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirPath."/".$file))
                    unlink($dirPath."/".$file);
                else
                    FLSHelper::deleteDir($dirPath.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirPath);
        return true;
    }

    public static function deleteImagesSlider($idSlider) {
        $folderSlider = FLSHelper::getPathImages().$idSlider;
        if (is_dir($folderSlider)) {
            if (FLSHelper::deleteDir($folderSlider))
                return true;
        }

        return false;
    }

    public static function deleteImageObject($idSlider, $name) {
        $folderSlider = FLSHelper::getPathImages().$idSlider;
        $pathImage = $folderSlider.'/'.$name;
        if (is_file($pathImage)) {
            unlink($pathImage);
            return true;
        }

        return false;
    }
}