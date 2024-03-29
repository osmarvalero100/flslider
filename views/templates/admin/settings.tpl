<style>
#fl-slider-settings {
  position: fixed;
  left: 40%;
  top: 1%;
  padding: 5px 20px 30px 20px;
  background-color: #fff;
  z-index: 9999;
  min-width: 30%;
  box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
  border-radius: 3px;
  width: 30%;
}
#fl-slider-settings .tab-content {
  padding: 15px;
}
</style>
<div id="fl-slider-settings" x-show="$store.sl.slider.config || $store.sl.current_slide.config">
    <template x-if="$store.sl.slider.config">
        {include file="./partials/_slider-settings.tpl"}
        
    </template>
    <template x-if="$store.sl.current_slide.config">
        {include file="./partials/_slide-settings.tpl"}
    </template>
    <br>
    <div class="row">
        {literal}
            <button class="btn btn-default" @click="hideConfig()">Cancelar</button>
            <button class="btn btn-primary" @click="saveConfig()">Guardar</button>
        {/literal}
    </div>
</div>
