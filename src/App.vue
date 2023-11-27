<script setup lang="ts">
import AccommodationList from "@/components/AccommodationList.vue";
import AreaCityFilter from "@/components/AreaCityFilter.vue";
</script>

<template>
  <header>
    <h1>Welcome! This page will look for Sydney Accommodations for you!</h1>
  </header>
  <div>
    <area-city-filter
        @city-selected="console.log($event);"
    ></area-city-filter>
    <accommodation-list
        :list2="[
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
