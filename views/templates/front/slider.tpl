<style>
.full-width {
 width: 100vw !important;
 position: relative;
 margin-left: -50vw !important;
 left: 50%;
}
/*Main*/
.fl-slider {
    margin: 0;
    padding: 0;
}
.gallery {
    width: 100%;
    height: 300px;
    position: relative;
}
.gallery .photos {
    position: relative;
    height: auto;
}
.gallery .block {
    height: auto;
    width: 100%;
    position: absolute;
    left: 0;
    opacity: 0;
    transition: opacity 1s;
}
.gallery .block img {
    height: 300px;
    max-width: 100%;
}
.gallery .buttons {
    position: absolute;
    width: 100%;
    top: 40%;
    font-size: 24px;
}
.gallery .buttons .prev {
    border-radius: 0 3px 3px 0;
    float: left;
}
.gallery .buttons .next {
    border-radius: 3px 0 0 3px;
    float: right;
}
.gallery .buttons a {
    z-index: 4;
    position: relative;
    color: #ffffff;
    background-color: rgba(0, 0, 0, 0.25);
    text-decoration: none;
    display: inline-block;
    padding: 24px 16px;
}
.gallery .block.active {
    opacity: 1;
}
</style>
<div id="flslider_{$slider.id_slider}" class="fl-slider full-width">
    <div class="gallery">
        <div class="photos">
            {foreach from=$slider.slides item=slide key=key}
            <div class="slide block {if $key==0}active{/if}">
                {foreach from=$slide.objects item=object}
                    <img
                    {foreach from=$object.attributes['props'] item=prop key=key }
                        {$key}="{$prop}"
                    {/foreach}
                    >
                {/foreach}
                
            </div>
            {/foreach}
            
            
    </div>
        <div class="buttons">
            <a class="prev" href="#">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            </a>
            <a class="next" href="#">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
            </a>
        </div>
    </div>
</div>


<script>
function flSlider(idSlider) {
    let nextBtn = document.querySelector("#"+idSlider+" .gallery .buttons .next"),
        prevBtn = document.querySelector("#"+idSlider+" .gallery .buttons .prev"),
        slide = document.querySelectorAll("#"+idSlider+" .gallery .photos .block"),
        i = 0;

    prevBtn.onclick = (event) => {
        event.preventDefault();

        slide[i].classList.remove("active");
        i--;

        if (i < 0) {
            i = slide.length - 1;
        }
        slide[i].classList.add("active");
    };

    nextBtn.onclick = (event) => {
        event.preventDefault();

        slide[i].classList.remove("active");
        i++;

        if (i >= slide.length) {
            i = 0;
        }

        slide[i].classList.add("active");
    };

    slider_callback();
    let sliderInterval = window.setInterval(slider_callback, 3000);

    function slider_callback() {
        nextBtn.click();
    }
}

const flSliders = document.querySelectorAll(".fl-slider");
if (flSliders.length > 0) {
    flSliders.forEach(sl => {
        flSlider(sl.id);
    });
}

</script>