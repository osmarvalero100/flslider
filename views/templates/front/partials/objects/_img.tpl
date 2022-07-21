<img
{foreach from=$object.attributes['props'] item=prop key=key }
    {$key}="{$prop}"
{/foreach}
style="{foreach from=$object.attributes['styles'] item=style key=key }{$key}:{$style};{/foreach}"
>
