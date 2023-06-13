<template>
  <div class="flex flex-col">
    <h1 class="text-2xl font-semibold pb-5">Кабинет</h1>
    <!--кандидат/стажер-->
    <template v-if="(info.role === 0) || (info.role === 1)">
      <cabinet-candidate/>
    </template>
    <!--куратор-->
    <template v-if="info.role === 2">
      <cabinet-supervisor/>
    </template>
    <!--наставник-->
    <template v-if="info.role === 3">
      <cabinet-mentor/>
    </template>
    <!--кадровый специалист-->
    <template v-if="info.role === 4">
      <cabinet-organization/>
    </template>
  </div>
</template>

<script>

import {mapState} from "vuex";
import CabinetCandidate from "@/components/layoutRoles/CabinetCandidate.vue";
import CabinetSupervisor from "@/components/layoutRoles/CabinetSupervisor.vue";
import CabinetMentor from "@/components/layoutRoles/CabinetMentor.vue";
import CabinetOrganization from "@/components/layoutRoles/CabinetOrganization.vue";

export default {
  name: "Cabinet",
  components: {
    CabinetOrganization,
    CabinetMentor,
    CabinetSupervisor,
    CabinetCandidate
  },
  data() {
    return {
    }
  },
  computed: {
    ...mapState('cabinet', ['info']),
  },
  methods: {
  },
  mounted() {
  }
}
</script>

<style lang="scss" scoped>
</style>