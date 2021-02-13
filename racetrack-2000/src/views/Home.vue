<template>
    <span>
        <home-hero></home-hero>
        <home-details></home-details>
        <home-options></home-options>
    </span>
</template>

<script>
import HomeHero from "@/components/HomeHero";
import HomeDetails from "@/components/HomeDetails";
import HomeOptions from "@/components/HomeOptions";

export default {
    name: "Home",
    components: {
        HomeHero,
        HomeDetails,
        HomeOptions
    }
};
</script>
