<script setup lang="ts">
import AccommodationList from "@/components/AccommodationList.vue";
import AreaCityFilter from "@/components/AreaCityFilter.vue";
import {useAppStore} from "@/stores/app";

const store = useAppStore();
</script>

<template>
  <header>
    <h1>Welcome! This page will look for Sydney Accommodations for you!</h1>
  </header>
  <div>
    <area-city-filter
        class="area-city-filter"
        @city-selected="store.getProducts($event)"
    ></area-city-filter>
    <accommodation-list
        class="accommodation-list"
        :list="store.products"
    ></accommodation-list>
  </div>
</template>

<style scoped>
header h1 {
  text-align: center;
}

.area-city-filter {
  margin-top: 15px;
  margin-bottom: 15px;
}

.accommodation-list {
  width: 100%;
}
</style>
