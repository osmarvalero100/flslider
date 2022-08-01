{literal}
    <template x-for="device in $store.sl.slider.devices">
        <template x-for="slide in device.slides" :key="slide.id">
            <template x-if="slide.id == $store.sl.current_slide.id">
                <template x-for="object in slide.slideObjects" :key="object.id">
                    <template x-if="object.type == 'img'">
                        <img :id="object.id" @click="delSlideObject(object.id)"
                            x-bind:src="fls_image_uri+ $store.sl.slider.id +'/'+ object.attributes.props.src"
                            x-bind:style="object.attributes.styles"
                            class="object"
                        >
                    </template>
                </template>
            </template>
        </template>
    </template> 
{/literal}
