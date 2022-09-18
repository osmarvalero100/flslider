{include file="./partials/modal/_loading.tpl"}

<style>
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
    cursor: pointer;
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

<div id="flsliders">
    <div class="panel">
        <div class="menu">
            <i class="ri-list-unordered ri-2x" title="Todos"></i>
            <i class="ri-folder-user-line ri-2x" title="Creados por mi"></i>
            <i class="ri-heart-line ri-2x" title="Favoritos"></i>
        </div>
        <div class="panel-body">
            <div class="row">
                {foreach from=$sliders item=slider}
                <div id="slider-{$slider.id_slider}" class="sliders col-sm-3 col-md-3">
                    <div class="thumbnail">
                        <div class="text-right indicators">
                            <i class="ri-live-line ri-2x"></i>
                            <i class="ri-time-line ri-2x"></i>
                            <i class="ri-heart-line ri-2x" title="Favoritos"></i>
                        </div>
                        <a href="{$ajaxUrlFLSlider}&edit={$slider.id_slider}">
                            <div class="content">
                                <p>#{$slider.id_slider}</p>
                                <div class="caption">
                                    <h3>{$slider.name}</h3>
                                </div>
                            </div>
                        </a>
                        <div class="text-center options">
                            <i class="ri-file-copy-2-line ri-2x" title="Duplicar"></i>
                            <i class="ri-arrow-down-line ri-2x" title="Exportar"></i>
                            {if $slider.active == 1}
                                <i class="ri-check-line ri-2x" title="Despublicar"></i>
                            {else}
                                <i class="ri-close-line ri-2x" title="Publicar"></i>
                            {/if}
                            <i class="ri-delete-bin-line ri-2x" title="Eliminar"></i>
                        </div>
                    </div>
                </div>
                {/foreach}

                <div class="col-sm-3 col-md-3 import" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <img height="140px" width="auto" src="/modules/flslider/views/img/dw.png">
                        <h3>Importar Slider</h3>
                    </div>
                </div>
                <div id="add" class="col-sm-3 col-md-3 add" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <img height="140px" width="auto" src="/modules/flslider/views/img/add1.png">
                        <h3>Crear Slider</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bootstrap .thumbnail {
    padding-left: 10px;
}
</style>

{include file='./add.tpl'}

{literal}
    <script>
        async function removeSlider(id) {
            if (confirm("¿Estás seguro de eleiminar este slider?") == true) {
                const res = await Slider.remove(JSON.stringify({id: id}));
                if (res.status == 400 || res.status == 404) {
                    const data = await res.json();
                    alert(data.errors);
                }
                if (res.status == 204)
                    document.getElementById('slider-' + id).remove();
            }
        }
    </script> 
{/literal}


{* ICONS BACK *}
{*
<style>
.back-icons i {
  width: 48px;
  display: inline-block;
}
</style>
<div class="back-icons">
<i class="process-icon-anchor"></i>
<i class="process-icon-back"></i>
<i class="process-icon-cancel"></i>
<i class="process-icon-cart"></i>
<i class="process-icon-close"></i>
<i class="process-icon-cogs"></i>
<i class="process-icon-compress"></i>
<i class="process-icon-configure"></i>
<i class="process-icon-database"></i>
<i class="process-icon-delete"></i>
<i class="process-icon-download"></i>
<i class="process-icon-download-alt"></i>
<i class="process-icon-dropdown"></i>
<i class="process-icon-duplicate"></i>
<i class="process-icon-edit"></i>
<i class="process-icon-envelope"></i>
<i class="process-icon-eraser"></i>
<i class="process-icon-expand"></i>
<i class="process-icon-export"></i>
<i class="process-icon-flag"></i>
<i class="process-icon-help"></i>
<i class="process-icon-help-new"></i>
<i class="process-icon-loading"></i>
<i class="process-icon-mail-reply"></i>
<i class="process-icon-minus"></i>
<i class="process-icon-modules-list"></i>
<i class="process-icon-new"></i>
<i class="process-icon-new-module"></i>
<i class="process-icon-new-url"></i>
<i class="process-icon-newAttributes"></i>
<i class="process-icon-off"></i>
<i class="process-icon-ok"></i>
<i class="process-icon-partial_refund"></i>
<i class="process-icon-payment"></i>
<i class="process-icon-plus"></i>
<i class="process-icon-power"></i>
<i class="process-icon-preview"></i>
<i class="process-icon-previewURL"></i>
<i class="process-icon-refresh"></i>
<i class="process-icon-reset"></i>
<i class="process-icon-save"></i>
<i class="process-icon-save-and-preview"></i>
<i class="process-icon-save-and-stay"></i>
<i class="process-icon-save-date"></i>
<i class="process-icon-save-status"></i>
<i class="process-icon-stats"></i>
<i class="process-icon-terminal"></i>
<i class="process-icon-themes"></i>
<i class="process-icon-toggle-off"></i>
<i class="process-icon-toggle-on"></i>
<i class="process-icon-uninstall"></i>
<i class="process-icon-update"></i>
<i class="process-icon-upload"></i>
</div>

*}