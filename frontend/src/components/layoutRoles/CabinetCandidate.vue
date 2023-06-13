<template>
  <div>
    <template v-if="!loading">
      <!--Stepper-->
      <div class="xl:border-b xl:border-t xl:border-gray-200">
        <nav class="mx-auto" aria-label="Progress">
          <ol role="list" class="overflow-hidden shadow rounded-md xl:flex xl:rounded-none xl:border-l xl:border-r xl:border-gray-200">
            <li v-for="(step, stepIdx) in steps" :key="step.id" class="relative bg-white overflow-hidden lg:flex-1">
              <div :class="[stepIdx === 0 ? 'rounded-t-md border-b-0' : '', stepIdx === steps.length - 1 ? 'rounded-b-md border-t-0' : '', 'overflow-hidden border border-gray-200 xl:border-0']">
                <div v-if="step.status === 'complete'" class="group">
                  <span class="absolute left-0 top-0 h-full w-1 bg-transparent xl:bottom-0 xl:top-auto xl:h-1 xl:w-full" aria-hidden="true" />
                  <span :class="[stepIdx !== 0 ? 'xl:pl-9' : '', 'flex items-start px-6 py-5 text-sm font-medium']">
                <span class="flex-shrink-0">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </span>
                </span>
                <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                  <span class="text-sm font-medium">{{ step.name }}</span>
                  <span class="text-sm font-medium text-gray-500">{{ step.description }}</span>
                </span>
              </span>
                </div>
                <div v-else-if="step.status === 'current'" aria-current="step">
                  <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 xl:bottom-0 xl:top-auto xl:h-1 xl:w-full" aria-hidden="true" />
                  <span :class="[stepIdx !== 0 ? 'xl:pl-9' : '', 'flex items-start px-6 py-5 text-sm font-medium']">
                <span class="flex-shrink-0">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-600">
                    <span class="text-indigo-600">0{{ step.id }}</span>
                  </span>
                </span>
                <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                  <span class="text-sm font-medium text-indigo-600">{{ step.name }}</span>
                  <span class="text-sm font-medium text-gray-500">{{ step.description }}</span>
                </span>
              </span>
                </div>
                <div v-else class="group">
                  <span class="absolute left-0 top-0 h-full w-1 bg-transparent xl:bottom-0 xl:top-auto xl:h-1 xl:w-full" aria-hidden="true" />
                  <span :class="[stepIdx !== 0 ? 'xl:pl-9' : '', 'flex items-start px-6 py-5 text-sm font-medium']">
                <span class="flex-shrink-0">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-300">
                    <span class="text-gray-500">0{{ step.id }}</span>
                  </span>
                </span>
                <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                  <span class="text-sm font-medium text-gray-900">{{ step.name }}</span>
                  <span class="text-sm font-medium text-gray-500">{{ step.description }}</span>
                </span>
              </span>
                </div>
                <template v-if="stepIdx !== 0">
                  <!-- Separator -->
                  <div class="absolute inset-0 left-0 top-0 hidden w-3 xl:block" aria-hidden="true">
                    <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                      <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                    </svg>
                  </div>
                </template>
              </div>
            </li>
          </ol>
        </nav>
      </div>

      <div class="mt-4">
        <template v-if="activeStep === 1">
          <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Демострация пустого состояния (Прием завершен)
                  {{ ' ' }}
                  <span @click="changeFlow" class="cursor-pointer ml-2 font-medium text-yellow-700 underline hover:text-yellow-600">
                {{flow ? 'Пустое состояние' : 'Текущее состояние'}}
              </span>
                </p>
              </div>
            </div>
          </div>
          <h2 class="text-xl font-semibold pt-3 pb-5">Заявка на стажировку</h2>
          <!--        Анкета-->
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Заполните анкету</h3>
                <span class="flex-shrink-0 ml-3">
                  <span v-if="info.questionnaire" class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
              </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <p>
                    Обратите внимание, что Ваша анкета обязательно будет просматриваться кадровыми специалистами при участии Вашей кандидатуры в конкурсах и вакансиях Правительства Москвы.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openQuestionnaire"
                  >
                    Заполнить
                  </base-button>
                </div>
              </div>
            </div>
          </div>
          <!--        Эссе-->
          <div class="bg-white shadow sm:rounded-lg mt-4">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Заполните эссе</h3>
                <span class="flex-shrink-0 ml-3">
                  <span v-if="info.essay" class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
              </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <p>
                    Обратите внимание, что Ваше эссе обязательно будет просматриваться кадровыми специалистами при участии Вашей кандидатуры в конкурсах и вакансиях Правительства Москвы.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openEssay"
                  >
                    Заполнить
                  </base-button>
                </div>
              </div>
            </div>
          </div>
          <!--        Направление стажировки-->
          <div v-if="flow" class="bg-white shadow sm:rounded-lg mt-4">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Выберите направление стажировки</h3>
                <span class="flex-shrink-0 ml-3">
                  <span v-if="directories" class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
              </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl w-full text-sm text-gray-500">
                  <base-select
                      class="max-w-xs w-full mt-2"
                      label="label"
                      v-model="directories"
                      :options="directoriesOptions"
                  />
                </div>
              </div>
            </div>
          </div>
          <!--        Отправить заявку-->
          <base-button
              v-if="flow && !failed"
              :disabled="disabled"
              type="primary"
              class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm mt-6"
              @click="sendApplication"
          >
            Отправить заявку
          </base-button>
          <div v-if="failed && flow" class="flex flex-col w-fit mt-6">
            <span class="mb-3 w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700">
              <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
              </svg>
              Заявка отклонена
            </span>
            Будем ждать Вас снова, на следующем отборе!
          </div>
          <!--        Набор заявок закрыт-->
          <div v-if="!flow" class="flex flex-col w-fit mt-6">
            <span class="mb-3 w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700">
              <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
              </svg>
              Прием завершен
            </span>
            Мы Вым обязательно напомним о старте записи на стажировку!
          </div>
        </template>
        <template v-if="activeStep === 2">
          <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Демострация - пользователь не прошел отбор на этапе карьерной школы
                  {{ ' ' }}
                  <span @click="changeFlow" class="cursor-pointer ml-2 font-medium text-yellow-700 underline hover:text-yellow-600">
                {{flow ? 'Посмотреть состояние' : 'Текущее состояние'}}
              </span>
                </p>
              </div>
            </div>
          </div>
          <h2 class="text-xl font-semibold pt-3 pb-5">Карьерная школа</h2>
          <!--        Карьерная школа-->
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Пройдите карьерную школу</h3>
                <span v-if="!flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                  <svg class="h-1.5 w-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Отказано
                </span>
                <span v-if="flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                  <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Одобрено
                </span>
                <span v-if="flow" class="flex-shrink-0 ml-3">
                  <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
                </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <span class="inline-flex items-center rounded-md py-1 text-gray-600 text-sm font-medium">
                    У Вас суммарно набрано: {{info.scores}} баллов
                  </span>
                  <p>
                    Узнай все о структуре Правительства Москвы и познакомься с лучшими городскими проектами.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      v-if="!failed && flow"
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openSchool"
                  >
                    Начать
                  </base-button>
                </div>
              </div>
            </div>
          </div>
          <!--        Отправить заявку-->
          <base-button
              v-if="!failed && flow"
              type="primary"
              class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm mt-6"
              @click="sendSchool"
          >
            Перейти к тестированию
          </base-button>
          <div v-if="failed || !flow" class="flex flex-col w-fit mt-6">
            <span class="mb-3 w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700">
              <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
              </svg>
              Заявка отклонена
            </span>
            Будем ждать Вас снова, на следующем отборе!
          </div>
        </template>
        <template v-if="activeStep === 3">
          <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Демострация - пользователь не прошел отбор на этапе тестирование
                  {{ ' ' }}
                  <span @click="changeFlow" class="cursor-pointer ml-2 font-medium text-yellow-700 underline hover:text-yellow-600">
                {{flow ? 'Посмотреть состояние' : 'Текущее состояние'}}
              </span>
                </p>
              </div>
            </div>
          </div>
          <h2 class="text-xl font-semibold pt-3 pb-5">Тестирование</h2>
          <!--        Тестирование-->
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Пройдите тестирование</h3>
                <span v-if="!flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                  <svg class="h-1.5 w-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Отказано
                </span>
                <span v-if="flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                  <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Одобрено
                </span>
                <span v-if="flow" class="flex-shrink-0 ml-3">
                  <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
                </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <span class="inline-flex items-center rounded-md py-1 text-gray-600 text-sm font-medium">
                    У Вас суммарно набрано: {{info.scores}} баллов
                  </span>
                  <p>
                    Пройди онлайн-тест на умение анализировать информацию, знание русского языка и компьютерную грамотность.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      v-if="!failed && flow"
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openTest"
                  >
                    Начать
                  </base-button>
                </div>
              </div>
            </div>
          </div>
          <!--        Отправить заявку-->
          <base-button
              v-if="!failed && flow"
              type="primary"
              class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm mt-6"
              @click="sendTest"
          >
            Перейти к кейс-чемпионату
          </base-button>
          <div v-if="failed || !flow" class="flex flex-col w-fit mt-6">
            <span class="mb-3 w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700">
              <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
              </svg>
              Заявка отклонена
            </span>
            Будем ждать Вас снова, на следующем отборе!
          </div>
        </template>
        <template v-if="activeStep === 4">
          <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Демострация - пользователь не прошел отбор на этапе Кейс-чемпионат
                  {{ ' ' }}
                  <span @click="changeFlow" class="cursor-pointer ml-2 font-medium text-yellow-700 underline hover:text-yellow-600">
                {{flow ? 'Посмотреть состояние' : 'Текущее состояние'}}
              </span>
                </p>
              </div>
            </div>
          </div>
          <h2 class="text-xl font-semibold pt-3 pb-5">Кейс-чемпионат</h2>
          <!--        Кейс-чемпионат-->
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Защити кейс-чемпионат</h3>
                <span v-if="!flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                  <svg class="h-1.5 w-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Отказано
                </span>
                <span v-if="flow" class="inline-flex ml-3 items-center gap-x-1.5 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                  <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                    <circle cx="3" cy="3" r="3" />
                  </svg>
                  Одобрено
                </span>
                <span v-if="flow" class="flex-shrink-0 ml-3">
                  <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
                </span>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <span class="inline-flex items-center rounded-md py-1 text-gray-600 text-sm font-medium">
                    У Вас суммарно набрано: {{info.scores}} баллов
                  </span>
                  <p>
                    Защити свой проект на кейс-чемпионате. Решайте реальные задачи от организаций Правительства Москвы, презентуя решения перед членами жюри.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      v-if="!failed && flow"
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openCase"
                  >
                    Начать
                  </base-button>
                </div>
              </div>
            </div>
          </div>
          <!--        Отправить заявку-->
          <base-button
              v-if="!failed && flow"
              type="primary"
              class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm mt-6"
              @click="sendCase"
          >
            Перейти к стажировкам
          </base-button>
          <div v-if="failed || !flow" class="flex flex-col w-fit mt-6">
            <span class="mb-3 w-fit inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-2 py-1 font-medium text-red-700">
              <svg class="h-2 w-2 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
              </svg>
              Заявка отклонена
            </span>
            Будем ждать Вас снова, на следующем отборе!
          </div>
        </template>
        <template v-if="activeStep === 5">
          <h2 class="text-xl font-semibold pt-3 pb-5">Стажировка</h2>
          <!--        Стажировка-->
          <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Выберите интересные стажировки</h3>
              </div>
              <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                  <p>
                    Для Вас открылся раздел "Стажировки", где Вы можете откликнуться на интересующие стажировки, пройти собеседование и начать карьеру в Правительстве Москвы.
                  </p>
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                  <base-button
                      type="primary"
                      class="rounded-md px-3 py-2 text-sm font-semibold shadow-sm"
                      @click="openInternships"
                  >
                    Перейти
                  </base-button>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </template>
    <loading v-else/>
  </div>
