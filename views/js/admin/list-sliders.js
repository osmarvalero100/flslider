Alpine.store("sls", {
    sliders: null,
});

function listSliders() {
    return {
        start: async function() {
            const res = await Slider.getByAll();
            Alpine.store("sls").sliders = await res.json();
        },
    }
}