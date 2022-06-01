<template>
    <div class="min-h-full">
        <Header v-show="isAuthenticated" />
        <main class="flex flex-row min-h-screen justify-center items-center">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 justify-center justify-items-center">
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
        isAuthenticated: localStorage.getItem('user') !== null
      }
    }
};
</script>
