import {defineStore} from "pinia";
import axios from "axios";
import {reactive, ref} from "vue";

export const useAppStore = defineStore('app', () => {
    const products: any[] = reactive([]);
    let areaCityMap: {
        [area: string]: string[]
    } = reactive({});
    let areas: string[] = reactive([]);
    let loadingAreaCityMap = ref(false);
    let loadingProducts = ref(false);

    async function pullAreaCityMap() {
        try {
            loadingAreaCityMap.value = true
            const response = await axios
                .get<{
                    [area: string]: string[]
                }>('http://localhost/api/area-city-map');
            const data = response.data;
            for (const area in data) {
                if (data.hasOwnProperty(area)) {
                    areaCityMap[area] = data[area];
                }
            }
            areas.splice(0, areas.length, ...Object.keys(data));
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            loadingAreaCityMap.value = false;
        }
    }

    async function getProducts(value: string) {
        try {
            products.length = 0;
            loadingProducts.value = true;
            const params = {by: 'city', value};
            const response = await axios.get<{
                page: Number,
                size: Number,
                total: Number,
                data: {
                    productName: string,
                    productImage: string,
                    addresses: { area: string, city: string }[]
                }[]
            }>('http://localhost/api/products', {params});

            response.data?.data.map(({productName, productImage}) => ({
                name: productName,
                image: productImage
            })).forEach(product => products.push(product));
        } catch (error) {
            console.error(`Unable to get products of the requested city (${value})`);
        } finally {
            loadingProducts.value = false;
        }
    }

    return {products, areaCityMap, areas, pullAreaCityMap, getProducts, loadingAreaCityMap, loadingProducts};
});
