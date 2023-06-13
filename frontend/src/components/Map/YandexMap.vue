<template>
  <div class="yandex-map-wrapper">
    <XMarkIcon @click="closeMap" class="yandex-map-wrapper__close"/>
    <yandex-map
        class="yandex-map"
        :coords="arrCoords.length ? arrCoords[0].coords : mapConfig.coords"
        :zoom="arrCoords.length ? 11 : mapConfig.zoom"
        :controls="[]"
        :settings="settings"
        @click="onClick"
    >
      <template v-if="arrCoords?.length">
        <ymap-marker
            v-for="marker in arrCoords"
            :key="marker.id"
            marker-type="placemark"
            :coords="marker.coords"
            :marker-id="marker.id"
            :balloon-template=mapBalloon(marker)
        >

        </ymap-marker>
      </template>
    </yandex-map>
  </div>
</template>

<script>
import { yandexMap, ymapMarker } from 'vue-yandex-maps'
import BaseInput from "@/components/UI/BaseInput.vue";
import BaseButton from "@/components/UI/BaseButton.vue";
import {
  XMarkIcon,
} from '@heroicons/vue/24/outline'

const MOSCOW_COORDS = [37.61556, 55.75222]
const DEFAULT_ZOOM = 10
const settings = {
  apiKey: import.meta.env.VITE_APP_MAP_KEY || '',
  lang: 'ru_RU',
  coordorder: 'longlat',
  enterprise: false,
  version: '2.1'
}

export default {
  name: 'YandexMapPage',
  components: {
    BaseButton,
    BaseInput,
    yandexMap,
    ymapMarker,
    XMarkIcon
  },
  props: {
    coordsMarket: {
      type: Array,
    },
  },
  data() {
    return {
      mapConfig: {
        zoom: DEFAULT_ZOOM,
        coords: MOSCOW_COORDS,
        showAllMarkers: true,
      },
      settings,
    }
  },
  computed: {
    arrCoords() {
      const list = this.coordsMarket
      if(list?.length) {
        return list.map((item) => ({
          ...item,
          coords: [item?.geo_lon, item?.geo_lat]
        }))
      } return []
    }
  },
  methods: {
    onClick(e) {
      if(e.originalEvent) {
        this.$emit('newCoords', e.get('coords'));
        this.mapConfig.coords = e.get('coords')
      }
    },
    closeMap() {
      this.$emit('closeMap');
    },
    mapBalloon(object) {
      const direction = object?.direction?.list[+object?.direction?.direction_id || '1']
      return `
				<div class="py-4 px-4 sm:p-4">
				<h3 class="flex items-center text-sm font-medium leading-6 text-gray-900">
					${object.title}
				</h3>

				<div class="flex mt-1 text-xs text-gray-500">
					<span class="text-gray-500 text-xs whitespace-nowrap">${object.address}</span>
				</div>
				<div class="optional-fields relative mt-4">
				<div class="kitchenArea flex items-center pb-1">
					<div class="text-gray-500 text-sm min-w-2/5" style="width: 90px">
							Компания
						</div>
						<div v-if="item.kitchenArea" class="text-sm ml-4">
							Компания
						</div>
					</div>
					<div class="metroDistance flex items-center pb-1">
						<div class="text-gray-500 text-sm w-2/5 baloon-map" style="width: 90px">
							Направление
						</div>
						<div v-if="item.metroDistance" class="text-sm ml-4">
							${direction}
						</div>
					</div>
				  <div class="apartment-area flex items-center pb-1">
						<div class="text-gray-500 text-sm w-2/5 baloon-map" style="width: 90px">
								Зарплата
						</div>
						<div v-if="item.apartmentArea" class="text-sm ml-4">
							от ${object.income}
						</div>
					</div>
					<div class="floor flex items-center pb-1">
						<div class="text-gray-500 text-sm w-2/5 baloon-map" style="width: 90px">
								Наставник
						</div>
						<div v-if="item.floor" class="text-sm ml-4">
							Иван Смирнов
						</div>
					</div>

				</div>
          <a href="/cabinet/internships/${object.id}" target=_blank class="mt-3 flex justify-center border border-transparent shadow-sm text-sm font-medium cursor-pointer block whitespace-nowrap rounded px-3 py-1.5 button--primary bg-blue-600 text-white">
          Подробнее
          </a>
			  </div>
		      `
    },
  },
}
</script>

<style lang="scss" scoped>

.yandex-map-wrapper {
  position: relative;
  max-height: 500px;
  .yandex-map {
    @apply w-full;
    height: 500px;
  }
  .yandex-map-form {
    @apply flex flex-col bg-white px-4 py-3;
    position: absolute;
    top: 18px;
    left: 20px;
    z-index: 2;
    width: min(300px, 100%);
  }
  &__close {
    @apply w-7 h-7 absolute right-2 top-2 cursor-pointer;
    z-index: 2;
  }
}
</style>