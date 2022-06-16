import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import DashboardView from "../views/DashboardView.vue";
import SubscriptionSelection from "../views/SubscriptionSelection.vue";
import RegistrationView from "../views/RegistrationView.vue";
import GraphView from "../views/GraphView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/stations",
            name: "station.all",
            component: () => import("../views/StationsView.vue"),
        },
        {
            path: "/stations/:stationName",
            name: "station.view",
            component: () => import("../views/StationView.vue"),
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: DashboardView,
        },
        {
            path: "/graphs",
            name: "graphs",
            component: GraphView,
        },
        {
            path: "/subscriptionview",
            name: "register.subscription",
            component: SubscriptionSelection,
        },
        {
            path: "/registrationview",
            name: "registration",
            component: RegistrationView,
        },
    ],
});

// router.beforeEach((to, from, next) => {
//
// })

export default router;
