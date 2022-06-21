import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import DashboardView from "../views/DashboardView.vue";

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
    ],
});

// router.beforeEach((to, from, next) => {
//
// })

export default router;
