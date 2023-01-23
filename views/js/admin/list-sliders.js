Alpine.store("sls", {
    sliders: null,
    sliderForm: {
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
    }
});

function listSliders() {
    return {
        start: async function() {
            const res = await Slider.getByAll();
            Alpine.store("sls").sliders = await res.json();
            hideLoader();
        },
        createSlider: async function() {
            showLoader();
            const res = await Slider.save(Alpine.store("sls").sliderForm);
            const newSlider = await res.json();
            if (newSlider.hasOwnProperty("id")) {
                window.location.href = flSlider+"&edit="+newSlider.id;
            } else {
                FlCuteToast({type: 'error', title: 'error', message: 'Error al crear el slider'});
            }
            hideLoader();
        },
        changeStatus: async function(slideId) {
            showLoader();
            const res = await Slider.changeStatus({id: slideId});
            if (res.status != 204) {
                const data = await res.json();
                let message = 'No fue posible cambiar el estado.';
                if (data.hasOwnProperty('error'))
                    message = data.error;
                FlCuteToast({type: 'error', title: 'Error', message: message});
            } else {
                const slider = Alpine.store("sls").sliders.find(el => el.id_slider == slideId);
                if (slider.active == 0) {
                    slider.active = 1;
                } else {
                    slider.active = 0;
                }
                FlCuteToast({type: 'success', title: '¡Éxito!', message: 'Cambio de estado realizado.'});
            }
            hideLoader();
        },
        delSlider: async function(idSlider) {
            const slider = Alpine.store("sls").sliders.find(el => el.id_slider == idSlider);
            FlsConfirm({
                message: `¿Realmente quieres eliminar el slider <strong> #${slider.id_slider} - ${slider.name}</strong> de forma permanente?`
            }).then(async (willDelete) => {
                if (willDelete) {
                    showLoader();
                    const data = {
                        id: idSlider,
                    };
                    const res = await Slider.remove(data);
                    if (res.status == 204) {
                        const index = Alpine.store("sls").sliders.findIndex(sls => sls.id == idSlider);
                        Alpine.store("sls").sliders.splice(index, 1);
                        FlsToast({type: 'success', title: '¡Éxito!', message: `Slider #${idSlider} eliminado.`})
                    } else {
                        FlsToast({type: 'error', title: 'Error', message: `No fue posible eliminar el slider.`})
                    }
                    hideLoader();
                }
            });
        },
    }
}