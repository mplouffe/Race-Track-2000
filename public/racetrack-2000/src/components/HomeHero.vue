<template>
    <v-container
        fluid
        fill-height
        class="home-hero"
    >
        <v-layout justify-center align-center column>
            <div class="display-4 font-weight-black light-blue--text outline text-xs-center">
                RaceTrack 2000
            </div>
            <div class="display-4 font-weight-black light-blue--text outline text-xs-center mb-3">
                The Ulitmate Surreal Race Betting Site
            </div>
            <div class="display-1 font-weight-bold light-blue--text outline text-xs-center">
                All the fun of gambling without any of the money
            </div>
            <v-btn fab class="mt-5 brown darken-4">
                <v-icon large color="white">mdi-arrow-expand-down</v-icon>
            </v-btn>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    name: "HomeHero"
};
</script>

<style scoped>
.home-hero {
    background: url("../assets/tempSplash.jpg");
    background-size: cover;
    width: 100%;
    padding: 0;
    text-shadow: 2px 2px #000;
}
</style>
