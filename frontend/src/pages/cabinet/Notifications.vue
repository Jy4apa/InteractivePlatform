<template>
  <div class="flex flex-col">
    <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 mb-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
        </div>
        <div class="ml-3">
          <p class="text-sm text-yellow-700">
            Этот модуль находится в разработке
          </p>
        </div>
      </div>
    </div>
    <h1 class="text-2xl font-semibold pb-5">Уведомления и сообщения</h1>
    <div class="bg-white rounded-2xl px-4 py-5 sm:px-6">
      <div class="flex space-x-3">
        <div class="flex-shrink-0">
          <img class="h-10 w-10 rounded-full" src="https://idev-present.com/_next/static/media/IgorZhuravlev.2330d257.jpg" alt="avatar" />
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-sm font-semibold flex items-center text-gray-900">
            <svg class="h-2 w-2 mr-1 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            <span>Игорь Журавлев</span>
          </p>
          <p class="text-sm text-gray-500">
            <span>27 мая 2023, 17:58</span>
          </p>
        </div>
        <div class="flex flex-shrink-0 self-center">
          <Menu as="div" class="relative inline-block text-left">
            <div>
              <MenuButton class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600">
                <span class="sr-only">Open options</span>
                <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
              </MenuButton>
            </div>

            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
              <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                      <StarIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                      <span>Добавить в избранное</span>
                    </a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                      <CodeBracketIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                      <span>Ответить</span>
                    </a>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
      <div class="text-gray-600 mt-3">
        Добро пожаловать в нашу систему!
        <br/>
        С уважением, команда Dev+
      </div>
    </div>
  </div>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
  CodeBracketIcon,
  EllipsisVerticalIcon,
  ExclamationTriangleIcon,
  FlagIcon,
  StarIcon
} from '@heroicons/vue/20/solid'

export default {
  name: "Notifications",
  components: {
    ExclamationTriangleIcon,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    CodeBracketIcon,
    EllipsisVerticalIcon,
    FlagIcon,
    StarIcon
  },
  data() {
    return {
    }
  },
  computed: {
  },
  methods: {
  },
  mounted() {
  }
}
</script>

<style lang="scss" scoped>
</style>