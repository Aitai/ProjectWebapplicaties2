<template>
    <!--
    Template    = HTML
    Style       = CSS
    Script      = JavaScript


<div class="pt-6 md:p-8 text-center md:text-left space-y-4">
    Subscription
</div>

<div class="" >

</div>

<div class="card w-96 bg-base-100 shadow-xl">
  <figure><img src="https://api.lorem.space/image/shoes?w=400&h=225" alt="Shoes" /></figure>
  <div class="pt-6 : md: p-6 card-body">
    <h2 class="card-title">Basis pakket</h2>
    <p>
        - v1
        <br>
        - v2
    </p>
    <a class=" inline-block px-4 py-3
    text-sm font-semibold text-center
    text-white uppercase transition
    duration-200 ease-in-out bg-indigo-600
    rounded-md cursor-pointer
    hover:bg-indigo-700">Button</a>


  </div>
</div>

-->

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
            <title>Tailwind Pricing Component</title>
        </head>
        <body class="sans h-full py-16 antialiased bg-primary-grey">
            <header class="flex flex-col items-center mb-1">
                <h2 class="text-3xl text-primary-white font-bold">
                    Keuze abonnement
                </h2>
                <h3 class="text-1xl text-primary-white font-bold">2 van 2</h3>
            </header>
            <section
                class="flex flex-col lg:flex-row items-start items-center lg:justify-center w-full w-full lg:px-10 py-12"
            >
                <article
                    class="rounded-3xl bg-white w-4/5 lg:w-custom mb-10 lg:px-4 py-10 pt-5 text-center text-primary-dark"
                >
                    <h5 class="font-bold text-base">Basis</h5>
                    <h2
                        class="pb-4 flex justify-center font-bold border-b border-gray-100"
                    >
                        <span class="text-6xl mr-1">€</span
                        ><span class="text-6xl"> 10</span>
                    </h2>
                    <ul class="text-sm font-bold">
                        <li class="pt-4 pb-4 border-b border-gray-300">
                            Data wordt per 24 uur ververst
                        </li>
                        <li class="pt-3 pb-4 border-b border-gray-300">
                            Voor één weer station
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-300">
                            Actuele informatie
                        </li>

                        <!--<li class="pt-4 pb-4 border-b border-gray-300"></li>-->
                    </ul>

                    <button
                        class="inline-block px-4 py-3 mt-2 text-sm font-semibold text-center text-white uppercase transition duration-200 ease-in-out bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700"
                    >
                        Subscribe
                    </button>
                </article>

                <article
                    class="rounded-3xl bg-blue-100 w-4/5 lg:w-custom mb-10 lg:px-4 py-5 text-center text-primary-dark"
                >
                    <h5 class="font-bold text-base">Basis Plus</h5>
                    <h2
                        class="font-bold pb-4 mt-2 border-b border-gray-100 flex justify-center"
                    >
                        <span class="text-6xl mr-1">€</span
                        ><span class="text-6xl"> 20</span>
                    </h2>
                    <ul class="text-sm font-bold">
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Data wordt per uur ververst
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Data voor 5 weerstations
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Maakt het mogelijk om stations te vergelijken
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Meerdere stations als favorieten opslaan
                        </li>
                    </ul>
                    <button
                        class="inline-block px-4 py-3 mt-2 text-sm font-semibold text-center text-white uppercase transition duration-200 ease-in-out bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700"
                    >
                        Subscribe
                    </button>
                </article>

                <article
                    class="rounded-3xl bg-yellow-200 w-4/5 lg:w-custom mb-10 lg:px-4 py-8 text-center text-primary-dark"
                >
                    <h5 class="font-bold text-base">Deluxe</h5>
                    <h2
                        class="flex justify-center pb-4 font-bold border-b border-gray-200"
                    >
                        <span class="text-6xl mr-1">€</span
                        ><span class="text-6xl">50</span>
                    </h2>
                    <ul class="text-sm font-bold">
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Data wordt constant ververst
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Data voor alle weerstations
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Toegang tot historische data
                        </li>
                        <li class="pt-4 pb-4 border-b border-gray-200">
                            Maakt het mogelijk om stations te vergelijken.
                        </li>
                    </ul>
                    <button
                        class="inline-block px-4 py-3 mt-2 text-sm font-semibold text-center text-black uppercase transition duration-200 ease-in-out bg-yellow-400 rounded-md cursor-pointer hover:bg-yellow-500"
                    >
                        Subscribe
                    </button>
                </article>
            </section>
        </body>
    </html>
</template>
