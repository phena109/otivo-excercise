<script setup lang="ts">
import Accommodation from "@/components/Accommodation.vue";
import type {AccommodationListProps} from "@/lib/definitions";
import ProgressSpinner from "primevue/progressspinner";
import BlockUI from "primevue/blockui";
import {useAppStore} from "@/stores/app";

const store = useAppStore();
const props = withDefaults(defineProps<AccommodationListProps>(), {
  list: () => []
});
</script>

<template>
  <block-u-i :blocked="store.loadingProducts">
    <div class="accommodation-list">
      <accommodation
          class="accommodation"
          v-for="a in list"
          :name="a.name"
          :image="a.image"
      ></accommodation>
      <progress-spinner v-if="store.loadingProducts"/>
    </div>
  </block-u-i>
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
  position: relative;
  min-height: calc(max(100px, 30vh));

  .accommodation {
    flex-basis: calc((100% - (var(--gapSize) * (var(--totalColumn) - 1))) / var(--totalColumn));
    margin-bottom: 5px
  }
}
</style>
