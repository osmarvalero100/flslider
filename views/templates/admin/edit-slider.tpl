<div x-data="editSlider()" x-init="await start()">
    {include file="./settings.tpl"}
    <input type="hidden" id="id_slider" value="{$id_slider}">
    {include file="./partials/modal/_loading.tpl"}
    {include file="./partials/_edit-head.tpl"}
    {* <div x-data="getSlides()"> *}
        {include file="./partials/_edit-slides-pane.tpl"}
        {* <div x-data="getSlideObjects"> *}
            {include file="./partials/_edit-canvas.tpl"}
        {* </div>
    </div> *}
</div>
{* <script src="{$js_path}/admin/edit-slider.js"></script> *}

{* {debug} *}

{foreach from=collection item=item key=key name=name}
    
{/foreach}