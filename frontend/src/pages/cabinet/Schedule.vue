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
    <h1 class="text-2xl font-semibold pb-5">Расписание стажера</h1>
  </div>
</template>

<script>

import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid";

export default {
  name: "Schedule",
  components: {
    ExclamationTriangleIcon
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