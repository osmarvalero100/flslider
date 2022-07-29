class SlideObjects {

    constructor(id = null, name, settings = null, active, dateStart = null, dateEnd = null) {
        this.id = id;
        this.name = name;
        this.settings = settings;
        this.active = active;
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
    }

    static getUrlAjaxController(action) {
        return ajaxUrlSlideObjects + '&' + new URLSearchParams({
            ajax: true,
            action: action
        });
    }

    static async getById(id) {
        return await fetch(this.getUrlAjaxController('getById') + '&' + new URLSearchParams({
            id_slider: id
        }));
    }

    static async save(data) {
        return await fetch(this.getUrlAjaxController('save'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
    }

    static async uploadImage(data) {
        return await fetch(this.getUrlAjaxController('uploadImage'), {
            method: 'POST',
            body: data,
        });
    }

    static async changeStatus(data) {
        return await fetch(this.getUrlAjaxController('changeStatus'), {
            method: 'POST',
            body: data,
        });
    }

    static async remove(data) {
        return await fetch(this.getUrlAjaxController('remove'), {
            method: 'POST',
            body: data
        });
    }

    static async clearCanvas() {
        const canvas = Slider.getElementCanvas();
        canvas.innerHTML = '';
    }

    static pushInCanvas(objects) {
        objects.forEach(object => {
            const canvas = Slider.getElementCanvas();
            const element = SlideObjects.createHtmlObject(object);
            canvas.appendChild(element);
            $(element).draggable({
                containment: "#fl-canvas",
                drag: function() {
                    // let x = $(this).offset().left;
                    // let y = $(this).offset().left;
                    // $(element).attr('data-pos-X', `${x}px`)
                    // $(element).attr('data-pos-Y', `${y}px`)
                    // console.log($(this).offset());
                    //--OK
                    // document.getElementById('10').offsetLeft;
                    // document.getElementById('10').offsetTop
                    // setTimeout(function() {$('.loader-bg').hide();}, 2000)
                },
            });
        });
    }

    static createHtmlObject(object) {
        let attributes = object.attributes;
        const element = document.createElement(object.type);
        element.id = object.id_slide_object || object.id;

        let styles = '';
        const stylesProps = attributes.styles;
        for (var key in stylesProps) {
            styles += `${key}:${stylesProps[key]};`;
        }
        styles += `max-width: 100%;`;
        styles += `max-height: 100%;`;
        element.style = styles;
        
        if (object.type == 'img')
            element.src = `${fls_image_uri}${idSlider}/${attributes.props.srcset}`;

        return element;
    }

}