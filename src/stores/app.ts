import {defineStore} from "pinia";
import axios from "axios";
import type {Area, City} from "@/lib/definitions";

export const useAppStore = defineStore('app', () => {
    const products: any[] = [];
    let areaCityMap: City[] = [];
    let areas: Area[] = [];

    async function pullAreaCityMap() {
        try {
            const response = await axios.get<{ [area: string]: string[] }>('http://localhost/api/area-city-map');
            const data = response.data;

            areaCityMap = Object.entries(data).flatMap(([area, cityList]: [string, string[]]) =>
                cityList.map(city => ({area, city}))
            );
            areas = Object.keys(data).map(name => ({name}));
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    return {products, areaCityMap, areas, pullAreaCityMap};
});
