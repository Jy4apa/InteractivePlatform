<template>
  <div class="flex flex-col">
    <template v-if="!loading">
      <nav aria-label="Breadcrumb">
        <ol role="list" class="mx-auto flex items-center space-x-2">
          <li>
            <div class="flex items-center">
              <router-link v-if="info?.role === 4" to="/cabinet/applications-organization" class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                Стажировки
              </router-link>
              <router-link v-else to="/cabinet/internships-supervisor" class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                Стажировки
              </router-link>
              <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
              </svg>
            </div>
          </li>
          <li class="text-sm">
            <span v-if="pageId && pageId === 'create'" class="font-medium text-gray-900">Создание стажировки</span>
            <span v-else class="font-medium text-gray-900">Редактирование стажировки</span>
          </li>
        </ol>
      </nav>
      <h1 v-if="pageId && pageId === 'create'"
          class="text-2xl font-semibold pb-5 pt-6">
        Создание стажировки
      </h1>
      <h1 v-else
          class="text-2xl font-semibold pb-5 pt-6">
        Редактирование стажировки
      </h1>
      <div class="grid gap-x-8 gap-y-10 pt-2 pb-10">
        <div class="grid grid-cols-1 gap-x-6 gap-y-3 sm:max-w-xl sm:grid-cols-6">
          <div class="col-span-full flex items-center gap-x-8">
            <img
                class="h-24 w-24 flex justify-center items-center rounded-lg object-contain"
                src="../../assets/images/logo.png"
                alt="Image"
            />
            <div>
              <base-button
                  type="primary"
                  class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm bg-gray-400"
              >
                Изменить логтип
              </base-button>
              <p class="mt-2 text-xs leading-5 text-gray-500">JPG, GIF or PNG. 1MB max.</p>
            </div>
          </div>
          <base-input
              class="col-span-full"
              star
              v-model="internship.title"
              label="Название"
          />
          <base-select
              v-if="info?.role === 4"
              class="col-span-full"
              star
              label="label"
              select-label="Наставник"
              v-model="internship.mentor"
              :options="mentorOptions"
          />
          <base-textarea
              class="col-span-full"
              star
              v-model="internship.description"
              label="Описание"
          />
          <base-input
              class="col-span-full"
              star
              type="number"
              v-model="internship.price"
              label="Зарплата, от (руб.)"
          />
          <base-select
              class="col-span-full"
              star
              label="label"
              select-label="Направление"
              v-model="internship.directories"
              :options="directoriesOptions"
          />
          <base-select
              class="col-span-full"
              star
              label="label"
              select-label="График работы"
              v-model="internship.schedule"
              :options="scheduleOptions"
          />
          <BaseSelect
              class="col-span-full"
              v-model="internship.address"
              :options="optionsAddress"
              label="label"
              select-label="Адрес"
              :internal-search="false"
              :clearOnSelect="false"
              :preserveSearch="true"
              :clearable="true"
              @searchChange="onSearchChange"
          />
          <div class="mt-8 flex col-span-full">
            <base-button
                @click="save"
                class="w-full inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-md">
              Сохранить
            </base-button>
          </div>
        </div>
      </div>
    </template>
    <loading v-else/>
  </div>
</template>

<script>
import {ExclamationTriangleIcon, PencilIcon, TrashIcon} from "@heroicons/vue/20/solid";
import InternshipsCard from "@/components/InternshipsCard.vue";
import Loading from "@/components/Loading.vue";
import BaseButton from "@/components/UI/BaseButton.vue";
import BaseInput from "@/components/UI/BaseInput.vue";
import BaseTextarea from "@/components/UI/BaseTextarea.vue";
import {mapActions, mapState} from "vuex";
import BaseSelect from "@/components/UI/BaseSelect.vue";
import {debounce} from "lodash";
import axios from "axios";

