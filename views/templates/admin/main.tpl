{include file="./partials/modal/_loading.tpl"}

<div id="flsliders">
    <div class="panel panel-primary">
        <div class="panel-heading">Sliders</div>
        <div class="panel-body">
            <div class="row">
                {foreach from=$sliders item=slider}
                <div id="slider-{$slider.id_slider}" class="col-sm-3 col-md-3">
                    <div class="thumbnail">
                        <a href="{$ajaxUrlFLSlider}&edit={$slider.id_slider}">
                        <img src="/modules/flslider/views/img/cover.png" alt="{$slider.name}">
                        </a>
                        <div class="caption text-center">
                            <h3>{$slider.name}</h3>
                            <div class="btn-group dropup">
                                <a href="{$ajaxUrlFLSlider}&edit={$slider.id_slider}" title="Editar" class="btn btn-primary">
                                    <i class="icon-edit"></i>
                                </a>
                                <button type="button" title="Duplicar" class="btn btn-primary">
                                    <i class="icon-copy"></i>
                                </button>
                                <button type="button" title="Eliminar" class="btn btn-primary">
                                    <i class="icon-trash"></i>
                                </button>
                                <div class="btn-group dropup">
                                    <button type="button" title="Más Opciones" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-code"></i> <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Exportar</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">
                                            {if $slider.active == 1}
                                                Desactivar
                                            {else}
                                                Activar
                                            {/if}
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/foreach}

                <div class="col-sm-3 col-md-3 slider-bad" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <br>
                        <img height="140px" width="auto" src="/modules/flslider/views/img/dw.png">
                        <br><br>
                        <h3>Importar Slider</h3>
                    </div>
                </div>
                <div id="add" class="col-sm-3 col-md-3 slider-bad" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <br>
                        <img height="140px" width="auto" src="/modules/flslider/views/img/add1.png">
                        <br><br>
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

{* ICONS BACK *}
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

