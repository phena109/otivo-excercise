<script setup lang="ts">
import Dropdown from 'primevue/dropdown';
import {useAppStore} from "@/stores/app";
import {computed, onMounted, ref, watch} from "vue";
import BlockUI from "primevue/blockui";
import ProgressSpinner from "primevue/progressspinner";

const store = useAppStore();
onMounted(() => {
  store.pullAreaCityMap()
})

const emit = defineEmits(['citySelected']);

let selectedArea = ref('');
let selectedCity = ref('');
watch(selectedCity, nv => emit('citySelected', nv));

const citiesOptions = computed(() => selectedArea.value ? store.areaCityMap[selectedArea.value] : []);
const citiesPlaceholder = (areaOfInterest: string) => "Select City or Suburb" + (areaOfInterest ? ` in ${selectedArea.value}` : '');
</script>

<template>
  <block-u-i :blocked="store.loadingAreaCityMap">
    <div class="filters">
      <dropdown
          v-model="selectedArea"
          :options="store.areas"
          placeholder="Select an Area"
      ></dropdown>
      <dropdown
          v-if="selectedArea"
          v-model="selectedCity"
          :options="citiesOptions"
          :placeholder="citiesPlaceholder(selectedArea)"
      ></dropdown>
      <progress-spinner v-if="store.loadingAreaCityMap"/>
    </div>
  </block-u-i>
</template>

<style scoped lang="scss">
.filters {
  display: flex;
  flex-direction: row;
  justify-content: center;
  gap: 10px;
  position: relative;
}
</style>