export default {
  name: "ApplicationsOrganizationForm",
  components: {
    BaseSelect,
    BaseTextarea,
    BaseInput,
    BaseButton,
    Loading,
    InternshipsCard,
    ExclamationTriangleIcon,
    PencilIcon,
    TrashIcon
  },
  data() {
    return {
      loading: false,
      directoriesOptions: [],
      optionsAddress: [],
      mentorOptions: [],
      scheduleOptions: [
        {
          label: '20 часов в неделю',
          value: '20 часов в неделю',
        },
        {
          label: '40 часов в неделю',
          value: '40 часов в неделю',
        },
      ],
      internship: {
        title: '',
        description: '',
        price: '',
        directories: null,
        schedule: null,
        address: '',
        mentor: null,
      },
    }
  },
  computed: {
    ...mapState('cabinet', ['info']),
    pageId() {
      return this.$route?.params?.id
    },
  },
  methods: {
    ...mapActions('cabinet', ['getDirections', 'setCreateVacancy', 'getCabinetVacancy', 'setUpdateVacancy', 'setEditVacancy', 'getListMentors']),
    onSearchChange: debounce(function callback(event) {
      if (event.length >= 1) {
        this.loadAddressSuggest(event);
      }
    }, 300),
    async loadAddressSuggest(e) {
      const apiUrl = import.meta.env.VITE_APP_FIAS_URL
      const token = import.meta.env.VITE_APP_FIAS_TOKEN
      try {
        const res = await axios
            .post(
                apiUrl,
                {
                  query: e,
                  count: 10,
                },
                {
                  headers: {
                    Authorization: `Token ${token}`,
                  },
                }
            );
        if(res.data?.suggestions?.length) {
          this.optionsAddress = res.data.suggestions.map((item) => ({
            label: item.value,
            geo_lat: item.data?.geo_lat || 0,
            geo_lon: item.data?.geo_lon || 0
          }))
        }
      } catch(err) {
        console.error(err)
      }
    },
    async save() {
      //редактирование
      if(this.pageId && this.pageId !== 'create') {
        const payload = {
          id: this.pageId,
          date: {
            title: this.internship.title,
            description: this.internship.description,
            income: this.internship.price,
            direction_id: this.internship.directories.value,
            schedule: this.internship.schedule.value,
            address: this.internship.address.label,
            geo_lat: +this.internship.address.geo_lat,
            geo_lon: +this.internship.address.geo_lon,
            mentor_id: this.internship?.mentor?.value || null
          }
        }
        if(this.info.role === 2) {
          await this.setEditVacancy(payload).then((res) => {
            if(res?.success) {
              this.$router.push('/cabinet/internships-supervisor/')
            }
          })
        } else {
          await this.setUpdateVacancy(payload).then((res) => {
            if(res?.success) {
              this.$router.push('/cabinet/applications-organization/')
            }
          })
        }
      } else {
        const payload = {
          title: this.internship.title,
          description: this.internship.description,
          income: this.internship.price,
          direction_id: this.internship.directories.value,
          schedule: this.internship.schedule.value,
          address: this.internship.address.label,
          geo_lat: +this.internship.address.geo_lat,
          geo_lon: +this.internship.address.geo_lon,
          mentor_id: this.internship?.mentor?.value || null
        }
        await this.setCreateVacancy(payload).then((res) => {
          if(res?.success) {
            this.$router.push('/cabinet/applications-organization/')
          }
        })
      }
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
    if(this.info?.role === 4) {
      await this.getListMentors().then((res) => {
        this.mentorOptions = res?.map((item) => ({
          label: item?.user || '',
          value: item?.id || ''
        })) || []
      })
    }
    if(this.pageId && this.pageId !== 'create') {
      this.getCabinetVacancy(this.pageId).then((res) => {
        this.internship = {
          title: res?.title || '',
          description: res?.description || '',
          price: res?.income || '',
          directories: this.directoriesOptions.find(item => item.value === res?.direction?.direction_id),
          schedule: this.scheduleOptions.find(item => item.value === res?.schedule),
          address: {
            label: res?.address || '',
            geo_lat: res?.geo_lat || 0,
            geo_lon: res?.geo_lon || 0,
          },
          mentor: this.mentorOptions?.find(item => item.value === res?.mentor_id?.value) || null,
        }
      })
    }
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>