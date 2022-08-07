<div role="tabpanel" class="fls-slider-settings">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a>
        </li>
        <li role="presentation">
            <a href="#publish" onclick="showDatapicker()" aria-controls="publish" role="tab" data-toggle="tab">Publicar</a>
        </li>
        <li role="presentation">
            <a href="#calendar" aria-controls="calendar" role="tab" data-toggle="tab">Programar</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="slider-name">Nombre</label>
                        <input x-model="$store.sl.slider.name" type="text" class="form-control" id="slider-name" placeholder="Título">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Tamaño</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ri-computer-fill" title="Desktop"></i></div>
                            <div class="input-group-addon">W</div>
                            <input x-model="$store.sl.slider.settings.desktop.styles.width" type="text" class="form-control" placeholder="1350px">
                            <div class="input-group-addon">H</div>
                            <input x-model="$store.sl.slider.settings.desktop.styles.height" type="text" class="form-control" placeholder="270px">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ri-tablet-fill" title="Tablet"></i></div>
                            <div class="input-group-addon">W</div>
                            <input x-model="$store.sl.slider.settings.tablet.styles.width" type="text" class="form-control" placeholder="778px">
                            <div class="input-group-addon">H</div>
                            <input x-model="$store.sl.slider.settings.tablet.styles.height" type="text" class="form-control" placeholder="220px">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ri-smartphone-fill" title="Mobile"></i></div>
                            <div class="input-group-addon">W</div>
                            <input x-model="$store.sl.slider.settings.mobile.styles.width" type="text" class="form-control" placeholder="480px">
                            <div class="input-group-addon">H</div>
                            <input x-model="$store.sl.slider.settings.mobile.styles.height" type="text" class="form-control" placeholder="350px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="publish">
            <style>
            .slider-publish .switch {
                background-color: gray;
                margin-left: 20px;
                padding: 10px 15px 10px 15px;
                border-radius: 5px;
                color: white;
                height: 35px;
                margin-top: -10px;
              }
              .slider-publish .switch:hover {
                opacity: .7;
              }
              .slider-publish .active {
                background-color: green;
              }
              .slider-publish {
                display: inline-flex;
                margin-top: 10px;
              }
              .slider-publish {
                margin-button: 10px !important;
              }
            </style>
            <div class="row">
                <div class="col-md-12 slider-publish">
                    <label>Estado</label>
                    <label
                        class="switch"
                        :class="$store.sl.slider.active == true ? 'active' : ''"
                        x-text="$store.sl.slider.active == true ? 'Publicado':'Sin publicar'" 
                        @click="$store.sl.slider.active = !$store.sl.slider.active">
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="s-from">Desde</label>
                        <input x-model="$store.sl.slider.date_start" type="text" onclick="showDatapicker()" class="form-control fls-datetime" id="s-from">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="s-to">Hasta</label>
                        <input x-model="$store.sl.slider.date_end" type="text" class="form-control fls-datetime" id="s-to">
                    </div>
                </div>
                
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="calendar">
            <div class="row">
                ¡Pronto!
            </div>
        </div>
    </div>
</div>