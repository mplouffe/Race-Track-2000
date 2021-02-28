<template>
    <nav>
        <v-navigation-drawer
            v-model="drawer"
            class="brown lighten-2"
            dark
            disable-resize-watcher
            app
        >
            <v-list>
                <template v-for="(item, index) in items">
                    <v-list-item-title :key="index">
                        {{ item.title }}
                    </v-list-item-title>
                    <v-divider :key="`divider-${index}`"></v-divider>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar color="brown darken-4" dark>
            <v-app-bar-nav-icon
                class="hidden-md-and-up"
                @click="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-spacer class="hidden-md-and-up"></v-spacer>
            <router-link to="/">
                <v-toolbar-title>{{ appTitle }}</v-toolbar-title>
            </router-link>
            <div v-if="$auth.isAuthenticated">
                <v-btn to="/menu" class="hidden-sm-and-down">Menu</v-btn>
                <v-btn to="/horses" class="hidden-sm-and-down">Horses</v-btn>
            </div>
            <v-spacer class="hidden-sm-and-down"></v-spacer>
            <div v-if="!$auth.loading">
                <v-btn v-if="!$auth.isAuthenticated" @click="login" class="hidden-sm-and-down">SIGN IN</v-btn>
                <v-btn v-if="$auth.isAuthenticated" @click="logout" class="hidden-sm-and-down">LOG OUT</v-btn>
            </div>
        </v-toolbar>
    </nav>
</template>

<script>
export default {
    name: "AppNavigation",
    methods: {
        login() {
            this.$auth.loginWithRedirect();
        },
        logout() {
            this.$auth.logout({
                returnTo: window.location.origin
            });
        }
    },
    data() {
        return {
            appTitle: "RaceTrack 2000",
            drawer: false,
            items: [{ title: "Menu" }, { title: "Sign In" }, { title: "Join" }]
        };
    }
};
</script>

<style scoped>
a {
    color: white;
    text-decoration: none;
}
</style>
