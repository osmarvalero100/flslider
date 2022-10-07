<script>
document.getElementById('add').addEventListener('click', ()=>{
    $('#adminFLSlider').modal();
});
</script>

<div class="modal fade bs-example-modal-sm" id="adminFLSlider" tabindex="-1" role="dialog" aria-labelledby="modalListPromotions">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2>Crear Slider</h2>
            </div>
            <div class="modal-body">
                <form @submit.prevent="createSlider" method="POST" action="#">
                    <div id="formSlider">
                        <div class="form-group">
                            <input x-model="$store.sls.sliderForm.name" type="text" class="form-control" name="name" id="name" placeholder="Nombre">
                            {*<span id="addError" class="text-danger"></span>*}
                        </div>
                        <div class="form-group">
                            <label>Tamaño</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-computer-fill" title="Desktop"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="$store.sls.sliderForm.settings.desktop.styles.width" type="text" class="form-control" placeholder="1350px">
                                <div class="input-group-addon">H</div>
                                <input x-model="$store.sls.sliderForm.settings.desktop.styles.height" type="text" class="form-control" placeholder="270px">
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-tablet-fill" title="Tablet"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="$store.sls.sliderForm.settings.tablet.styles.width" type="text" class="form-control" placeholder="778px">
                                <div class="input-group-addon">H</div>
                                <input x-model="$store.sls.sliderForm.settings.tablet.styles.height" type="text" class="form-control" placeholder="220px">
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-smartphone-fill" title="Mobile"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="$store.sls.sliderForm.settings.mobile.styles.width" type="text" class="form-control" placeholder="480px">
                                <div class="input-group-addon">H</div>
                                <input x-model="$store.sls.sliderForm.settings.mobile.styles.height" type="text" class="form-control" placeholder="350px">
                            </div>
                        </div>
                        
                        <button :class="$store.sls.sliderForm.name < 1 ? 'disabled':''" id="addSlider" type="submit" class="btn btn-primary btn-lg btn-block">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

