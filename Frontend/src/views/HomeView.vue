<template>
    <div
        class="mx-auto p-4 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md sm:p-6 lg:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div>
            <h5 class="mb-6 text-xl font-medium text-gray-900 dark:text-white text-center">
                Society for the Protection of Birds
            </h5>
            <p ref="errorField" class="text-red-600" />
            <fieldset :disabled="disableForm" class="contents space-y-6">

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email
                        address</label>
                    <input type="email" v-model="email" name="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required />
                </div>
                <div>
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                    <input type="password" v-model="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required />
                </div>

                <button :disabled="disableForm" type="submit" @click="login"
                :class="disableForm ? 'bg-blue-400 dark:bg-blue-400' : 'bg-blue-700 dark:bg-blue-600'"
                    class="w-full text-white  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Sign in
                </button>
            </fieldset>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        if (localStorage.hasOwnProperty("user")) {
            this.$router.replace("/dashboard");
        }
    },
    data() {
        return {
            disableForm: false,
        }
    },
    methods: {
        login() {
            this.disableForm = true;
            this.$refs.errorField.innerText = "";
            this.$axios
                .post("/authentication", {
                    email: this.email,
                    password: this.password,
                })
                .then((success) => {
                    let user = {
                        api_token: success.data.token,
                    };

                    localStorage.setItem("user", JSON.stringify(user));
                    this.$router.replace("/dashboard");
                })
                .catch((error) => {
                    if (error.response) {
                        this.$refs.errorField.innerText = error.response.data.message;
                    }
                })
                .finally(() => {
                    this.disableForm = false;
                });
        },
    },
};
</script>
