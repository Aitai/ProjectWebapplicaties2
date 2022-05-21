<template>
    <div class="min-h-full">
        <Header />
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
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
};
</script>
