<style>
.fl-wrapper::-webkit-scrollbar-track {
	border-radius: 10px;
	background-color: #F5F5F5;
}
.fl-wrapper::-webkit-scrollbar {
	width: 7px;
	background-color: transparent;
}
.fl-wrapper::-webkit-scrollbar-thumb {
	border-radius: 10px;
    background-color: #fff;
    border: 1px solid;
    border-color: #00aff0;
}
#tool-bar {
    min-height: 40px;
    background-color: #f8f8f8;
    max-width: 99.9%;
    margin-left: 1px;
    border-radius: 5px;
}
i {
  cursor: pointer;
}
i:hover {
  opacity: .6;
}
#fl-canvas {
  overflow: auto;
  width: max(240px, 25%);
  height: 240px;
  margin: auto;
  padding: 8px;
  /*background: #eee;*/
  background: repeating-conic-gradient(#ccc 0% 25%, transparent 0% 50%) 50% / 20px 20px;
  
  /*Firefox*/
  scrollbar-color: #09C transparent;
  scrollbar-width: thin;
}
#fl-canvas > :hover {
  border: 1px dotted #52b3d8;
}
.objects-list {
    box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
}

.object {
    box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px;
    padding-top: 5px;
}
</style>

<div class="panel fls-canvas">
    <div id="tool-bar" class="row">
        <input @change="uploadImage(event)" style="display: none;" type="file" id="uploadImg" accept="image/png, image/gif, image/jpeg, image/webp">
        <div class="col-sd-2 col-md-4">
            <i @click="document.getElementById('uploadImg').click()" id="a-img" class="ri-image-2-line ri-2x" title="Agregar imagen"></i>
            <i id="a-text" class="ri-t-box-line ri-2x" title="Agregar texto"></i>
            <i id="a-link" class="ri-send-plane-2-line ri-2x" title="Agregar botón"></i>
            <i class="ri-menu-5-line ri-2x" title="Agregar menú"></i>
        </div>
        <div class="col-sd-2 col-md-4 text-center">
            <i class="ri-bar-chart-box-line ri-2x" title="Google Tag Manager"></i>
            <i class="ri-swap-box-line ri-2x" title="Ver botones de navegación"></i>
        </div>
        <div class="col-sd-2 col-md-4 text-right">
            <i :class="$store.sl.current_device.device == 1 ? 'ri-computer-fill':'ri-computer-line'"
                class="ri-2x" @click="setDevice(1)"></i>
            <i :class="$store.sl.current_device.device == 2 ? 'ri-tablet-fill':'ri-tablet-line'"
                class="ri-2x" @click="setDevice(2)"></i>
            <i :class="$store.sl.current_device.device == 4 ? 'ri-smartphone-fill':'ri-smartphone-line'"
                class="ri-2x" @click="setDevice(4)"></i>
        </div>
    </div>
    <div class="panel-body">
        <div class="fl-wrapper" style="overflow-x: auto;padding-bottom: 15px;">
            <div {*x-data="getSlideObjects()"*} id="fl-canvas" :style="getSliderStyles()" style="position:relative;padding:0;margin:0 auto;overflow: hidden;">
                {include file="./_edit-slide-objects.tpl"}
            </div>
        </div>
        <p class="text-center">Slider ( <span x-text="$store.sl.slider.name"></span> ):  W <small>1350px H 270px</small> </p>
        <hr>
        <div class="row">
            <div class="col-md-3 objects-list">
                <template x-for="object in $store.sl.current_slide.slideObjects">
                    <div class="object row">
                        <div class="col-md-6">
                            <p x-text="object.id"></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <i class="ri-close-line ri-xl" @click="delSlideObject(object.id)" title="Eliminar"></i>
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                    Basic panel example
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>