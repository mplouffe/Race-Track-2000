<template>
    <v-container fluid fill-height>
        <v-data-iterator
            :items="horses"
            :items-per-page.sync="horsesPerPage"
            hide-default-footer
        >
            <template v-slot:header>
                <v-toolbar
                    class="mb-2"
                    color="blue"
                    dark
                    flat
                >
                    <v-toolbar-title>Horses</v-toolbar-title>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
                <v-row>
                    <v-col
                        v-for="horse in props.horses"
                        :key="horse.name"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="3"
                    >
                        <v-card>
                            <v-card-title class="subheading font-wheight-bold">
                                {{ horse.name }}
                            </v-card-title>
                            <v-divider></v-divider>

                            <v-list dense>
                                <v-list-item>
                                    <v-list-item-content>Speed:</v-list-item-content>
                                    <v-list-item-content class="align-end">
                                        {{ horse.speed }}
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>Reliability:</v-list-item-content>
                                    <v-list-item-content class="align-end">
                                        {{ horse.reliability }}
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>Variation:</v-list-item-content>
                                    <v-list-item-content class="align-end">
                                        {{ horse.variation }}
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>

<script>
    export default {
        name: 'HorseTable'
    }
</script>