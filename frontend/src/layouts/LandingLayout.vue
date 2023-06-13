<template>
  <div>
    <header class="absolute inset-x-0 top-0 z-50 flex h-16 border-b border-gray-900/10">
      <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex flex-1 items-center gap-x-6">
          <router-link to="/" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <img class="block h-10 w-auto" src="../assets/images/logo-mini.png" alt="logo-icon">
          </router-link>
        </div>
        <nav class="hidden md:flex md:gap-x-11 md:text-sm md:font-semibold md:leading-6 md:text-gray-700">
          <div v-for="(item, itemIdx) in navigation" :key="itemIdx" @click="openBlock(item.href)" class="cursor-pointer">{{ item.name }}</div>
        </nav>
        <div v-if="isAuthenticated" class="flex flex-1 items-center justify-end gap-x-8">
          <router-link to="/cabinet/notifications" class="-m-2.5 p-2.5 text-gray-500 hover:text-gray-700 relative">
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span class="absolute top-1 right-1 text-xs flex items-center justify-center w-4 h-4 rounded-2xl text-white font-bold bg-red-600">
                1
            </span>
          </router-link>
          <!-- Profile dropdown -->
          <Menu as="div" class="relative">
            <MenuButton class="-m-1.5 flex items-center p-1.5">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-500">
                    <span v-if="info.firstname && info.lastname" class="text-sm font-medium uppercase leading-none text-white">{{info.firstname[0]}}{{info.lastname[0]}}</span>
                </span>
              <span class="hidden lg:flex lg:items-center">
                  <span v-if="info.firstname && info.lastname" class="ml-4 text-sm font-bold leading-6 text-gray-700" aria-hidden="true">{{info.firstname}} {{ info.lastname}}</span>
                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                </span>
            </MenuButton>
            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
              <MenuItems class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                <MenuItem v-slot="{ active }">
                  <router-link
                      to="/cabinet"
                      :class="[active ? 'bg-gray-100' : '', 'w-full items-start justify-start flex px-4 py-2 text-sm text-gray-700']"
                  >
                    Личный кабинет
                  </router-link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <router-link
                      to="/cabinet/profile"
                      :class="[active ? 'bg-gray-100' : '', 'w-full items-start justify-start flex px-4 py-2 text-sm text-gray-700']"
                  >
                    Настройки профиля
                  </router-link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <button
                      :class="[active ? 'bg-gray-100' : '', 'w-full items-start justify-start flex px-4 py-2 text-sm text-gray-700']"
                      @click="isSignOut"
                  >
                    Выход
                  </button>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
          <button type="button" class="-m-2.5 p-2.5 text-gray-700 sm:hidden" @click="mobileMenuOpen = true">
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
        <div v-else class="flex flex-1 items-center justify-end">
          <router-link
              to="/login"
              class="text-sm flex items-center font-semibold leading-6 text-indigo-600 mr-2">
            Присоединиться <div class="mb-1 hidden sm:flex" aria-hidden="true">&rarr;</div></router-link>
          <button type="button" class="-m-2.5 p-2.5 text-gray-700 sm:hidden" @click="mobileMenuOpen = true">
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
      </div>
      <!--Mobile-->
      <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
        <div class="fixed inset-0 z-50" />
        <DialogPanel class="fixed inset-y-0 left-0 z-50 w-full overflow-y-auto bg-white px-4 pb-6 sm:max-w-sm sm:px-6 sm:ring-1 sm:ring-gray-900/10">
          <div class="-ml-0.5 flex h-16 items-center gap-x-6">
            <div class="-ml-0.5">
              <router-link to="/" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                <img class="block h-10 w-auto" src="../assets/images/logo-mini.png" alt="logo-icon">
              </router-link>
            </div>
          </div>
          <div class="mt-2 space-y-2">
            <div
                v-for="item in navigation"
                :key="item.name"
                @click="openBlock(item.href)"
                class="cursor-pointer -mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
              {{ item.name }}
            </div>
          </div>
          <button type="button" class="absolute right-1 top-2 p-2.5 text-gray-700" @click="mobileMenuOpen = false">
            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
          </button>
        </DialogPanel>
      </Dialog>
    </header>
    <main class="py-5 bg-gray-50 landing-content">
      <div class="px-4 sm:px-6 lg:px-8">
        <router-view class="flex-1" v-slot="{Component}">
          <transition name="fade" mode="out-in">
            <component :is="Component"/>
          </transition>
        </router-view>
      </div>
    </main>
  </div>
</template>


<script>
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  Bars3BottomLeftIcon,
  BellIcon,
  CalendarIcon,
  ChartBarIcon,
  FolderIcon,
  HomeIcon,
  InboxIcon,
  UsersIcon,
  XMarkIcon,
  ChevronRightIcon,
  Bars3Icon,
  ChartPieIcon,
  Cog6ToothIcon,
  DocumentDuplicateIcon,
  ChevronDownIcon
} from '@heroicons/vue/24/outline'
import {mapActions, mapGetters, mapState} from "vuex";

export default {
  name: 'LandingLayout',
  components: {
    Bars3BottomLeftIcon,
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    UsersIcon,
    XMarkIcon,
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    ChevronRightIcon,
    Bars3Icon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    ChevronDownIcon
  },
  data() {
    return {
      mobileMenuOpen: false,
      navigation: [
        { name: 'Главная', href: 'home', icon: HomeIcon, current: false },
        { name: 'Путь стажера', href: 'path', icon: FolderIcon, current: false },
        { name: 'Новости', href: 'blog', icon: FolderIcon, current: false },
      ],
    }
  },
  computed: {
    ...mapGetters('auth', ['isAuthenticated']),
    ...mapState('cabinet', ['info']),
  },
  methods: {
    ...mapActions('auth', ['signOut']),
    ...mapActions('cabinet', ['getInfo']),
    isSignOut () {
      this.signOut()
    },
    openBlock (id) {
      const el = document.getElementById(id);
      this.mobileMenuOpen = false
      if(id !== 'home') {
        el.scrollIntoView({behavior: "smooth"});
      }
    }
  },
  async mounted() {
    if(this.isAuthenticated) {
      await this.getInfo()
    }
  }
};
</script>

<style lang="scss" scoped>
.landing-content {
  margin-top: 64px;
  min-height: calc(100vh - 64px);
}
</style>