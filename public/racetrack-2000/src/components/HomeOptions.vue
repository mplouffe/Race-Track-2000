<template>
    <v-container grid-list-lg>
        <v-layout row>
            <v-flex xs12 class="text-xs-center display-1 font-weight-black my-5"
                >So Many Ways To Win</v-flex
            >
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 sm12 md4>
                <v-card>
                    <v-responsive>
                        <v-img src="@/assets/betRaceCard.jpg" height="500px">
                            <v-container fill-height fluid>
                                <v-layout fill-height>
                                    <v-flex xs12 aligh-end flexbox>
                                        <span class="headline white--text"
                                            >BET</span
                                        >
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>
                    </v-responsive>
                    
                    <v-card-text>
                        <div>
                            <h3 class="headline mb-0">Bet</h3>
                            <div>
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Nullam mauris felis, varius
                                rutrum massa a, dignissim ornare dui. Cras eget
                                velit eu dui tristique lobortis sit amet vel
                                tellus.
                            </div>
                        </div>
                    </v-card-text>

                    <v-card-actions v-if="['menu'].includes($route.name)">
                        <v-btn outline block color="green" @click="showRules('bet')">More on Bets</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>

            <v-flex xs12 sm12 md4>
                <v-card>
                    <v-responsive>
                        <v-img src="@/assets/ownHorseCard.jpg" height="500px">
                            <v-container fill-height fluid>
                                <v-layout fill-height>
                                    <v-flex xs12 align-end flexbox>
                                        <span class="headline white--text"
                                            >OWN</span
                                        >
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>
                    </v-responsive>

                    <v-card-text>
                        <div>
                            <h3 class="headline mb-0">Own</h3>
                            <div>
                                Take your winnings from the track and invest in
                                your own horse! When your horse wins, you win.
                                Sell breeding rights and have your winner sire
                                the next generation of champions!
                            </div>
                        </div>
                    </v-card-text>

                    <v-card-actions v-if="['menu'].includes($route.name)">
                        <v-btn outline block color="green" @click="showRules('own')">More on Owning</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>

            <v-flex xs12 sm12 md4>
                <v-card>
                    <v-responsive>
                        <v-img src="@/assets/ponyFightClubCard.jpg" height="500px">
                            <v-container fill-height fluid>
                                <v-layout fill-height>
                                    <v-flex xs12 align-end flexbox>
                                        <span class="headline white--text"
                                            >PONY FIGHTS</span
                                        >
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>
                    </v-responsive>

                    <v-card-text>
                        <div>
                            <h3 class="headline mb-0">Pony Fight Club</h3>
                            <div>
                                Start your own underground pony fight club! Just
                                remember that the first rule of pony fight club
                                is that you do not talk about pony fight club.
                                The second rule is "Neigh"!
                            </div>
                        </div>
                    </v-card-text>

                    <v-card-actions v-if="['menu'].includes($route.name)">
                        <v-btn outline block color="green" @click="showRules('fight')">More on Fights</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    name: "HomeOptions"
};
</script>

<style scoped></style>
