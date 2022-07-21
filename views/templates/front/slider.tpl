<style>
.full-width {
    width: 100vw !important;
    position: relative;
    margin-left: -50vw !important;
    left: 50%;
}
</style>
<div id="flslider_{$slider.id_slider}" class="fl-slider full-width">
    <div class="gallery">
        <div class="slides">
            {foreach from=$slider.slides item=slide key=key}
            <div class="slide block {if $key==0}active{/if}">
                {foreach from=$slide.objects item=object}
                    {include file="./partials/objects/_{$object.type}.tpl" object=$object}
                {/foreach}
            </div>
            {/foreach}
        </div>
        <div class="buttons">
            <a class="prev" href="#">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            </a>
            <a class="next" href="#">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
            </a>
        </div>
    </div>
</div>