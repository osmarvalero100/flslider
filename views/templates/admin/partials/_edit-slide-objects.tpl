<template x-for="object in $store.sl.current_slide.slideObjects">
    <template x-if="object.type == 'img'">
        <img :id="object.id" @click="delSlideObject(object.id)">
    </template>
</template>