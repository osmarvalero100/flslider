<?php

class FLSliderWidgetPsPageBuilder {

    public function add($moduleName) {
        if (!Module::isEnabled($moduleName))
            return true;
        
        $files = $this->listFiles($moduleName);
        foreach ($files as $key => $value) {
            $file = $key;
            $folder = $value;
            if (!is_dir($folder)) {
                if (!mkdir($folder, 0775, true)) {
                    return false;
                }
            }
            error_log(dirname(__FILE__).'/'.$file.' |'.$folder.$file);
            if (!copy(dirname(__FILE__).'/'.$file, $folder.$file)) {
                return false;
            }
        }
        return true;
    }

    public function remove($moduleName) {
        if (!Module::isEnabled($moduleName))
            return true;

        $files = $this->listFiles($moduleName);
        foreach ($files as $key => $value) {
            $file = $key;
            $folder = $value;
            if (is_file($folder.$file)) {
                if(!unlink($folder.$file)){
                    return false;
                }
            }
        }
        return true;
    }

    private function listFiles($moduleName) {
        $pathTeme = $this->getPathTheme();
        $files = [
            'flslider.php' => _PS_MODULE_DIR_.$moduleName.'/classes/widget/',
            'widget_flslider.tpl' => _PS_MODULE_DIR_.'pspagebuilder/views/templates/front/widgets/',
        ];
        return $files;
    }

    private function getPathTheme() {
        return _PS_ALL_THEMES_DIR_.Context::getContext()->shop->theme_name;
    }
}