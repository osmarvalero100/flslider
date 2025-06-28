{if !empty($slider) and  !empty($slider.slides)}
    {assign var="device" value=FLSHelper::getDeviceName()}

    <div id="flslider_{$slider.id_slider}" 
        class="fl-slider"
        style="{foreach from=$slider.settings[$device]['styles'] item=style key=key }{$key}:{$style};{/foreach}"
        >
        <div class="slides">
            {foreach from=$slider.slides item=slide key=key}
                {if $slide.objects|count > 0 
                && ($slide.start_date <= date('Y-m-d H:i:s') || $slide.start_date == '0000-00-00 00:00:00' || $slide.start_date == null) 
                && ($slide.end_date >= date('Y-m-d H:i:s') || $slide.start_date == '0000-00-00 00:00:00' || $slide.start_date == null)}
                    <div class="slide block {if $key==0}active{/if}">
                        {foreach from=$slide.objects item=object}
                            {include file="./partials/objects/_{$object.type}.tpl" object=$object}
                        {/foreach}
                    </div>
                {/if}
            {/foreach}
        </div>
        <div class="navs">
            {include file="./navs/classic.tpl"}
        </div>
    </div>
{/if}
