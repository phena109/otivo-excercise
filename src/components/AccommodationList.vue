<script setup lang="ts">
import Accommodation from "@/components/Accommodation.vue";
import type {AccommodationListProps, AccommodationProps} from "@/lib/definitions";

const props = withDefaults(defineProps<AccommodationListProps>(), {
  list: () => []
});

</script>

<template>
  <div class="accommodation-list">
    <accommodation
        class="accommodation"
        v-for="a in list"
        :name="a.name"
        :image="a.image"
    ></accommodation>
  </div>
</template>

<style lang="scss" scoped>
.accommodation-list {
  display: flex;
  flex-direction: row;
  gap: 10px;
  .accommodation {
    flex-basis: 33%;
  }
}


</style>
