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
        },
        createSlider: async function() {
            const res = await Slider.save(Alpine.store("sls").sliderForm);
            const newSlider = await res.json();
            if (newSlider.hasOwnProperty("id")) {
                window.location.href = flSlider+"&edit="+newSlider.id;
            } else {
                FlCuteToast({type: 'error', title: 'error', message: 'Error al crear el slider'});
            }
        },
        delSlider: async function(idSlider) {
            FlCuteAlert({
                title: `#${idSlider}`,
                message: "¿Está seguro, que quiere eliminar este slider?",
                type: "question",
                confirmText: "Eliminar",
                cancelText: "Cancelar"
            })
            .then(async (willDelete) => {
                if (willDelete) {
                    const data = {
                        id: idSlider,
                    };
                    const res = await Slider.remove(data);
                    if (res.status == 204) {
                        const index = Alpine.store("sls").sliders.findIndex(sls => sls.id == idSlider);
                        Alpine.store("sls").sliders.splice(index, 1);
                        FlCuteToast({type: 'success', title: '¡Éxito!', message: `Slider #${idSlider} eliminado.`})
                    } else {
                        FlCuteToast({type: 'error', title: 'Error', message: `No fue posible eliminar el slider.`})
                    }
                }
            });
        },
    }
}