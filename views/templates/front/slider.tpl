<style>
.full-width {
    width: 100vw !important;
    position: relative;
    margin-left: -50vw !important;
    left: 50%;
}
</style>
{assign var="device" value=FLSHelper::getDeviceName()}

<div id="flslider_{$slider.id_slider}" 
    class="fl-slider full-width"
    style="{foreach from=$slider.settings[$device]['styles'] item=style key=key }{$key}:{$style};{/foreach}"
    >
    {* <div class="gallery">*}
        <div class="slides">
            {foreach from=$slider.slides item=slide key=key}
            <div class="slide block {if $key==0}active{/if}">
                {foreach from=$slide.objects item=object}
                    {include file="./partials/objects/_{$object.type}.tpl" object=$object}
                {/foreach}
            </div>
            {/foreach}
        </div>
        <div class="navs">
            {include file="./navs/classic.tpl"}
        </div>
    {* </div> *}
</div>