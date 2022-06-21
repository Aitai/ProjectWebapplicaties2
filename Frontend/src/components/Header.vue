<template>
  <Disclosure
    as="nav"
    class="bg-blue-300 dark:bg-neutral-800 shadow"
    v-slot="{ open }"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img
              v-show="!darkMode"
              class="h-12"
              src="@/assets/LogoSoPoB.png"
              alt="Logo Society for the Protection of Birds"
            />
            <img
              v-show="darkMode"
              class="h-12"
              src="@/assets/LogoSoPoBDarkMode.png"
              alt="Logo Society for the Protection of Birds"
            />
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <RouterLink
                :to="{ name: item.href }"
                v-for="item in navigation"
                :key="item.name"
                :class="[
                  $route.name == item.href
                    ? 'bg-yellow-200 dark:bg-gray-700'
                    : 'text-black hover:bg-sky-200 dark:hover:bg-gray-700',
                  'text-black dark:text-white px-3 py-2 rounded-md text-sm font-medium',
                ]"
                :aria-current="item.current ? 'page' : undefined"
                >{{ item.name }}</RouterLink
              >
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <button
              @click="toggleDarkMode"
              type="button"
              class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
            >
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Profile dropdown -->
            <Menu as="div" class="ml-3 relative">
              <div>
                <MenuButton
                  class="max-w-xs bg-gray-800 text-gray-400 p-1 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                >
                  <span class="sr-only">Open user menu</span>
                  <UserIcon class="h-6 w-6" aria-hidden="true" />
                </MenuButton>
              </div>
              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <MenuItem
                    v-for="item in userNavigation"
                    :key="item.name"
                    v-slot="{ active }"
                  >
                    <a
                      :href="item.href"
                      :class="[
                        active ? 'bg-gray-100' : '',
                        'block px-4 py-2 text-sm text-gray-700',
                      ]"
                      @click="logOut(item.name)"
                      >{{ item.name }}</a
                    >
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <DisclosureButton
            class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
          >
            <span class="sr-only">Open main menu</span>
            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
      </div>
    </div>

    <DisclosurePanel class="md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <RouterLink
          :to="{ name: item.href }"
          v-for="item in navigation"
          :key="item.name"
          :class="[
            $route.name == item.href
              ? 'bg-gray-300'
              : 'text-gray-300 hover:bg-gray-200',
            'text-black block px-3 py-2 rounded-md text-base font-medium',
          ]"
          :aria-current="item.current ? 'page' : undefined"
          >{{ item.name }}</RouterLink
        >
      </div>
      <div class="pt-4 pb-3 border-t border-gray-700">
        <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <UserIcon />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-none text-white">
              {{ user.name }}
            </div>
            <div class="text-sm font-medium leading-none text-gray-400">
              {{ user.email }}
            </div>
          </div>
          <button
            type="button"
            class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
          >
            <span class="sr-only">View notifications</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
        <div class="mt-3 px-2 space-y-1">
          <DisclosureButton
            v-for="item in userNavigation"
            :key="item.name"
            as="button"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-200"
            @click="logOut(item.name)"
            >{{ item.name }}</DisclosureButton
          >
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { BellIcon, MenuIcon, XIcon, UserIcon } from "@heroicons/vue/outline";
import { RouterLink } from "vue-router";

const user = {
  name: "Admin account",
  email: "admin@admin.nl",
};
const navigation = [
    { name: "Dashboard", href: "dashboard" },
    { name: "Weather stations", href: "station.all" },
];

const userNavigation = [
  { name: "Your Profile", href: "#" },
  { name: "Settings", href: "#" },
  { name: "Sign out", href: "#" },
];

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
    RouterLink,
    UserIcon,
  },
  data() {
    return {
      darkMode: false,
    };
  },
  methods: {
    toggleDarkMode() {
      document.querySelector("html").classList.toggle("dark");
      this.darkMode = !this.darkMode;
    },
    logOut(clicked_button) {
        if (clicked_button === 'Sign out') {
            localStorage.removeItem("user")
            this.$router.replace("/");
        }
    },
  },
  setup() {
    return {
      user,
      navigation,
      userNavigation,
    };
  },
};
</script>
