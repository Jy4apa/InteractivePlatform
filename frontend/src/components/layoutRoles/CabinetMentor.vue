<template>
  <div>
    <template v-if="!loading">
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
      <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
        <dl class="grid max-w-7xl grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 lg:px-2 xl:px-0">
          <div :class="['flex flex-col items-start flex-wrap gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-4 sm:px-6 lg:border-t-0 xl:px-8']">
            <dt class="text-sm font-medium leading-6 text-gray-500">Название организации:</dt>
            <dd :class="['text-grey-600', 'text-sm font-medium']">{{ organization.title }}</dd>
          </div>
          <div :class="['sm:border-l flex flex-col items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-4 sm:px-6 lg:border-t-0 xl:px-8']">
            <dt class="text-sm font-medium leading-6 text-gray-500">Описание организации:</dt>
            <dd :class="['text-grey-600', 'text-sm font-medium']">{{ organization.description }}</dd>
          </div>
          <div :class="['sm:border-l flex flex-col items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-4 sm:px-6 lg:border-t-0 xl:px-8']">
            <dt class="text-sm font-medium leading-6 text-gray-500">Адресс организации:</dt>
            <dd :class="['text-grey-600', 'text-sm font-medium']">{{ organization.address }}</dd>
          </div>
        </dl>
      </div>
      <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="item in stats" :key="item.name" class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
            <p v-if="item.change" :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
              <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
              <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
              <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
              {{ item.change }}
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <router-link :to="item.href" class="font-medium text-indigo-600 hover:text-indigo-500">
                  Перейти
                </router-link>
              </div>
            </div>
          </dd>
        </div>
      </dl>
    </template>
    <loading v-else/>
  </div>
</template>

<script>
import Loading from "@/components/Loading.vue";
import {ArrowDownIcon, ArrowUpIcon, ExclamationTriangleIcon} from "@heroicons/vue/20/solid";
import {
  BellIcon,
  BriefcaseIcon,
  BuildingOfficeIcon,
  ChartPieIcon,
  DocumentDuplicateIcon, DocumentTextIcon,
  UsersIcon
} from "@heroicons/vue/24/outline";
import {mapActions} from "vuex";

export default {
  name: "CabinetMentor",
  components: {
    ArrowUpIcon, ArrowDownIcon,
    ExclamationTriangleIcon,
    Loading,
  },
  data() {
    return {
      loading: false,
      stats: [
        { name: 'Заявки на стажировку', href: '/cabinet/applications', icon: UsersIcon, stat: '4 всего', change: '2', changeType: 'increase' },
        { name: 'Школа наставников', href: '/cabinet/school-of-mentors', icon: BriefcaseIcon, stat: 'Пройдено', change: '', changeType: '' },
        { name: 'Расписание стажера', href: '/cabinet/schedule', icon: DocumentDuplicateIcon, stat: '4 всего', change: '1', changeType: 'increase' },
        { name: 'Уведомления и сообщения', href: '/cabinet/notifications', icon: BellIcon, stat: '1 всего', change: '1', changeType: 'increase' },
      ],
      organization: {
        address: "",
        description: '',
        id: 1,
        location: "",
        logo: "",
        title: ""
      }
    }
  },
  methods: {
    ...mapActions('cabinet', ['getMentor']),
  },
  async mounted() {
    this.loading = true
    await this.getMentor().then((res) => {
      this.organization = res.organization
    })
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>