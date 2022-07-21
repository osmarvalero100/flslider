
<img
{foreach from=$object.attributes['props'] item=prop key=key }
    {$key}="{$prop}"
{/foreach}
>
