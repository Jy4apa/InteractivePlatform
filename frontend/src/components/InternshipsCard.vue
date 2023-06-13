<template>
  <div v-if="value">
    <div class="px-4 py-6 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-6">
      <div class="sm:flex lg:col-span-7">
        <router-link :to="`/cabinet/internships/${value.id}`" class="aspect-h-1 aspect-w-1 w-full flex-shrink-0 overflow-hidden rounded-lg sm:aspect-none sm:h-40 sm:w-40">
          <img src="../assets/images/logo.png" alt="logo" class="h-full w-full object-contain object-center sm:h-full sm:w-full" />
        </router-link>
        <div class="mt-6 sm:ml-6 sm:mt-0">
          <h3 class="text-base font-medium text-gray-900">
            <router-link :to="`/cabinet/internships/${value.id}`">{{ value.title }}</router-link>
          </h3>
          <div class="flex mt-2">
            <div class="mr-2 flex items-center">
              <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[4 > rating ? 'text-indigo-500' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
            </div>
            <p class="text-sm font-medium text-gray-900">Компания</p>
          </div>
          <p class="mt-2 text-sm text font-medium text-gray-900">От {{ value.income }} руб</p>
          <p class="mt-1 text-sm font-medium text-gray-900">{{ direction }}</p>
          <p class="mt-2 text-sm text-gray-500">{{ value.description }}</p>
        </div>
      </div>

      <div class="mt-6 lg:col-span-5 lg:mt-0">
        <dl class="grid grid-cols-2 gap-x-6 text-sm">
          <div>
            <dt class="font-medium text-gray-900">Адрес стажировки</dt>
            <dd class="mt-3 text-gray-500">
              <span class="block">{{ value.address }}</span>
            </dd>
          </div>
          <div>
            <dt class="font-medium text-gray-900">Наставник</dt>
            <dd class="mt-3 flex items-center flex-col w-fit xl:flex-row text-gray-500">
              <img
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="author"
                  class="h-12 w-12 rounded-full"
              />

              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 mt-2 xl:mt-0">{{mentor}}</p>
                <div class="mt-2 flex items-center">
                  <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[4 > rating ? 'text-indigo-500' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                </div>
              </div>
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div v-if="!isOrganization && !isSupervisor" class="border-t border-gray-200 px-4 py-6 sm:px-6">
      <template v-if="value.reply !== 0">
        <base-button
            type="primary"
            class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
            @click="clickActive()"
        >
          Откликнуться
        </base-button>
      </template>
      <template v-else>
        <p class="text-sm font-medium text-gray-900">
          <base-button
              type="primary"
              class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
          >
            Отправить задание
          </base-button>
        </p>
        <div class="mt-6" aria-hidden="true">
          <div class="overflow-hidden rounded-full bg-gray-200">
            <div class="h-2 rounded-full bg-indigo-600" :style="{ width: `calc((${1} * 2 + 1) / 8 * 100%)` }" />
          </div>
          <div class="mt-6 hidden grid-cols-4 text-sm font-medium text-gray-600 sm:grid">
            <div class="text-indigo-600">Заявка отправлена</div>
            <div :class="[1 > 0 ? 'text-indigo-600' : '', 'text-center']">Решение задания</div>
            <div :class="[1 > 1 ? 'text-indigo-600' : '', 'text-center']">Одобрение наставника</div>
            <div :class="[1 > 2 ? 'text-indigo-600' : '', 'text-right']">Потверждение кадрового специалиста</div>
          </div>
        </div>
      </template>
    </div>
    <div v-if="isSupervisor" class="border-t border-gray-200 px-4 py-6 sm:px-6 flex justify-between">
      <div>
        <template v-if="value.status === 0">
        <span @click="appVacancy" class="cursor-pointer w-fit inline-flex items-center gap-x-1.5 rounded-md bg-green-100 px-2 py-1 font-medium text-green-700 hover:text-green-900">
            Опубликовать
        </span>
          <span @click="cancelVacancy" class="ml-3 cursor-pointer w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700 hover:text-red-900">
            Отклонить
         </span>
        </template>
        <template v-else>
        <span v-if="value.status === 2" class="w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 text-sm px-2 py-1 font-medium text-red-700">
            <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            Отклонена
         </span>
          <span v-if="value.status === 1" class="w-fit inline-flex items-center gap-x-1.5 rounded-md bg-green-100 text-sm px-2 py-1 font-medium text-green-700">
            <svg class="h-2 w-2 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            Опубликована
         </span>
        </template>
      </div>
      <div class="flex">
        <div @click="edit(value.id)" class="text-sm text-green-500 hover:text-green-600 cursor-pointer flex items-center mr-3">
          <PencilIcon class="h-4 w-4 flex-shrink-0 mr-2" aria-hidden="true" />
          <span class="hidden sm:flex">Редактировать</span>
        </div>
        <div class="text-sm ml-3 text-red-500 hover:text-red-600 cursor-pointer flex items-center">
          <TrashIcon class="h-4 w-4 flex-shrink-0 mr-2" aria-hidden="true" />
          <span class="hidden sm:flex">Удалить</span>
        </div>
      </div>
    </div>
    <div v-if="isOrganization" class="border-t border-gray-200 px-4 py-6 sm:px-6">
      <div class="flex justify-between">
         <span v-if="value.status === 2" class="w-fit inline-flex items-center gap-x-1.5 rounded-md text-sm bg-red-100 px-2 py-1 font-medium text-red-700">
            <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            Отклонена
         </span>
        <span v-if="value.status === 1" class="w-fit inline-flex items-center gap-x-1.5 rounded-md text-sm bg-green-100 px-2 py-1 font-medium text-green-700">
            <svg class="h-2 w-2 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            Опубликована
         </span>
        <span v-if="value.status === 0" class="w-fit inline-flex items-center gap-x-1.5 rounded-md bg-blue-100 text-sm px-2 py-1 font-medium text-blue-700">
            <svg class="h-2 w-2 fill-blue-500" viewBox="0 0 6 6" aria-hidden="true">
              <circle cx="3" cy="3" r="3" />
            </svg>
            На модерации
         </span>
        <div class="flex">
          <div @click="edit(value.id)" class="text-sm text-green-500 hover:text-green-600 cursor-pointer flex items-center mr-3">
            <PencilIcon class="h-4 w-4 flex-shrink-0 mr-2" aria-hidden="true" />
            <span class="hidden sm:flex">Редактировать</span>
          </div>
          <div class="text-sm ml-3 text-red-500 hover:text-red-600 cursor-pointer flex items-center">
            <TrashIcon class="h-4 w-4 flex-shrink-0 mr-2" aria-hidden="true" />
            <span class="hidden sm:flex">Удалить</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {StarIcon, PencilIcon, TrashIcon} from "@heroicons/vue/20/solid";
import BaseButton from "@/components/UI/BaseButton.vue";
import {mapActions} from "vuex";

export default {
  name: "InternshipsCard",
  props: {
    value: {
      type: Object,
      default: null,
    },
    isOrganization: {
      type:    Boolean,
      default: false,
    },
    isSupervisor: {
      type:    Boolean,
      default: false,
    },
  },
  data() {
    return {
      isActive: false
    }
  },
  components: {
    BaseButton,
    StarIcon, PencilIcon, TrashIcon
  },
  computed: {
    direction() {
      if(this.value && this.value?.direction?.list && this.value?.direction.direction_id) {
        return this.value?.direction?.list[+this.value?.direction?.direction_id || '1']
      }
      return ''
    },
    mentor() {
      if(this.value && this.value?.mentor_id?.list && this.value?.mentor_id?.value) {
        return this.value?.mentor_id?.list.find((item) => item.id === (+this.value?.mentor_id?.value || '1')).user
      }
      return 'Не определен'
    }
  },
  methods: {
    ...mapActions('cabinet', ['setAddVacancy', 'setCancelVacancy', 'setReply']),
    edit(id) {
      this.$router.push(`/cabinet/applications-organization/${id}`)
    },
    clickActive() {
      this.setReply(this.value.id).then((e) => {
        if(e) {
          this.$emit('updateVacancy');
        }
      })
    },
    async appVacancy() {
      await this.setAddVacancy(this.value.id).then((res) => {
        this.$router.push(`/cabinet/internships-supervisor`)
        this.$emit('updateVacancy');
      })
    },
    async cancelVacancy() {
      await this.setCancelVacancy(this.value.id).then((res) => {
        this.$router.push(`/cabinet/internships-supervisor`)
        this.$emit('updateVacancy');
      })
    }
  },
}
</script>

<style lang="scss" scoped>
</style>