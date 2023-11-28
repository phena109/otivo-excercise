<script setup lang="ts">
import AccommodationList from "@/components/AccommodationList.vue";
import AreaCityFilter from "@/components/AreaCityFilter.vue";
import {useAppStore} from "@/stores/app";
import BlockUI from "primevue/blockui";
import ProgressSpinner from "primevue/progressspinner";

const store = useAppStore();

</script>

<template>
  <header>
    <h1>Welcome! This page will look for Sydney Accommodations for you!</h1>
  </header>
  <div>
    <block-u-i :blocked="store.loadingAreaCityMap">
      <area-city-filter
          @city-selected="store.getProducts($event)"
      ></area-city-filter>
      <progress-spinner v-if="store.loadingAreaCityMap"/>
    </block-u-i>
    <block-u-i :blocked="store.loadingProducts">
      <accommodation-list
          class="accommodation-list"
          :list="store.products"
      ></accommodation-list>
      <progress-spinner v-if="store.loadingProducts"/>
    </block-u-i>
  </div>
</template>

<style scoped>
header h1 {
  text-align: center;
}
.accommodation-list {
  width: 100%;
}
</style>
