class Slider {

    constructor(id = null, name, settings = null, active, dateStart = null, dateEnd = null) {
        settings = Slider.defaultSettings(settings);
            
        this.id = id;
        this.name = name;
        this.settings = settings;
        this.active = active;
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
    }

    static defaultSettings(settings) {
        if (settings == null){
            return {
                desktop: {
                    styles: {}
                },
                tablet: {
                    styles: {}
                },
                mobile: {
                    styles: {}
                },
            }
        }
        if (!settings.hasOwnProperty('desktop')){
            settings.desktop = {
                styles: {}
            }
        }
        if (!settings.hasOwnProperty('tablet')){
            settings.tablet = {
                styles: {}
            }
        }
        if (!settings.hasOwnProperty('mobile')){
            settings.mobile = {
                styles: {}
            }
        }
        return settings;
    }

    static getUrlAjaxController(action) {
        return ajaxUrlSlider + '&' + new URLSearchParams({
            ajax: true,
            action: action
        });
    }

    static async getByAll() {
        return await fetch(this.getUrlAjaxController('getAll'));
    }
    static async getById(id) {
        return await fetch(this.getUrlAjaxController('getById') + '&' + new URLSearchParams({
            id: id
        }));
    }
    static async getEditById(id) {
        return await fetch(this.getUrlAjaxController('getEditById') + '&' + new URLSearchParams({
            id: id
        }));
    }

    static async save(data) {
        return await fetch(this.getUrlAjaxController('save'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
    }

    static async changeStatus(data) {
        return await fetch(this.getUrlAjaxController('changeStatus'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
    }

    static async remove(data) {
        return await fetch(this.getUrlAjaxController('delete'), {
            method: 'POST',
            body: JSON.stringify(data),
        });
    }

    static getElementCanvas() {
        return document.getElementById('fl-canvas');
    }

    static getSettings() {
        return JSON.parse(slider.settings);
    }

    static setSizeCanavas() {
        const canvas = Slider.getElementCanvas();
        const settings = Slider.getSettings();
        console.log(settings)
        canvas.style.width = settings[activeDevice].size.width;
        canvas.style.height = settings[activeDevice].size.height;
    }
}