</template>

<script>
import BaseButton from "@/components/UI/BaseButton.vue";
import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid";
import {CheckIcon} from "@heroicons/vue/24/outline";
import {mapActions, mapState} from "vuex";
import Loading from "@/components/Loading.vue";
import BaseSelect from "@/components/UI/BaseSelect.vue";

export default {
  name: "CabinetCandidate",
  components: {
    BaseSelect,
    Loading,
    BaseButton,
    CheckIcon,
    ExclamationTriangleIcon
  },
  data() {
    return {
      loading: false,
      steps: [
        { id: 1, name: 'Заявка на стажировку', description: 'Заполнте анкету и эссе, и Вы сможете подать заявку на стажировку.', status: 'current' },
        { id: 2, name: 'Карьерная школа', description: 'Узнай все о структуре Правительства Москвы и познакомься с лучшими городскими проектами.', status: 'upcoming' },
        { id: 3, name: 'Тестирование', description: 'Пройди тест на анализ информации, знание русского языка и компьютерную грамотность.', status: 'upcoming' },
        { id: 4, name: 'Кейс-чемпионат', description: 'Защити свой проект на кейс-чемпионате.', status: 'upcoming' },
        { id: 5, name: 'Стажировка', description: 'Вливайся в команду Правительства Москвы в числе 125 лучших стажеров.', status: 'upcoming' },
      ],
      activeStep: 1,
      flow: false,
      directoriesOptions: [],
      directories: null,
      failed: false
    }
  },
  computed: {
    ...mapState('cabinet', ['info']),
    disabled() {
      return (this.directories === null) || (!this.info?.essay || false) || (!this.info?.questionnaire || false)
    }
  },
  methods: {
    ...mapActions('cabinet', ['getInfo', 'getDirections', 'getCandidate', 'setCreateOrder', 'setNextStage']),
    changeFlow() {
      this.flow = !this.flow
    },
    openQuestionnaire() {
      this.$router.push(`/cabinet/questionnaire`)
    },
    openEssay() {
      this.$router.push(`/cabinet/essay`)
    },
    openSchool() {
      window.open('https://talent.mos.ru/internships/', "_blank");
    },
    openTest() {
      window.open('https://talent.mos.ru/internships/', "_blank");
    },
    openCase() {
      window.open('https://talent.mos.ru/internships/', "_blank");
    },
    async sendApplication() {
      const payload = {
        direction: this.directories?.value || null
      }
      await this.setCreateOrder(payload).then((item) => {
        if(item?.success) {
          this.getInfo().then(() => {
            this.activeStep = 2
            this.flow = true
            this.steps = this.steps.map((item) => {
              if(item.id === this.activeStep) {
                return {
                  ...item,
                  status: 'current'
                }
              } else if (item.id < this.activeStep) {
                return {
                  ...item,
                  status: 'complete'
                }
              } else {
                return {
                  ...item,
                  status: 'upcoming'
                }
              }
            })
          })
        } else {
          this.failed = true
        }
      })
    },
    async sendSchool() {
      await this.setNextStage().then((item) => {
        if(item?.success) {
          this.getInfo().then(() => {
            this.activeStep = 3
            this.flow = true
            this.steps = this.steps.map((item) => {
              if (item.id === this.activeStep) {
                return {
                  ...item,
                  status: 'current'
                }
              } else if (item.id < this.activeStep) {
                return {
                  ...item,
                  status: 'complete'
                }
              } else {
                return {
                  ...item,
                  status: 'upcoming'
                }
              }
            })
          })
        } else {
          this.failed = true
        }
      })
    },
    async sendTest() {
      await this.setNextStage().then((item) => {
        if(item?.success) {
          this.getInfo().then(() => {
            this.activeStep = 4
            this.flow = true
            this.steps = this.steps.map((item) => {
              if(item.id === this.activeStep) {
                return {
                  ...item,
                  status: 'current'
                }
              } else if (item.id < this.activeStep) {
                return {
                  ...item,
                  status: 'complete'
                }
              } else {
                return {
                  ...item,
                  status: 'upcoming'
                }
              }
            })
          })
        } else {
          this.failed = true
        }
      })
    },
    async sendCase() {
      await this.setNextStage().then((item) => {
        if(item?.success) {
          this.getInfo().then(() => {
            this.activeStep = 5
            this.flow = true
            this.steps = this.steps.map((item) => {
              if(item.id === this.activeStep) {
                return {
                  ...item,
                  status: 'current'
                }
              } else if (item.id < this.activeStep) {
                return {
                  ...item,
                  status: 'complete'
                }
              } else {
                return {
                  ...item,
                  status: 'upcoming'
                }
              }
            })
            this.$router.push('/cabinet')
          })
        } else {
          this.failed = true
        }
      })
    },
    openInternships() {
      this.$router.push(`/cabinet/internships`)
    }
  },
  async mounted() {
    this.loading = true
    this.flow = true
    await this.getDirections().then((res) => {
      this.directoriesOptions = res?.map((item) => ({
        label: item?.title || '',
        value: item?.id || ''
      })) || []
    })
    await this.getCandidate().then((res) => {
      this.activeStep = (res?.order_status || 0) + 1
      // complete/current/upcoming
      this.steps = this.steps.map((item) => {
        if(item.id === this.activeStep) {
          return {
            ...item,
            status: 'current'
          }
        } else if (item.id < this.activeStep) {
          return {
            ...item,
            status: 'complete'
          }
        } else {
          return {
            ...item,
            status: 'upcoming'
          }
        }
      })
      if(res?.order?.id === 2) {
        this.failed = true
      }
      this.directories = res?.order?.directories !== null ? this.directoriesOptions?.find(item => item.id === res?.order?.directories) : null
    })
    await this.getInfo().finally(() => {
      this.loading = false
    })
  }
}
</script>

<style lang="scss" scoped>
</style>