import {defineStore} from "pinia";
import axios from "axios";
import {reactive} from "vue";

export const useAppStore = defineStore('app', () => {
    const products: any[] = [];
    let areaCityMap: { [area: string]: string[] } = reactive({});
    let areas: string[] = reactive([]);

    async function pullAreaCityMap() {
        try {
            const response = await axios.get<{ [area: string]: string[] }>('http://localhost/api/area-city-map');
            const data = response.data;
            for (const area in data) {
                if (data.hasOwnProperty(area)) {
                    areaCityMap[area] = data[area];
                }
            }
            areas.splice(0, areas.length, ...Object.keys(data));
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    return {products, areaCityMap, areas, pullAreaCityMap};
});
