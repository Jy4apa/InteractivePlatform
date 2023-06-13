<template>
  <div>
    <!-- sidebar left mobile -->
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                  <router-link to="/" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                    <img class="block h-10 w-auto" src="../assets/images/logo-mini.png" alt="logo-icon">
                  </router-link>
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in navigation" :key="item.name">
                          <router-link :to="item.href" @click="sidebarOpen = false" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                          </router-link>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <div class="text-xs font-semibold leading-6 text-gray-500">Настройки профиля</div>
                      <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li v-for="team in teams" :key="team.name">
                          <router-link :to="team.href" @click="sidebarOpen = false" :class="[team.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                            <span :class="[team.current ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-gray-200 group-hover:border-indigo-600 group-hover:text-indigo-600', 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white']">{{ team.initial }}</span>
                            <span class="truncate">{{ team.name }}</span>
                          </router-link>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- sidebar left desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
          <router-link to="/" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            <img class="block h-10 w-auto" src="../assets/images/logo-mini.png" alt="logo-icon">
          </router-link>
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li v-for="item in navigation" @click="sidebarOpen = false" :key="item.name">
                  <router-link :to="item.href" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                    <component :is="item.icon" :class="[item.current ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                    {{ item.name }}
                  </router-link>
                </li>
              </ul>
            </li>
            <li>
              <div class="text-xs font-semibold leading-6 text-gray-500">Настройки профиля</div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li v-for="team in teams" :key="team.name">
                  <router-link :to="team.href" @click="sidebarOpen = false" :class="[team.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                    <span :class="[team.current ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-gray-200 group-hover:border-indigo-600 group-hover:text-indigo-600', 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white']">{{ team.initial }}</span>
                    <span class="truncate">{{ team.name }}</span>
                  </router-link>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="lg:pl-72">
      <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6 justify-end">
          <!-- navigationLanding -->
          <nav class="hidden sm:flex sm:gap-x-11 sm:text-sm sm:font-semibold sm:leading-6 sm:text-gray-700 relative flex-1 items-center">
            <router-link v-for="(item, itemIdx) in navigationLanding" :key="itemIdx" :to="`/#${item.href}`">{{ item.name }}</router-link>
          </nav>

          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <router-link to="/cabinet/notifications" class="-m-2.5 p-2.5 text-gray-500 hover:text-gray-700 relative">
              <BellIcon class="h-6 w-6" aria-hidden="true" />
              <span class="absolute top-1 right-1 text-xs flex items-center justify-center w-4 h-4 rounded-2xl text-white font-bold bg-red-600">
                1
              </span>
            </router-link>

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true" />

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
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 sm:hidden" @click="mobileLandingMenuOpen = true">
              <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile sidebarLanding mobile -->
      <TransitionRoot as="template" :show="mobileLandingMenuOpen">
        <Dialog as="div" class="relative z-50 lg:hidden" @close="mobileLandingMenuOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-900/80" />
          </TransitionChild>

          <div class="fixed inset-0 flex justify-end">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="-translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="relative ml-16 flex w-full max-w-xs flex-1">
                <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                  <div class="absolute right-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="mobileLandingMenuOpen = false">
                      <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>
                  </div>
                </TransitionChild>
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                  <div class="flex h-16 shrink-0 items-center">
                    <router-link to="/" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                      <img class="block h-10 w-auto" src="../assets/images/logo-mini.png" alt="logo-icon">
                    </router-link>
                  </div>
                  <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                      <li>
                        <ul role="list" class="-mx-2 space-y-1">
                          <li v-for="item in navigationLanding" :key="item.name">
                            <router-link :to="`/#${item.href}`" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                              {{ item.name }}
                            </router-link>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <!--Main content-->
      <main class="py-5 bg-gray-50 main-content">
        <div class="px-4 sm:px-6 lg:px-8">
          <router-view class="flex-1" v-slot="{Component}">
            <transition name="fade" mode="out-in">
              <component :is="Component"/>
            </transition>
          </router-view>
        </div>
      </main>
    </div>
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
  ChevronDownIcon,
  BriefcaseIcon,
  DocumentTextIcon,
  BuildingOfficeIcon
} from '@heroicons/vue/24/outline'
import {mapActions, mapGetters, mapState} from "vuex";

