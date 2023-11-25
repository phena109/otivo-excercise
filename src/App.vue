<script setup lang="ts">
import Accommodation from "@/components/Accommodation.vue";
import { useAppStore } from "@/stores/app";
import AccommodationList from "@/components/AccommodationList.vue";

const store = useAppStore();


</script>

<template>
    <header>
        <h1>Welcome! This page will look for Sydney Accommodations for you!</h1>
    </header>
    <div>
        <accommodation-list
            :list="[
                {
                    name: 'accommodation 1'
                },
                {
                    name: 'two'
                }
            ]"
        ></accommodation-list>
    </div>
</template>

<style scoped>
header h1 {
    text-align: center;
}
</style>
