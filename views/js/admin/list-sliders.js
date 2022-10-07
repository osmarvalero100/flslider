Alpine.store("sls", {
    sliders: null,
});

function listSliders() {
    return {
        start: async function() {
            const res = await Slider.getByAll();
            Alpine.store("sls").sliders = await res.json();
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