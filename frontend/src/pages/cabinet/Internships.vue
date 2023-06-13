<template>
  <div class="flex flex-col">
    <h1 class="text-2xl font-semibold pb-5">Стажировки</h1>
    <template v-if="!loading">
      <div class="flex flex-col mb-6">
        <div class="flex justify-between">
          <div class="flex w-full">
            <base-input
                label="Поиск"
                v-model="search"
                @input="updateSearch"
            />
            <base-select
                class="ml-3 max-w-xs w-full"
                select-label="Направление"
                v-model="direction"
                :options="directoriesOptions"
                label="label"
                @onChange="updateVacancy"
            />
          </div>
        </div>
        <div
            v-if="clear"
            @click="clearFilters"
            class="flex items-center text-gray-600 hover:text-gray-800 h-5 cursor-pointer text-sm mt-2"
        >
          <x-mark-icon class="w-4 h-4 mr-1.5" />
          Сбросить фильтры
        </div>
        <div v-else class="mt-2 h-5"/>
        <div class="flex text-sm w-fit mt-3 items-center text-indigo-600 hover:text-indigo-900 cursor-pointer" @click="onMap">
          <MapIcon class="h-5 w-5 mr-2"/>
          Посмотреть на карте
        </div>
      </div>
      <YandexMapPage
          v-if="isMap"
          :coordsMarket="internships"
          class="mb-5"
          @closeMap="closeMap"
      />
      <div class="mb-6 space-y-3">
        <internships-card
            class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border"
            v-for="product in internships" :key="product.id"
            :value="product"
            @updateVacancy="updateVacancy"
        />
        <div v-if="!internships.length" class="text-gray-600 text-center mt-6">
          По заданным фильтрам подходящих стажировок нет
        </div>
      </div>
    </template>
    <loading v-else/>
  </div>
</template>

<script>

import InternshipsCard from "@/components/InternshipsCard.vue";
import BaseInput from "@/components/UI/BaseInput.vue";
import BaseSelect from "@/components/UI/BaseSelect.vue";
import {XMarkIcon, MapIcon} from "@heroicons/vue/24/outline";
import {mapActions} from "vuex";
import Loading from "@/components/Loading.vue";
import YandexMapPage from "@/components/Map/YandexMap.vue";
import {debounce} from 'lodash'

export default {
  name: "Internships",
  components: {
    YandexMapPage,
    Loading,
    XMarkIcon, BaseSelect, BaseInput,
    InternshipsCard,
    MapIcon
  },
  data() {
    return {
      loading: false,
      search: '',
      direction: null,
      directoriesOptions: [],
      internships: [],
      isMap: false,
    }
  },
  computed: {
    clear() {
      return this.search.length || this.direction
    }
  },
  methods: {
    ...mapActions('cabinet', ['getDirections', 'getListVacancy']),
    clearFilters() {
      this.search = ''
      this.direction = null
      this.updateVacancy()
    },
    onMap() {
      this.isMap = !this.isMap
    },
    closeMap() {
      this.isMap = false
    },
    updateSearch: debounce(function callback(event) {
      this.updateVacancy()
    }, 500),
    async updateVacancy() {
      const payload = {
        page: 1,
        count: 1000,
        direction_id: this.direction?.value || undefined,
        title: this.search || undefined
      }
      await this.getListVacancy(payload).then((res) => {
        this.internships = res || []
      })
    }
  },
  async mounted() {
    this.loading = true
    await this.getDirections().then((res) => {
      this.directoriesOptions = res?.map((item) => ({
        label: item?.title || '',
        value: item?.id || ''
      })) || []
    })
    const payload = {
      page: 1,
      count: 1000,
      direction_id: this.direction?.value || undefined,
      title: this.search || undefined
    }
    await this.getListVacancy(payload).then((res) => {
      this.internships = res || []
    })
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>