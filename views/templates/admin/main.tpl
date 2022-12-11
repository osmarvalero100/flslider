{include file="./partials/modal/_loading.tpl"}

<style>
i,
.add,
.import {
    cursor: pointer;
}
.sliders .thumbnail {
    background-image: linear-gradient(to top, #009bcd, #00a4d3, #00add9, #00b7df, #00c0e4) !important;
    border: none;
}
.sliders .content p {
    color: white;
    font-size: 48px; 
}
.sliders h3 {
    font-size: 20px !important;
}
.sliders .content p {
    color: white;
    font-size: 48px; 
}
.sliders .options i {
    color: white;
    margin-top: -10px;
}
.sliders .options i:hover {
    opacity: .8;
    color: gray;
}

.sliders .options {
  margin-top: -10px
}
#flsliders .add .thumbnail,
#flsliders .import .thumbnail {
  height: 167px
}
#flsliders .import .thumbnail img {
  height: 70%;
  margin-bottom: 20px;
}
#flsliders .add .thumbnail img {
  height: 60%;
  margin-top: 10px;
  margin-bottom: 26px;
}
.indicators {
    position: absolute;
    width: 90%;
}
.indicators i.ri-live-line {
    color: red;
}

</style>

{include file="./loader.tpl"}
<div id="flsliders" x-data="listSliders()" x-init="await start()">
    <div class="panel">
        <div class="menu">
            <i class="ri-list-unordered ri-2x" title="Todos"></i>
            <i class="ri-folder-user-line ri-2x" title="Creados por mi"></i>
            <i class="ri-heart-line ri-2x" title="Favoritos"></i>
        </div>
        <div class="panel-body">
            <div class="row">
                {literal}
                <template x-for="slider in $store.sls.sliders">
                    <template x-if="slider.id_slider">
                        <div class="sliders col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <div class="text-right indicators">
                                    <i class="ri-live-line ri-2x"></i>
                                    <i class="ri-time-line ri-2x"></i>
                                    <i class="ri-heart-line ri-2x" title="Favoritos"></i>
                                </div>
                                <a x-bind:href="flSlider+'&edit='+slider.id_slider">
                                    <div class="content" x-data="{id_slider: '#'+slider.id_slider}">
                                        <p>#<span x-text="slider.id_slider"></span></p>
                                        
                                        <div class="caption">
                                            <h3 x-text="slider.name"></h3>
                                        </div>
                                    </div>
                                </a>
                                <div class="text-center options">
                                    <i class="ri-file-copy-2-line ri-2x" title="Duplicar"></i>
                                    <i class="ri-arrow-down-line ri-2x" title="Exportar"></i>
                                    <i class="ri-2x"
                                        @click="changeStatus(slider.id_slider)"
                                        :class="slider.active == 0 ? 'ri-close-line':'ri-check-line'"
                                        :title="slider.active == 0 ? 'Habilitar':'Deshabilitar'"></i>
                                    <i class="ri-delete-bin-line ri-2x" @click="delSlider(slider.id_slider)" title="Eliminar"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
                {/literal}

                <div class="col-sm-3 col-md-3 import">
                    <div class="thumbnail text-center">
                        <img height="140px" width="auto" src="/modules/flslider/views/img/dw.png">
                        <h3>Importar Slider</h3>
                    </div>
                </div>
                <div id="add" class="col-sm-3 col-md-3 add">
                    <div class="thumbnail text-center">
                        <img height="140px" width="auto" src="/modules/flslider/views/img/add1.png">
                        <h3>Crear Slider</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {include file='./add.tpl'}
</div>

<style>
.bootstrap .thumbnail {
    padding-left: 10px;
}
</style>