<div role="tabpanel" class="fls-slide-settings">
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
                        <label for="slide-name">Nombre</label>
                        <input x-model="$store.sl.current_slide.name" type="text" class="form-control" id="slide-name" placeholder="Nombre">
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="publish">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slide-from">Desde</label>
                        <input x-model="$store.sl.current_slide.date_start" type="text" class="form-control fls-datetime" id="slide-from" placeholder="AAAA-MM-DD HH:MM:SS">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slide-to">Hasta</label>
                        <input x-model="$store.sl.current_slide.date_end" type="text" class="form-control fls-datetime" id="slide-to" placeholder="AAAA-MM-DD HH:MM:SS">
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="calendar">
            <div class="row">
                <h3>¡Pronto!</h3>
                
            </div>
        </div>
    </div>
</div>