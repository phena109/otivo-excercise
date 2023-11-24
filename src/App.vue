<script setup lang="ts">
import Accommodation from "@/components/Accomodation.vue";

</script>

<template>
    <header>
        <h1>Welcome! This page will look for Sydney Accommodations for you!</h1>
    </header>
    <div>
        <accommodation
            name="Hello World"
        ></accommodation>
    </div>
</template>

<style scoped>
header h1 {
    text-align: center;
}
</style>
