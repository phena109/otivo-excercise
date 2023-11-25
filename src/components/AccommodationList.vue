<script setup lang="ts">
import Accommodation from "@/components/Accommodation.vue";
import type {AccommodationListProps, AccommodationProps} from "@/lib/definitions";

const props = withDefaults(defineProps<AccommodationListProps>(), {
  list: () => []
});

let loading = false;

</script>

<template>
  <div class="accommodation-list" v-if="!loading">
    <accommodation
        class="accommodation"
        v-for="a in list"
        :name="a.name"
        :image="a.image"
    ></accommodation>
  </div>
  <div v-if="loading">Loading...</div>
</template>

<style lang="scss" scoped>
.accommodation-list {
  display: flex;
  flex-direction: row;
  gap: 10px;
  .accommodation {
    flex-basis: 25%;
  }
}


</style>