export default {
	name: 'MainLayout',
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
			sidebarOpen: false,
      mobileLandingMenuOpen: false,
      navigation: [
        { name: 'Кабинет', href: '/cabinet', icon: HomeIcon, current: true },
      ],
      teams: [
        { id: 1, name: 'Профиль', href: '/cabinet/profile', initial: 'П', current: false },
        { id: 2, name: 'Анкета', href: '/cabinet/questionnaire', initial: 'А', current: false },
      ],
      navigationLanding: [
        { name: 'Главная', href: 'home', icon: HomeIcon, current: false },
        { name: 'Путь стажера', href: 'path', icon: FolderIcon, current: false },
        { name: 'Новости', href: 'blog', icon: FolderIcon, current: false },
      ],
		}
	},
  computed: {
    ...mapState('cabinet', ['info']),
    ...mapGetters('auth', ['isAuthenticated']),
  },
  methods: {
    ...mapActions('auth', ['signOut']),
    ...mapActions('cabinet', ['getInfo']),
    isSignOut () {
      this.signOut()
      this.$router.push('/login');
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler() {
        const route = this.$route.href
        this.navigation = this.navigation.map((item) => ({
          ...item,
          current: item.href === route
        }))
        this.teams = this.teams.map((item) => ({
          ...item,
          current: item.href === route
        }))
      },
    },
  },
  async mounted() {
    if(this.isAuthenticated) {
      await this.getInfo().then((res) => {
        // ROLE_CANDIDATE
        if((res?.role === 0)) {
          this.navigation = this.navigation.concat([
              { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, current: false },
          ])
          this.teams = this.teams.concat([
              { id: 3, name: 'Эссе', href: '/cabinet/essay', initial: 'Э', current: false }
          ])
        }
        if(res?.role === 1) {
          this.navigation = this.navigation.concat([
            { name: 'Стажировки', href: '/cabinet/internships', icon: UsersIcon, current: false },
            { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, current: false },
          ])
          this.teams = this.teams.concat([
            { id: 3, name: 'Эссе', href: '/cabinet/essay', initial: 'Э', current: false }
          ])
        }
        // ROLE_SUPERVISOR
        if(res?.role === 2) {
          this.navigation = this.navigation.concat([
            { name: 'Заявки на стажировку', href: '/cabinet/applications', icon: UsersIcon, current: false },
            { name: 'Стажировки', href: '/cabinet/internships-supervisor', icon: BuildingOfficeIcon, current: false },
            { name: 'Школа наставников', href: '/cabinet/school-of-mentors', icon: BriefcaseIcon, current: false },
            { name: 'Заявления стажеров', href: '/cabinet/statements', icon: DocumentDuplicateIcon, current: false },
            { name: 'Табель стажеров', href: '/cabinet/table', icon: DocumentTextIcon, current: false },
            { name: 'Статистика', href: '/cabinet/statistics', icon: ChartPieIcon, current: false },
            { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, current: false },
          ])
        }
        // ROLE_MENTOR
        if(res?.role === 3) {
          this.navigation = this.navigation.concat([
            { name: 'Заявки на стажировку', href: '/cabinet/applications-mentors', icon: UsersIcon, current: false },
            { name: 'Школа наставников', href: '/cabinet/school', icon: BriefcaseIcon, current: false },
            { name: 'Расписание стажера', href: '/cabinet/schedule', icon: DocumentDuplicateIcon, current: false },
            { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, current: false },
          ])
        }
        // ROLE_ORGANIZATION_MEMBER
        if(res?.role === 4) {
          this.navigation = this.navigation.concat([
            { name: 'Стажировки', href: '/cabinet/applications-organization', icon: UsersIcon, current: false },
            { name: 'Школа наставников', href: '/cabinet/school-organization', icon: BriefcaseIcon, current: false },
            { name: 'Рейтинг', href: '/cabinet/rating', icon: ChartPieIcon, current: false },
            { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, current: false },
          ])
        }
      })
    }
  }
};
</script>

<style lang="scss" scoped>
.main-content {
  min-height: calc(100vh - 64px);
}
</style>
