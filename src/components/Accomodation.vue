<script setup lang="ts">
export interface Props {
    image?: string
    name: string
}

const props = withDefaults(defineProps<Props>(), {
    image: 'https://place-hold.it/800x600',
    name: '',
});

const accommodation_image_style = () => ({
    backgroundImage: `url(${props.image})`
});

</script>

<template>
    <div class="accommodation-frame">
        <div class="accommodation-image" :style="accommodation_image_style()"></div>
        <div class="accommodation-name" v-html="name"></div>
    </div>
</template>

<style scoped lang="scss">
.accommodation-frame {
    display: flex;
    flex-direction: column;
    height: 150px;
    align-items: center;
    gap: 5px;
    .accommodation-image {
        width: 100%;
    }
    .accommodation-image {
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
    }
}
</style>
