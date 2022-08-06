<div id="fls-edit" x-data="editSlider()" x-init="await start()">
    <input type="hidden" id="id_slider" value="{$id_slider}">
    {include file="./settings.tpl"}
    {include file="./partials/modal/_loading.tpl"}
    {include file="./partials/_edit-head.tpl"}
    {include file="./partials/_edit-slides-pane.tpl"}
    {include file="./partials/_edit-canvas.tpl"}
</div>