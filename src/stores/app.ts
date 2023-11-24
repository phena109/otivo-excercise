import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useAppStore = defineStore('app', () => {
    const products = ref([]);
    const areaCityMap = ref([]);

    async function getAreaCityMap() {
        const map = await axios.get('http://localhost/area-city-map');

    }
});
