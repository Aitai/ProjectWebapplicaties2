<template>
  <div class="min-h-screen">
    <Header v-show="$route.name !== 'home'" />
    <div id="offline_msg" class="absolute bg-red-800 opacity-70 z-50 right-0 text-white px-1 hidden">You are offline, <br>you can only view cached pages.</div>
    <main class="flex flex-row min-h-full justify-center items-center">
      <div
        class="w-full max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 justify-center justify-items-center"
      >
        <div class="px-4 py-6 sm:px-0">
          <RouterView />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import Header from "./Header.vue";

export default {
  components: {
    Header,
  },
  data() {
    return {
      isAuthenticated: localStorage.getItem("user") !== null,
    };
  },
};
</script>
