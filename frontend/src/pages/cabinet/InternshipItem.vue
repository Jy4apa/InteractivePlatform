<template>
  <div class="pt-2">
    <nav aria-label="Breadcrumb">
      <ol role="list" class="mx-auto flex items-center space-x-2">
        <li>
          <div class="flex items-center">
            <router-link v-if="info?.role === 4" to="/cabinet/applications-organization" class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900">
              Стажировки
            </router-link>
            <router-link v-else-if="info?.role === 2" to="/cabinet/internships-supervisor" class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900">
              Стажировки
            </router-link>
            <router-link v-else to="/cabinet/internships" class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900">
              Стажировки
            </router-link>
            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
              <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
            </svg>
          </div>
        </li>
        <li class="text-sm">
          <span class="font-medium text-gray-900">{{ internship.title }}</span>
        </li>
      </ol>
    </nav>

    <div class="mx-auto pt-6 pb-6 lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8">
      <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ internship.title }}</h1>
      </div>


      <div class="py-6 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pr-8 lg:pt-6">
        <!-- Description and details -->
        <div>
          <div class="space-y-6">
            <p class="text-base text-gray-900">{{ internship.description }}</p>
          </div>
        </div>

        <div class="mt-6">
          <h3 class="font-medium text-gray-900">Зарплата</h3>

          <div class="mt-4">
            <span class="text-sm text-gray-600">От {{ internship.income }} руб</span>
          </div>
        </div>

        <div class="mt-6">
          <h3 class="font-medium text-gray-900">Направление</h3>

          <div class="mt-4">
            <span class="text-sm text-gray-600">{{ direction }}</span>
          </div>
        </div>

        <section aria-labelledby="shipping-heading" class="mt-6">
          <h2 id="shipping-heading" class="font-medium text-gray-900">График работы</h2>

          <div class="mt-4 space-y-6">
            <p class="text-sm text-gray-600">{{internship.schedule}}</p>
          </div>
        </section>
      </div>
      <!-- Options -->
      <div class="mt-4 lg:row-span-3 lg:mt-0 mb-6">
        <yandex-map
            :coords="mapCenter"
            :zoom="map.zoom"
            class="address-map"
            :controls="['zoomControl']"
            :behaviors="[]"
        >
          <ymap-marker
              marker-id="contacts"
              :coords="mapCenter"
          />
        </yandex-map>
        <p class="tracking-tight text-gray-900 mt-1">{{internship.address}}</p>
        <p class="text-xl tracking-tight text-gray-900 mt-4">{{internship.organization}}</p>
        <!-- Reviews -->
        <div class="mt-1">
          <div class="flex items-center">
            <div class="flex items-center">
              <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[4 > rating ? 'text-indigo-500' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
            </div>
            <span class="ml-3 text-sm font-medium text-gray-600">2 оценили</span>
          </div>
        </div>

        <div class="mt-6">
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
      </div>
      <!-- Reviews -->
      <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
        <section aria-labelledby="reviews-heading" class="border-t border-gray-200 pt-6">
          <h2 class="text-xl font-medium text-gray-900 mb-10">Отзывы стажеров</h2>
          <div class="space-y-10">
            <div v-for="review in reviews.featured" :key="review.id" class="flex flex-col">
              <div class="order-2 mt-6">
                <h3 class="text-sm font-medium text-gray-900">{{ review.title }}</h3>

                <div class="mt-3 space-y-6 text-sm text-gray-600">
                  {{ review.content }}
                </div>
              </div>

              <div class="order-1 flex items-center">
                <img :src="review.avatarSrc" :alt="`${review.author}.`" class="h-12 w-12 rounded-full" />

                <div class="ml-4">
                  <p class="text-sm font-medium text-gray-900">{{ review.author }}</p>
                  <div class="mt-2 flex items-center">
                    <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[review.rating > rating ? 'text-indigo-500' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
} from '@headlessui/vue'
import { StarIcon } from '@heroicons/vue/20/solid'
import {mapActions, mapState} from "vuex";
import {debounce} from "lodash";
import axios from "axios";

export default {
  name: "InternshipsItem",
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    StarIcon
  },
  data() {
    return {
      internship: {},
      reviews: {
        average: 4,
        totalCount: 117,
        featured: [
          {
            id: 1,
            title: 'Было очень интересно',
            rating: 5,
            content: 'Много чего узнал, но бывало и скучно',
            author: 'Максим Угрюмов',
            avatarSrc:
                'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixqx=oilqXxSqey&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          },
          {
            id: 2,
            title: 'Это лучшая стажировка в моей жизни',
            rating: 4,
            content: 'Очень крутые специалисты, мне очень понравилось',
            author: 'Алексей Кирпов',
            avatarSrc:
                'https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80',
          },
          {
            id: 3,
            title: 'Всем советую',
            rating: 5,
            content: 'Замечательная компания, был стажером, теперь занимаю хорошую должность в этой компании',
            author: 'Антон Резюмов',
            avatarSrc:
                'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
          },
        ],
      },
      map: {
        zoom: 15,
      }
    }
  },
  computed: {
    ...mapState('cabinet', ['info']),
    pageId() {
      return this.$route?.params?.id
    },
    mapCenter() {
      if (this.internship) {
        const { geo_lat, geo_lon } = this.internship
        return geo_lat && geo_lon ? [geo_lon, geo_lat] : [37.61556, 55.75222]
      }
      return [37.61556, 55.75222]
    },
    direction() {
      if(this.internship && this.internship?.direction?.list && this.internship?.direction.direction_id) {
        return this.internship?.direction?.list[+this.internship?.direction?.direction_id || '1']
      }
      return ''
    },
    mentor() {
      if(this.internship && this.internship?.mentor_id?.list && this.internship?.mentor_id?.value) {
        return this.internship?.mentor_id?.list.find((item) => item.id === (+this.internship?.mentor_id?.value || '1')).user
      }
      return 'Не определен'
    }
  },
  methods: {
    ...mapActions('cabinet', ['getCabinetVacancy']),
  },
  async mounted() {
    this.loading = true
    if(this.pageId && this.pageId !== 'create') {
      this.getCabinetVacancy(this.pageId).then((res) => {
        this.internship = res
      })
    }
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
.address-map {
  border-radius: 4px;
  overflow: hidden;
  height: 300px;
  width: 100%;
  ::v-deep.leaflet-top,
  .leaflet-left {
    z-index: 998;
  }
}
</style>