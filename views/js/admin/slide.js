class Slide {

    constructor(id = null, name, order_slide, settings = null, active) {
        this.id = id;
        this.name = name;
        this.order_slide = order_slide
        this.settings = settings;
        this.active = active;
    }

    static getUrlAjaxController(action) {
        return ajaxUrlSlide + '&' + new URLSearchParams({
            ajax: true,
            action: action
        });
    }

    static async getById(id) {
        return await fetch(this.getUrlAjaxController('getById') + '&' + new URLSearchParams({
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

    static async updateOrder(data) {
        return await fetch(this.getUrlAjaxController('updateOrder'), {
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
}