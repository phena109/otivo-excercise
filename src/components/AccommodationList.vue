<script setup lang="ts">
import Accommodation from "@/components/Accommodation.vue";
import type {AccommodationListProps} from "@/lib/definitions";
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
  --totalColumn: 4;
  --gapSize: 10px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: var(--gapSize);
  width: 100%;
  .accommodation {
    flex-basis: calc((100% - (var(--gapSize) * (var(--totalColumn) - 1))) / var(--totalColumn));
  }
}


</style>
