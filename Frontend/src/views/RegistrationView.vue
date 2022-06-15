<template>
    <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            />
            <link
                href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap"
                rel="stylesheet"
            />
            <link rel="stylesheet" href="/css/styles.css" />
            <title>Tailwind Registration</title>
        </head>
        <body>
            <header class="flex flex-col items-center mb-1">
                <h2 class="text-3xl text-primary-white font-bold">
                    Keuze abonnement
                </h2>
                <h3 class="text-1xl text-primary-white font-bold">1 van 2</h3>
            </header>

            <div
                class="flex items-center justify-center min-h-screen bg-gray-100"
            >
                <div
                    class="px-8 py-6 mx-4 mt-4 text-left bg-white shadow-lg md:w-1/3 lg:w-1/3 sm:w-1/3"
                >
                    <div class="flex justify-center">
                        <img
                            v-show="!darkMode"
                            class="h-12"
                            src="@/assets/LogoSoPoB.png"
                            alt="Logo IWA"
                        />
                        <img
                            v-show="darkMode"
                            class="h-12"
                            src="@/assets/LogoSoPoBDarkMode.png"
                            alt="Logo Society of Protection of Birds"
                        />

                        <!--
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-red-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path
                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>

            -->
                    </div>
                    <h3 class="text-2xl font-bold text-center">Word lid!</h3>
                    <form action="">
                        <div class="mt-4">
                            <div>
                                <label class="block" for="Name">Naam</label>
                                <input
                                    type="text"
                                    placeholder="Naam"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                            </div>
                            <div class="mt-4">
                                <label class="block" for="email">Email</label>
                                <input
                                    type="text"
                                    placeholder="Email"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                            </div>
                            <div class="mt-4">
                                <label class="block">Wachtwoord</label>
                                <input
                                    type="password"
                                    placeholder="Wachtwoord"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                            </div>
                            <div class="mt-4">
                                <label class="block">Bevestig Wachtwoord</label>
                                <input
                                    type="password"
                                    placeholder="Wachtwoord"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                            </div>
                            <span class="text-xs text-red-400"
                                >Het wachtwoord moet hetzelfde zijn!</span
                            >
                            <div class="flex">
                                <button
                                    class="w-full px-6 py-2 mt-4 text-white bg-indigo-700 rounded-lg hover:bg-indigo-900"
                                >
                                    Maak een Account
                                </button>
                            </div>
                            <div class="mt-6 text-grey-dark">
                                Heeft u al een account?
                                <a
                                    class="text-blue-600 hover:underline"
                                    href="#"
                                >
                                    Inloggen
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </body>
    </html>
</template>
