const devices = {1: 'desktop', 2: 'tablet', 4: 'mobile'};
Alpine.store("sl", {
    slider: new Slider(),
    current_device: new Device(),
    current_slide: new Slide(),
});

function editSlider() {
    return {
        start: async function() {
            const res = await Slider.getEditById(idSlider);
            const editSlider = await res.json();
            Alpine.store("sl").slider = await this.jsonParseSlider(editSlider);
            await this.setDevice(1);
            SlideObjects.pushInCanvas(Alpine.store("sl").current_slide.slideObjects);
            console.log(Alpine.store("sl"))
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
            const slide = Alpine.store("sl").current_device.slides.find(sl => sl.id == idSlide);
            Alpine.store("sl").current_slide = slide;
            await SlideObjects.clearCanvas();
            if (slide.slideObjects.length > 0)
                SlideObjects.pushInCanvas(slide.slideObjects);
        },
        createSlide: async function() {
            const defaults = [];
            const qtySlides = Alpine.store("sl").current_device.slides.length;
            const slide = {
                name: 'Slide ' + (qtySlides + 1),
                id_device: Alpine.store("sl").current_device.id,
                order_slide: qtySlides + 1,
                settings: JSON.stringify(defaults),
            }

            const res = await Slide.save(slide);
            const newSlide = await res.json();
            newSlide.settings = JSON.parse(newSlide.settings);
            Alpine.store("sl").current_device.slides.push(newSlide);
        },
        delSlide: function(idSlide) {
            console.log(idSlide);
            // const res = await Slide.delete(idSlide);
            // const delSlide = await res.json();
            // Alpine.store("sl").slider.slides = Alpine.store("sl").slider.slides.filter(sl => sl.id != idSlide);
        },
        uploadImage: async function(event) {
            const img = event.target.files[0];
            const formData = new FormData();
            formData.append('id_slider', Alpine.store("sl").slider.id);
            formData.append('img_object', img);
            const resUp = await SlideObjects.uploadImage(formData);
            const dataImg = await resUp.json();
            await this.createSlideObject('img', {props: dataImg})
        },
        createSlideObject: async function(type, data={}) {
            const defaults = {
                styles: {
                    'top': 0,
                    'left': 0,
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

            const res = await SlideObjects.save(slideObject);
            const newSlideObject = await res.json();
            console.log(newSlideObject)
            newSlideObject.attributes = JSON.parse(newSlideObject.attributes)
            console.log(newSlideObject)
            Alpine.store("sl").current_slide.slideObjects.push(newSlideObject);
            SlideObjects.pushInCanvas([newSlideObject]);
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

// Guardar con CTRL + S
document.onkeydown = (e) => {
    if (e.ctrlKey && e.key.toLowerCase() === 's') {
      e.preventDefault();
      console.log('CTRL + S');
      console.log(Alpine.store("sl"));
    }
}