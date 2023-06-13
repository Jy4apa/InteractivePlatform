<template>
  <div class="flex flex-col">
    <div class="flex sm:flex-row flex-col justify-between pb-5">
      <h1 class="text-2xl font-semibold">Стажировки</h1>
      <base-button
          type="primary"
          class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm mt-3 sm:mt-0"
          @click="openCreate"
      >
        Создать стажировку
      </base-button>
    </div>
    <template v-if="!loading">
      <div class="mb-6 space-y-3">
        <internships-card
            class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border"
            v-for="product in internships" :key="product.id"
            :value="product"
            isOrganization
        />
      </div>
    </template>
    <loading v-else/>
  </div>
</template>

<script>

import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid";
import InternshipsCard from "@/components/InternshipsCard.vue";
import Loading from "@/components/Loading.vue";
import BaseButton from "@/components/UI/BaseButton.vue";
import {mapActions} from "vuex";

export default {
  name: "ApplicationsOrganization",
  components: {
    BaseButton,
    Loading,
    InternshipsCard,
    ExclamationTriangleIcon
  },
  data() {
    return {
      loading: false,
      internships: [],
    }
  },
  computed: {
  },
  methods: {
    ...mapActions('cabinet', ['getOrganizationListVacancy']),
    openCreate() {
      this.$router.push('/cabinet/applications-organization/create');
    }
  },
  async mounted() {
    this.loading = true
    await this.getOrganizationListVacancy().then((item) => {
      this.internships = item || []
    })
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
</style>