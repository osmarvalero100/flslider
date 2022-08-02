<style>
/*
#fl-slider-settings {
  position: fixed;
  top: 5px;
  left: 1%;
  z-index: 999999999999;
  background-color: #fff;
  width: 98%;
  border: 1px double #00aff0;
  margin: 0 auto;
  border-radius: 5px;
  padding: 10px
}
*/
#fl-slider-settings {
  position: fixed;
  left: 40%;
  top: 1%;
  /*transform: translate(-40%, 5%);*/
  padding: 5px 20px 30px 20px;
  background-color: #fff;
  z-index: 9999;
  min-width: 30%;
  box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
  border-radius: 3px;
}
</style>
<div id="fl-slider-settings">
    {include file="./partials/_slider-settings.tpl"}
    <hr>
    <div class="row">
        <button class="btn btn-default">Cancelar</button>
        <button class="btn btn-primary">Guardar</button>
    </div>
</div>
