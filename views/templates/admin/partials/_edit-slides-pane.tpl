<style>
.panel {
    padding: 0 !important;
}
.thumbnail{
    height: 100px;
    margin-bottom: 0 !important;
    cursor: pointer;
    padding: 5px !important;
}

.no-image {
    background-image: url("/modules/flslider/views/img/slide.png");
    background-repeat: no-repeat;
    background-position: center;
}
.active-slide .thumbnail {
    border: 3px solid #00aff0 !important;
}
.actions {
    padding: 3px;
    position: absolute;
    bottom: 3px;
    left: 8px;
    right: 7px;
}
#addSlide img {
    height: 48px;
    margin-top: 10px;
    margin-bottom: 6px;
}
.slide {
    margin-top: 5px;
}
.slide .capion {
    background-color: rgb(255,255,255, 0.1);
    margin-top: 15px;
    width: 100%;
    padding: 0 20px;
}
.slide .caption h3 {
    border-bottom: none !important;
}
.slide .move {
    font-weight: 800;
    font-size: 15pt;
    position: absolute;
    right: 10px;
    top: 35%;
    height: 40px;
    width: 25px;
    text-align: center;
    padding-top: 3px;
    box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
    border-radius: 10%;
    z-index: 3;
}
.slide .move:hover {
    background-color: #f4f4f4;
    box-shadow: rgba(50, 50, 105, 0.15) 0px 2px 5px 0px, rgba(0, 0, 0, 0.05) 0px 2px 1px 0px;
    color: #00aff0;
    cursor: ew-resize;
}
</style>
<div class="panel fls-slides">
    <div class="panel-body">
        <div id="slideSelector">
            <div class="row">
            {literal}
                <template x-for="slide in $store.sl.current_device.slides">
                    <div class="col-sm-3 col-md-2 slide"
                        :data-slide-id="slide.id"
                        :class="slide.id == $store.sl.current_slide.id ? 'active-slide':''"
                        :style="()=>{
                            if (slide.active == 0 || (slide.date_end != null && (new Date() > new Date(slide.date_end)))) {
                                return {opacity: .3}
                            }
                            return {}
                        }"
                        @click="setCurrentSlide(slide.id)" @mouseover="getCoverSlide(slide.id)">
                        <div class="thumbnail" :style="()=>{
                                return {
                                    backgroundImage: getCoverSlide(slide.id),
                                    backgroundSize: 'contain',
                                    backgroundPosition: 'center',
                                    backgroundRepeat: 'no-repeat'
                                } 
                            }">
                            <div class="caption">
                                <h3 x-text="slide.name"></h3>
                                    <template x-if="()=>{
                                            return (slide.date_start && slide.date_start.substring(0,4) != '0000') || (slide.date_end && slide.date_end.substring(0,4) != '0000');
                                        }">
                                        <i class="ri-lg"
                                            :class="slide.date_end != null && (new Date() > new Date(slide.date_end)) ? 'ri-timer-line':'ri-time-line'"
                                            style="
                                                position: absolute;
                                                right: 30px;
                                                top: 7px;"
                                            :title="()=>{
                                                const start = slide.date_start != null && slide.date_start.substring(0,4) != '0000' ? 'Desde: '+slide.date_start : '';
                                                const end = slide.date_end != null && slide.date_end.substring(0,4) != '0000' ? 'Hasta: '+slide.date_end : '';
                                                return  start + '  ' + end;
                                                }">
                                        </i>
                                    </template>
                                    <i class="ri-lg ri-arrow-down-line" style="
                                        position: absolute;
                                        right: 12px;
                                        top: 7px;" title="Exportar">
                                    </i>
                                <span title="Mover a otra posición" class="move">::</span>
                                <div class="text-center actions">
                                    <div class="btn-group dropup">
                                        <button @click="delSlide(slide.id)" type="button" title="Eliminar" class="btn btn-primary">
                                            <i class="icon-trash"></i>
                                        </button>
                                        <button @click="changeStatus(slide.id)" type="button" :title="slide.active == 0 ? 'Encender':'Apagar'" class="btn btn-primary">
                                            <i class="icon-power-off"></i>
                                        </button>
                                        <button type="button" title="Duplicar" class="btn btn-primary">
                                            <i class="icon-copy"></i>
                                        </button>
                                        <button @click="showSlideSettings()" type="button" title="configurar" class="btn btn-primary">
                                            <i class="icon-cogs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            {/literal}
                {*foreach from=$slides item=slide key=key}
                <div class="col-sm-3 col-md-2 {if $key == 0}active-slide{/if} slide">
                    <div class="thumbnail no-image" >
                        <div class="caption">
                            <h3>{$slide.name}</h3>
                            <div class="text-center actions">
                                <div class="btn-group dropup">
                                    <a href="" title="Cambiar nombre" class="btn btn-primary">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <button type="button" title="Duplicar" class="btn btn-primary">
                                        <i class="icon-copy"></i>
                                    </button>
                                    <button type="button" title="Eliminar" class="btn btn-primary">
                                        <i class="icon-trash"></i>
                                    </button>
                                    <div class="btn-group dropup">
                                        <button type="button" title="Más Opciones" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-code"></i> <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Desactivar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/foreach*}
                <div @click="alert('Pendiente por implementar')" id="addSlide" class="col-sm-3 col-md-2 slide" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <img style="transform: rotate(210deg);" alt="Nuevo Slide" src="/modules/flslider/views/img/dw.png">
                        <br>
                        <h3>Importar Slide</h3>
                    </div>
                </div>

                <div @click="createSlide()" id="addSlide" class="col-sm-3 col-md-2 slide" style="cursor: pointer;">
                    <div class="thumbnail text-center">
                        <img alt="Nuevo Slide" src="/modules/flslider/views/img/add1.png">
                        <br>
                        <h3>Nuevo Slide</h3>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
$("#slideSelector .row").sortable({
    items: ".slide:not(#addSlide)",
    update: function( event, ui ) {
        const slides = document.querySelectorAll('#slideSelector .slide');
        if (slides) {
            let slidesPositions = [];
            const device = Alpine.store('sl').current_device;
            const slidesDevice = Alpine.store('sl').slider.devices.find(d => d.id = device.id);
            for (let i = 0; i < slides.length; i++) {
                if (slides[i].dataset.hasOwnProperty('slideId') && slides[i].dataset.slideId != '') {
                    const newOrder = i + 1;
                    const slideId =  slides[i].dataset.slideId;
                    slidesPositions.push({
                        id: slideId,
                        order_slide: newOrder
                    });
                    const slide = slidesDevice.slides.find(slide => slide.id == slideId);
                    slide.order_slide = newOrder;
                }
            }
            Slide.updateOrder(slidesPositions);
        }
    }
});
</script>