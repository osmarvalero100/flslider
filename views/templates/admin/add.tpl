<script>
document.getElementById('add').addEventListener('click', ()=>{
    $('#adminFLSlider').modal();
});
function sliderForm() {
	return {
		formData: {
			name: '',
			settings: {
                'desktop': {
                    styles: {
                        width: '1350px',
                        height: '270px',
                    },
                },
                'tablet': {
                    styles: {
                        width: '778px',
                        height: '220px',
                    },
                },
                'mobile': {
                    styles: {
                        width: '480px',
                        height: '350px',
                    },
                },
            },
		},
        buttonLabel: 'Crear',
        error: false,
		message: '',
		submitData() {
            this.error = false;
            if (this.formData.name == '') {
                this.error = true;
                this.message = 'Campo Nombre es requerido.';
                return false;
            }
            
			this.message = '';
            this.buttonLabel = 'Creando...';

            Slider.save(this.formData)
            .then(res => res.json())
            .then(res => {
                if (res.id) {
                    let urlEditSlider = "{$ajaxUrlFLSlider}&edit="+res.id;
                    window.location.href = urlEditSlider;
                }
            })
            .catch(error => {
                this.typeMessage = 'text-danger',
                this.message = 'Ha ocurrido un error.';
                console.log(error) 
            })
            .finally(() => {
                this.buttonLabel = 'Crear'
            });
		}
	}
}
</script>

<div class="modal fade bs-example-modal-sm" id="adminFLSlider" tabindex="-1" role="dialog" aria-labelledby="modalListPromotions">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2>Crear Slider</h2>
            </div>
            <div class="modal-body">
                <form x-data="sliderForm()" @submit.prevent="submitData" method="POST" action="#">
                    <div id="formSlider">
                        <div class="form-group">
                            <input x-model="formData.name" type="text" class="form-control" name="name" id="name" placeholder="Nombre">
                            {*<span id="addError" class="text-danger"></span>*}
                        </div>
                        <div class="form-group">
                            <label>Tamaño</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-computer-fill" title="Desktop"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="formData.settings.desktop.styles.width" type="text" class="form-control" placeholder="1350px">
                                <div class="input-group-addon">H</div>
                                <input x-model="formData.settings.desktop.styles.height" type="text" class="form-control" placeholder="270px">
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-tablet-fill" title="Tablet"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="formData.settings.tablet.styles.width" type="text" class="form-control" placeholder="778px">
                                <div class="input-group-addon">H</div>
                                <input x-model="formData.settings.tablet.styles.height" type="text" class="form-control" placeholder="220px">
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ri-smartphone-fill" title="Mobile"></i></div>
                                <div class="input-group-addon">W</div>
                                <input x-model="formData.settings.mobile.styles.width" type="text" class="form-control" placeholder="480px">
                                <div class="input-group-addon">H</div>
                                <input x-model="formData.settings.mobile.styles.height" type="text" class="form-control" placeholder="350px">
                            </div>
                        </div>
                        <div x-show='error' class="alert" :class="{
                            'alert-success': !error, 'alert-danger': error
                            }" >
                            <p x-text="message"></p>
                        </div>
                        <button x-text="buttonLabel" id="addSlider" type="submit" class="btn btn-primary btn-lg btn-block"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

