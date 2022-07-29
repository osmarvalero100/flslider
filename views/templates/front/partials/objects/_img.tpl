<img
{foreach from=$object.attributes['props'] item=prop key=key }
    {if $key == 'src' || $key == 'srcset'}
        {$prop = ''|cat:$fls_image_uri|cat:$slider.id_slider|cat:'/'|cat:$prop}
    {/if}
    {$key}="{$prop}"
{/foreach}
style="{foreach from=$object.attributes['styles'] item=style key=key }{$key}:{$style};{/foreach}"
>
