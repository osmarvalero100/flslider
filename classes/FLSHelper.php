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

    public static function getIntrinsicSize($source) {
        $info = getimagesize($source);
        if ($info === false) {
            return false; // Not a valid image
        }
        return [
            'width' => $info[0],
            'height' => $info[1],
            'mime' => $info['mime']
        ];
    }

    public static function scaleImage($rutaOriginal, $width, $height) {
        $nuevoAncho = $width;
        $nuevoAlto = $height;

        // Obtener las dimensiones originales
        list($anchoOriginal, $altoOriginal) = getimagesize($rutaOriginal);

        // Crear un recurso de imagen desde el archivo WebP original
        $imagenOriginal = imagecreatefromwebp($rutaOriginal);

        // Crear un lienzo para la nueva imagen
        $imagenRedimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

        // Habilitar la transparencia para WebP (importante para WebP con canal alfa)
        imagealphablending($imagenRedimensionada, false);
        imagesavealpha($imagenRedimensionada, true);
        $transparent = imagecolorallocatealpha($imagenRedimensionada, 255, 255, 255, 127);
        imagefilledrectangle($imagenRedimensionada, 0, 0, $nuevoAncho, $nuevoAlto, $transparent);

        // Escalar la imagen original y copiarla en el nuevo lienzo
        imagecopyresampled(
            $imagenRedimensionada,
            $imagenOriginal,
            0, 0, 0, 0,
            $nuevoAncho,
            $nuevoAlto,
            $anchoOriginal,
            $altoOriginal
        );

        $rutaDestino = $rutaOriginal;// str_replace('.webp', '_resized.webp', $rutaOriginal);

        // Guardar la imagen redimensionada en formato WebP (la calidad va de 0 a 100)
        imagewebp($imagenRedimensionada, $rutaDestino, 90);

        // Liberar memoria
        imagedestroy($imagenOriginal);
        imagedestroy($imagenRedimensionada);

        return $rutaDestino; // Retorna la ruta de la imagen redimensionada
    }

    /**
     * Scales a WebP image while maintaining its aspect ratio to fit
     * within a maximum width and height.
     *
     * @param string $originalPath The path to the original WebP image.
     * @param int $maxWidth The maximum width for the new image.
     * @param int $maxHeight The maximum height for the new image.
     * @return string The path to the saved image.
     */
    public static function scaleImageKeepAspectRatio($originalPath, $maxWidth, $maxHeight)
    {
        list($originalWidth, $originalHeight) = getimagesize($originalPath);
        $ratio = $originalWidth / $originalHeight;

        if ($maxWidth / $maxHeight > $ratio) {
            $newWidth = $maxHeight * $ratio;
            $newHeight = $maxHeight;
        } else {
            $newHeight = $maxWidth / $ratio;
            $newWidth = $maxWidth;
        }

        $originalImage = imagecreatefromwebp($originalPath);
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        imagecopyresampled(
            $resizedImage,
            $originalImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );
        $destinationPath = $originalPath;
        imagewebp($resizedImage, $destinationPath, 90);
        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        return $destinationPath;
    }

    public static function uploadImage($image, $idSlider, $convertToWebp = true, $height = null, $width = null) {
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

            if ($height && $width) {
                $ri = FLSHelper::scaleImageKeepAspectRatio($pathImage, $width, $height); //FLSHelper::scaleImage($pathImage, $width, $height);
                if ($ri) {
                    error_log('Image resized successfully: '.$pathImage);
                } else {
                    error_log('-----------------'.$ri.'--------------------------');
                    $data['errors'][] = 'Error resizing the image.';
                }
            }
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
    public static function imageCreateWebp($source, $quality = 75)
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

    public static function deleteImage($idSlider, $name) {
        $folderSlider = FLSHelper::getPathImages().$idSlider;
        $pathImage = $folderSlider.'/'.$name;
        if (is_file($pathImage)) {
            unlink($pathImage);
            // Check if the folder is empty and delete it
            if (count(scandir($folderSlider)) == 2) {
                rmdir($folderSlider);
            }
            return true;
        }    
        return false;
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