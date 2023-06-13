<template>
  <div class="flex flex-col">
    <h1 class="text-2xl font-semibold pb-5">Заявки на стажировку</h1>
    <template v-if="!loading">
      <div class="flex flex-col mb-6">
        <div class="flex">
          <base-input
              label="Поиск"
              v-model="search"
          />
          <base-select
              class="ml-3 max-w-xs w-full"
              select-label="Релевантность"
              v-model="recommended"
              :options="recommendedOptions"
              label="label"
          />
        </div>
        <div
            v-if="clear"
            @click="clearFilters"
            class="flex items-center h-5 text-gray-600 hover:text-gray-800 cursor-pointer text-sm mt-2"
        >
          <x-mark-icon class="w-4 h-4 mr-1.5" />
          Сбросить фильтры
        </div>
        <div v-else class="mt-2 h-5"/>
      </div>
      <div class="flow-root">
        <div class="overflow-x-auto rounded">
          <div class="inline-block min-w-full align-middle">
            <div class="relative">
              <div v-if="selected.length > 0" class="absolute left-14 top-0 flex h-12 items-center space-x-2 sm:left-12">
                <button
                    type="button"
                    class="inline-flex items-center rounded bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">
                  Добавить баллы
                </button>
              </div>
              <table class="min-w-full table-fixed divide-y divide-gray-300">
                <thead class="bg-gray-100">
                <tr>
                  <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                    <input type="checkbox" class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" :checked="indeterminate || selected.length === list.length" :indeterminate="indeterminate" @change="selected = $event.target.checked ? list.map((p) => p.email) : []" />
                  </th>
                  <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Имя</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">E-Mail</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Релевантность</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 flex items-center">
                    Баллы
                    <ChevronDownIcon class="ml-1.5 cursor-pointer flex-none rounded bg-gray-100 text-gray-900 group-hover:text-black h-3 w-3" aria-hidden="true" />
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3"/>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="person in list" :key="person.email" :class="[selected.includes(person.email) && 'bg-gray-50']">
                  <td class="relative px-7 sm:w-12 sm:px-6">
                    <div v-if="selected.includes(person.email)" class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                    <input
                        type="checkbox"
                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                        :value="person.email"
                        v-model="selected"
                    />
                  </td>
                  <td :class="['whitespace-nowrap py-4 pr-3 text-sm font-medium', selected.includes(person.email) ? 'text-indigo-600' : 'text-gray-900']">
                    {{ person.firstname }} {{ person.lastname }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ person.email }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ person.is_recommended === 0 ? 'Не релевантный' : 'Релевантный' }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ person.scores }}
                  </td>
                  <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3 flex justify-end">
                    <PlusIcon class="cursor-pointer flex-none rounded text-green-600 hover:text-green-700 h-5 w-5" aria-hidden="true" />
                    <!--                  <XMarkIcon class="ml-2 cursor-pointer flex-none rounded text-red-600 hover:text-red-700 h-5 w-5" aria-hidden="true" />-->
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
import {
    ChevronDownIcon,
    CheckIcon,
    XMarkIcon,
    PlusIcon
} from '@heroicons/vue/24/outline'
import BaseSelect from "@/components/UI/BaseSelect.vue";
import BaseInput from "@/components/UI/BaseInput.vue";
import {mapActions} from "vuex";
import Loading from "@/components/Loading.vue";

export default {
  name: "Applications",
  components: {
    Loading,
    BaseInput,
    BaseSelect,
    ChevronDownIcon,
    CheckIcon,
    XMarkIcon,
    PlusIcon
  },
  data() {
    return {
      loading: false,
      checked: false,
      list: [],
      selected: [],
      recommendedOptions: [
        {
          label: 'Релевантный',
          value: true
        },
        {
          label: 'Не релевантный',
          value: false
        },
      ],
      recommended: null,
      search: ''
    }
  },
  computed: {
    indeterminate() {
      return this.selected.length > 0 && this.selected.length < this.list.length
    },
    clear() {
      return this.search.length || this.recommended
    }
  },
  methods: {
    ...mapActions('cabinet', ['getListCandidate']),
    clearFilters() {
      this.search = ''
      this.recommended = null
    }
  },
  async mounted() {
    this.loading = true
    await this.getListCandidate().then((res) => {
      this.list = res || []
    })
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>