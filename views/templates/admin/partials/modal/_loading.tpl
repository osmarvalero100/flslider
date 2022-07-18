<style>
#fl-loading {
  position: absolute;
  height: 99%;
  width: 99%;
  display:flex;
  justify-content: center;
  /* align-items: center; */
  background-color: rgba(85, 85, 85, 0.5);
}
#fl-loading .panel {
  max-width: 350px;
  height: 250px;
  margin-top: 70px;
}
#fl-loading .panel .load {
    min-height: 180px;
    min-width: 330px;
    background-image: url('/modules/flslider/views/img/load/4.gif');
    background-repeat: no-repeat;
    background-size: cover;

}
.fl-show-loading {
  display: block;
  z-index: 999999999999;
}
</style>
<div id="fl-loading" class="hidden">
    <div class="panel">
        <p style="margin-top: revert;" class="text-center">¡Trabajando en tu solicitud!</p>
        <div class="load"></div>
    </div>
</div>