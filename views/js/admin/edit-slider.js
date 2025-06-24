const devices = {1: 'desktop', 2: 'tablet', 4: 'mobile'};
Alpine.store("sl", {
    slider: new Slider(),
    current_device: new Device(),
    current_slide: new Slide(),
    images_slider_url: '/modules/flslider/images'
});

function editSlider() {
    return {
        start: async function() {
            const res = await Slider.getEditById(idSlider);
            const editSlider = await res.json();
            const slider = await this.jsonParseSlider(editSlider);
            Alpine.store("sl").slider = slider;
           // Alpine.store("sl").slider.active = Boolean(Alpine.store("sl").slider.active);
            Alpine.store("sl").slider.config = false;
            await this.setDevice(1);
            //SlideObjects.pushInCanvas(Alpine.store("sl").current_slide.slideObjects);
            hideLoader();
            console.log(Alpine.store("sl"));
        },
        getSliderStyles: function(){
            let device = 'desktop';
            let deviceNames = Object.values(devices);
            if (deviceNames.includes(devices[Alpine.store("sl").current_device.device])) {
                device = devices[Alpine.store("sl").current_device.device];
            }
            return Alpine.store("sl").slider.settings[device].styles;
        },
        setDevice: async function(numDevice) {
            Alpine.store("sl").current_device = Alpine.store("sl").slider.devices.find(sd => sd.device == numDevice);
            await this.setCurrentSlide(Alpine.store("sl").current_device.slides[0].id);
        },
        setCurrentSlide: async function(idSlide) {
            //await SlideObjects.clearCanvas();
            Alpine.store("sl").current_slide = new Slide();
            const slide = Alpine.store("sl").current_device.slides.find(sl => sl.id == idSlide);
            Alpine.store("sl").current_slide = slide;
            Alpine.store("sl").current_slide.config = false;
            if (Array.isArray(slide.slideObjects) && slide.slideObjects.length > 0) {
                //SlideObjects.setAtributesObjects(slide.slideObjects);
                setTimeout(() => {
                    SlideObjects.addDraggable(Alpine.store("sl").current_slide.slideObjects);
                }, 500);
            }
        },
        showSliderSettings: function(){
            Alpine.store("sl").slider.config = true;
        },
        hideConfig: async function(){
            if (Alpine.store("sl").slider.config) {
                const res = await Slider.getById(idSlider);
                const slider = await res.json();
                Alpine.store("sl").slider.date_start = slider.date_start;
                Alpine.store("sl").slider.date_end = slider.date_end;
                Alpine.store("sl").slider.config = false;
            }

            if (Alpine.store("sl").current_slide.config) {
                const res = await Slide.getById(Alpine.store("sl").current_slide.id);
                const slide = await res.json();
                // Alpine.store("sl").current_slide.date_start = slide.date_start;
                // Alpine.store("sl").current_slide.date_end = slide.date_end;
                Alpine.store("sl").current_slide.config = false;
            }
        },
        saveConfig: async function(){
            showLoader();
            if (Alpine.store("sl").slider.config) {
                Alpine.store("sl").slider.date_start = document.getElementById('s-from').value;
                Alpine.store("sl").slider.date_end = document.getElementById('s-to').value;
                const res = await Slider.save(Alpine.store("sl").slider);
                res.status == 200 ? Alpine.store("sl").slider.config = false : alert('Error al guardar el slider');
            }
            if (Alpine.store("sl").current_slide.config) {
                Alpine.store("sl").current_slide.date_start = document.getElementById('slide-from').value;
                Alpine.store("sl").current_slide.date_end = document.getElementById('slide-to').value;
                const res = await Slide.save(Alpine.store("sl").current_slide);
                res.status == 200 ? Alpine.store("sl").current_slide.config = false : alert('Error al guardar el slide');
            }
            hideLoader();
        },
        createSlide: async function() {
            const defaults = [];
            const qtySlides = Alpine.store("sl").current_device.slides.length;
            const randomName = Math.random().toString(36).slice(-4);
            const slide = {
                name: randomName,
                id_device: Alpine.store("sl").current_device.id,
                active: 0,
                order_slide: qtySlides + 1,
                settings: JSON.stringify(defaults),
            }

            showLoader();
            const res = await Slide.save(slide);
            const newSlide = await res.json();
            newSlide.settings = JSON.parse(newSlide.settings);
            Alpine.store("sl").current_device.slides.push(newSlide);
            this.setCurrentSlide(newSlide.id);
            hideLoader();
        },
        getCoverSlide: function(idSlide) {
            const slide = Alpine.store("sl").current_device.slides.find(sl => sl.id == idSlide);
            if (slide && slide.slideObjects) {
                if (slide.slideObjects.length == 0)
                    return 'url("/modules/flslider/views/img/slide.png")';
                const coverObject = slide.slideObjects.find(so => so.type == 'img');
                if (coverObject.length == 0)
                    return 'url("/modules/flslider/views/img/slide.png")';
                if (coverObject.hasOwnProperty('attributes') && coverObject.attributes.hasOwnProperty('props') && coverObject.attributes.props.hasOwnProperty('src')) {
                    const cover = Alpine.store("sl").images_slider_url +'/'+ Alpine.store("sl").slider.id + '/' + coverObject.attributes.props.src;
                    return 'url(' + cover + ')';
                }
            }
            return 'url("/modules/flslider/views/img/slide.png")';
        },
        showSlideSettings: function(){
            setTimeout(() => {
                Alpine.store("sl").current_slide.config = true;
            }, 400);
        },
        changeStatus: async function(slideId) {
            showLoader();
            const res = await Slide.changeStatus({id: slideId});
            if (res.status == 400) {
                alert(res.error);
            } else {
                Alpine.store("sl").current_device.slides.forEach(sl => {
                    if (sl.id == slideId) {
                        if (sl.active == 0) {
                            sl.active = 1;
                        } else {
                            sl.active = 0;
                        }
                    }
                });
            }
            hideLoader();
        },
        delSlide: async function(idSlide) {
            const slideName = document.querySelector(`[data-slide-id='${idSlide}']`).querySelector("h3").textContent;
            FlsConfirm({
                message: `¿Realmente quieres eliminar el slide <strong> ${slideName} </strong> de forma permanente?`
            }).then(async (willDelete) => {
                if (willDelete) {
                    showLoader();
                    const data = {
                        id: idSlide,
                    };
                    const res = await Slide.remove(data);
                    if (res.status == 204) {
                        await this.setCurrentSlide(Alpine.store("sl").current_device.slides[0].id);
                        const index = Alpine.store("sl").current_device.slides.findIndex(sl => sl.id == idSlide);
                        Alpine.store("sl").current_device.slides.splice(index, 1);
                    }
                    hideLoader();
                }
            });
            
        },
        delSlideObject: async function(idSlideObject) {
            showLoader();
            const data = {
                id: idSlideObject,
                id_slider: Alpine.store("sl").slider.id
            };
            const res = await SlideObjects.remove(data);
            if (res.status == 204) {
                const indexObject = Alpine.store("sl").current_slide.slideObjects.findIndex(object => {
                    return object.id == idSlideObject;
                });
                Alpine.store("sl").current_slide.slideObjects.splice(indexObject, 1);
            } else {
                FlCuteToast({type: 'error', title: 'Error', message: 'No fue posible eliminar el objeto.', timer: 10000});
            }
            hideLoader();
        },
        uploadImage: async function(event) {
            const img = event.target.files[0];

            if (!img) {
                FlCuteToast({type: 'error', title: 'Error', message: 'No se ha seleccionado ninguna imagen.', timer: 10000});
                return;
            }
            const formData = new FormData();
            formData.append('id_slider', Alpine.store("sl").slider.id);
            formData.append('img_object', img);
            showLoader();
            const resUp = await SlideObjects.uploadImage(formData);
            
            const dataImg = await resUp.json();
            hideLoader();

            if (dataImg.hasOwnProperty('errors')) {
                let message = '';
                dataImg.errors.forEach(er => {
                    message += er + '<br>';
                });
                FlCuteToast({type: 'error', title: 'Error', message: message, timer: 10000});
            } else {
                await this.createSlideObject('img', {props: dataImg})
            }
        },
        createSlideObject: async function(type, data={}) {
            const defaults = {
                styles: {
                    'top': 0,
                    'left': 0,
                    'margin': 0,
                    'padding': 0,
                    'position': 'absolute',
                },
                props: {}
            }

            if (type == 'img')
                defaults.props = data.props;

            const slideObject = {
                type: type,
                id_slide: Alpine.store("sl").current_slide.id,
                attributes: JSON.stringify(defaults),
            }

            showLoader();
            const res = await SlideObjects.save(slideObject);
            const newSlideObject = await res.json();
            hideLoader();
            newSlideObject.attributes = JSON.parse(newSlideObject.attributes)
            if (Alpine.store("sl").current_slide.slideObjects == null) {
                Alpine.store("sl").current_slide.slideObjects = [];
            }
            Alpine.store("sl").current_slide.slideObjects.push(newSlideObject);
            //SlideObjects.pushInCanvas([newSlideObject]);
            setTimeout(() => {
                SlideObjects.addDraggable(Alpine.store("sl").current_slide.slideObjects);
            }, 500);
        },
        jsonParseSlider: async function(slider) {
            // Settings Slider
            slider.settings = JSON.parse(slider.settings);
            if (slider.devices.length > 0) {
                slider.devices.forEach(device => {
                    // Settings Slides
                    device.slides.forEach(sd => {
                        sd.settings = JSON.parse(sd.settings);
                        sd.slideObjects.forEach(so => {
                            // Attributes Slide Objects
                            so.attributes = JSON.parse(so.attributes);
                        });
                    });
                });
            }
            return  slider;
        }
    }
}

$(document).ready(function() {
    $('#fl-slider-settings').draggable({containment: "body"});
});

function showDatapicker(){
    $('body .fls-datetime').datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat:  "hh:mm:ss",
    });
}