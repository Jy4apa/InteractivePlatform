<template>
  <div class="flex flex-col">
    <h1 class="text-2xl font-semibold pb-5">Заявки на стажировку</h1>
    <template v-if="!loading">
      <div class="flow-root">
        <div class="overflow-x-auto rounded">
          <div class="inline-block min-w-full align-middle">
            <div class="relative">
              <table class="min-w-full table-fixed divide-y divide-gray-300">
                <thead class="bg-gray-100">
                <tr>
                  <th scope="col" class="px-3 py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Имя</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Телефон</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Город</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 flex items-center">
                    Баллы
                    <ChevronDownIcon class="ml-1.5 cursor-pointer flex-none rounded bg-gray-100 text-gray-900 group-hover:text-black h-3 w-3" aria-hidden="true" />
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3"/>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="person in list" :key="person.id">
                  <td :class="['whitespace-nowrap py-4 px-3 text-sm font-medium', 'text-gray-900']">
                    {{ person.user.name }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <a :href="`tel:${person.user.info.phone}`">{{ person.user.info.phone }}</a>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ person.user.info.city }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ person.user.info.scores }}
                  </td>
                  <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3 flex justify-end">
                    <IdentificationIcon @click="openInfo" class="cursor-pointer mr-3 flex-none rounded text-grey-600 hover:text-grey-700 h-5 w-5" aria-hidden="true" />
                    <CheckIcon class="cursor-pointer flex-none rounded text-green-600 hover:text-green-700 h-5 w-5" aria-hidden="true" />
                    <XMarkIcon class="ml-2 cursor-pointer flex-none rounded text-red-600 hover:text-red-700 h-5 w-5" aria-hidden="true" />
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
    <loading v-else/>
  </div>
</template>

<script>

import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid";
import {ChevronDownIcon, PlusIcon, IdentificationIcon, CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import Loading from "@/components/Loading.vue";
import {mapActions} from "vuex";

export default {
  name: "ApplicationsMentors",
  components: {
    Loading,
    ChevronDownIcon, PlusIcon, XMarkIcon,
    ExclamationTriangleIcon, IdentificationIcon, CheckIcon
  },
  data() {
    return {
      loading: false,
      list: [],
    }
  },
  computed: {
  },
  methods: {
    ...mapActions('cabinet', ['getListReplies']),
    openInfo() {
      console.log('упс')
    }
  },
  async mounted() {
    this.loading = true
    await this.getListReplies().then((res) => {
      this.list = res || []
    })
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>