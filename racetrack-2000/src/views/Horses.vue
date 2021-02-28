<template>
    <v-container fluid>
        <v-layout>
            <horse-table
                v-bind:horses="horses"
                v-bind:horses-per-page="horsesPerPage"
            ></horse-table>
        </v-layout>
    </v-container>
</template>

<script>
import HorseTable from '../components/HorseTable'

export default {
    name: 'Horses',
    components: {
        HorseTable
    },
    data() {
        return {
            horses: [
                {
                    name: 'Frozen Yogurt',
                    speed: 80,
                    reliability: 75,
                    variation: 60
                },
                {
                    name: 'Cupcake',
                    speed: 65,
                    reliability: 90,
                    variation: 30
                },
            ],
            horsesPerPage: 4
        }
    }
}
</script>

<style scoped>
</style>