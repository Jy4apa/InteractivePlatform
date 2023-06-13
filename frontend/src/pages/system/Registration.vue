<template>
  <div class="flex bg-white py-8 px-4 overflow-hidden sm:0 registration">
    <div class="relative max-w-2xl mx-auto flex">
      <svg class="absolute left-full transform translate-x-1/2" width="404" height="404" fill="none" viewBox="0 0 404 404" aria-hidden="true">
        <defs>
          <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
          </pattern>
        </defs>
        <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)" />
      </svg>
      <svg class="absolute right-full bottom-0 transform -translate-x-1/2" width="404" height="404" fill="none" viewBox="0 0 404 404" aria-hidden="true">
        <defs>
          <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
          </pattern>
        </defs>
        <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)" />
      </svg>
      <div class="flex flex-col justify-center">
        <div class="text-center flex flex-col justify-center items-center w-64">
          <div>
            <img class="block h w-auto" src="../../assets/images/logo.png" alt="logo-icon">
          </div>
          <h2 class="text-3xl font-extrabold tracking-tight mt-6 text-gray-900 sm:text-3xl">
            Регистрация
          </h2>
        </div>
        <Form
            v-slot="{ errors }"
            @submit="submit"
            :validation-schema="schema"
            class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 mt-12"
        >
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">E-Mail</label>
            <div class="relative">
              <Field
                  v-model="form.email"
                  as="input"
                  name="email"
                  type="email"
                  autocomplete="email"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.email ? 'border-red-600 focus:border-red-600' : ''"
              />
              <span v-if="errors.email" class="text-red-600 text-sm">Заполните поле "E-Mail"</span>
            </div>
          </div>
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">Имя</label>
            <div class="relative">
              <Field
                  v-model="form.firstname"
                  as="input"
                  name="firstname"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.firstname ? 'border-red-600 focus:border-red-600' : ''"
              />
              <span v-if="errors.firstname" class="text-red-600 text-sm">Заполните поле "Имя"</span>
            </div>
          </div>
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">Фамилия</label>
            <div class="relative">
              <Field
                  v-model="form.lastname"
                  as="input"
                  name="lastname"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.lastname ? 'border-red-600 focus:border-red-600' : ''"
              />
              <span v-if="errors.lastname" class="text-red-600 text-sm">Заполните поле "Фамилия"</span>
            </div>
          </div>
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">Пароль</label>
            <div class="relative">
              <Field
                  v-model="form.password"
                  as="input"
                  name="password"
                  type="password"
                  id="password"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.password ? 'border-red-600 focus:border-red-600' : ''"
              />
              <div class="pass-visible" @click="visiblePass()">
                <svg v-if="!isPassVisible" class="ico-pass-visible"  width="20" height="15" viewBox="0 0 22 15" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 0C3 0 0 8 0 8C0 8 3 16 11 16C19 16 22 8 22 8C22 8 19 0 11 0ZM11 3C13.761 3 16 5.239 16 8C16 10.761 13.761 13 11 13C8.239 13 6 10.761 6 8C6 5.239 8.239 3 11 3ZM11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5Z" />
                </svg>
                <svg v-else class="ico-pass-visible" width="20" height="18" viewBox="0 0 22 18" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.9903 0.990234C2.79137 0.990287 2.59697 1.04967 2.43196 1.16078C2.26695 1.27189 2.13883 1.42969 2.06397 1.614C1.98911 1.79832 1.97093 2.00077 2.01173 2.19547C2.05253 2.39017 2.15048 2.56828 2.29304 2.70703L4.07624 4.49023C2.14437 6.04173 0.891589 7.94401 0.271553 9.06055C-0.0604472 9.65855 -0.0495409 10.3785 0.275459 10.9805C1.43046 13.1185 4.75107 18 11.0001 18C13.0756 18 14.8061 17.4547 16.2423 16.6562L18.293 18.707C18.3852 18.803 18.4956 18.8796 18.6177 18.9324C18.7398 18.9852 18.8712 19.0131 19.0043 19.0144C19.1373 19.0158 19.2693 18.9906 19.3925 18.9403C19.5157 18.89 19.6276 18.8157 19.7216 18.7216C19.8157 18.6275 19.8901 18.5156 19.9404 18.3924C19.9907 18.2692 20.0159 18.1373 20.0145 18.0042C20.0132 17.8712 19.9853 17.7397 19.9325 17.6176C19.8797 17.4955 19.8031 17.3851 19.7071 17.293L3.7071 1.29297C3.61391 1.19717 3.50247 1.12103 3.37935 1.06903C3.25624 1.01704 3.12395 0.990242 2.9903 0.990234ZM11.0001 2C9.78807 2 8.70586 2.19972 7.71687 2.51172L10.2774 5.07227C10.5144 5.03727 10.7531 5 11.0001 5C13.7611 5 16.0001 7.239 16.0001 10C16.0001 10.247 15.9628 10.4857 15.9278 10.7227L19.3575 14.1523C20.4315 12.9603 21.2176 11.7513 21.6876 10.9473C22.0416 10.3433 22.0401 9.60133 21.7051 8.98633C20.5361 6.83333 17.2191 2 11.0001 2ZM6.83405 7.24805L8.29694 8.71094C8.10823 9.10083 8.00007 9.53657 8.00007 10C8.00007 11.657 9.34307 13 11.0001 13C11.4635 13 11.8992 12.8918 12.2891 12.7031L13.754 14.168C12.7604 14.8268 11.5207 15.1424 10.1993 14.9375C8.10129 14.6115 6.38857 12.8988 6.06257 10.8008C5.85774 9.48 6.17582 8.24139 6.83405 7.24805Z" />
                </svg>
              </div>
              <span v-if="errors.password" class="text-red-600 text-sm">Заполните поле "Пароль"</span>
            </div>
          </div>
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">Потвердите пароль</label>
            <div class="relative">
              <Field
                  v-model="form.password_confirm"
                  as="input"
                  name="password_confirm"
                  type="password"
                  id="password_confirm"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.password_confirm ? 'border-red-600 focus:border-red-600' : ''"
              />
              <div class="pass-visible" @click="visiblePassConfirmation">
                <svg v-if="!isPassConfirmationVisible" class="ico-pass-visible" width="20" height="15" viewBox="0 0 22 15" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 0C3 0 0 8 0 8C0 8 3 16 11 16C19 16 22 8 22 8C22 8 19 0 11 0ZM11 3C13.761 3 16 5.239 16 8C16 10.761 13.761 13 11 13C8.239 13 6 10.761 6 8C6 5.239 8.239 3 11 3ZM11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5Z" />
                </svg>
                <svg v-else class="ico-pass-visible" width="20" height="18" viewBox="0 0 22 18" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.9903 0.990234C2.79137 0.990287 2.59697 1.04967 2.43196 1.16078C2.26695 1.27189 2.13883 1.42969 2.06397 1.614C1.98911 1.79832 1.97093 2.00077 2.01173 2.19547C2.05253 2.39017 2.15048 2.56828 2.29304 2.70703L4.07624 4.49023C2.14437 6.04173 0.891589 7.94401 0.271553 9.06055C-0.0604472 9.65855 -0.0495409 10.3785 0.275459 10.9805C1.43046 13.1185 4.75107 18 11.0001 18C13.0756 18 14.8061 17.4547 16.2423 16.6562L18.293 18.707C18.3852 18.803 18.4956 18.8796 18.6177 18.9324C18.7398 18.9852 18.8712 19.0131 19.0043 19.0144C19.1373 19.0158 19.2693 18.9906 19.3925 18.9403C19.5157 18.89 19.6276 18.8157 19.7216 18.7216C19.8157 18.6275 19.8901 18.5156 19.9404 18.3924C19.9907 18.2692 20.0159 18.1373 20.0145 18.0042C20.0132 17.8712 19.9853 17.7397 19.9325 17.6176C19.8797 17.4955 19.8031 17.3851 19.7071 17.293L3.7071 1.29297C3.61391 1.19717 3.50247 1.12103 3.37935 1.06903C3.25624 1.01704 3.12395 0.990242 2.9903 0.990234ZM11.0001 2C9.78807 2 8.70586 2.19972 7.71687 2.51172L10.2774 5.07227C10.5144 5.03727 10.7531 5 11.0001 5C13.7611 5 16.0001 7.239 16.0001 10C16.0001 10.247 15.9628 10.4857 15.9278 10.7227L19.3575 14.1523C20.4315 12.9603 21.2176 11.7513 21.6876 10.9473C22.0416 10.3433 22.0401 9.60133 21.7051 8.98633C20.5361 6.83333 17.2191 2 11.0001 2ZM6.83405 7.24805L8.29694 8.71094C8.10823 9.10083 8.00007 9.53657 8.00007 10C8.00007 11.657 9.34307 13 11.0001 13C11.4635 13 11.8992 12.8918 12.2891 12.7031L13.754 14.168C12.7604 14.8268 11.5207 15.1424 10.1993 14.9375C8.10129 14.6115 6.38857 12.8988 6.06257 10.8008C5.85774 9.48 6.17582 8.24139 6.83405 7.24805Z" />
                </svg>
              </div>
              <span v-if="errors.password_confirm" class="text-red-600 text-sm">Заполните поле "Потвердите пароль"</span>
            </div>
          </div>
          <div class="sm:col-span-6 mt-6">
            <div
                v-if="error"
                class="text-red-600 text-sm pb-2 text-center"
            >
              {{ errorText }}
            </div>
            <div class="space-y-5 mb-4 w-64">
              <div class="relative c flex items-start">
                <div class="flex h-6 items-center">
                  <input id="comments" v-model="isChecked" aria-describedby="comments-description" name="comments" type="checkbox" class="cursor-pointer h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600" />
                </div>
                <div class="ml-3 text-sm leading-6">
                  <label for="comments" class="text-gray-900">Я даю согласие на</label>
                  {{ ' ' }}
                  <a
                      href='/Согласие_на_обработку_данных.pdf'
                      target="_blank"
                      class="cursor-pointer text-gray-900 hover:underline">
                    обработку персональных данных.
                  </a>
                </div>
              </div>
            </div>
            <base-button
                class="w-full inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-md"
                :type="'primary'"
                :html-type="'submit'"
                :class="!isChecked && 'disabled'"
            >
              Зарегистрироваться
            </base-button>
          </div>
        </Form>
        <div class="flex text-sm mt-3 text-center justify-center">
          У Вас уже есть аккаунт?
          <router-link
              class="text-blue-800 ml-2"
              to="/login"
          >
            Войти
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import BaseButton from "@/components/UI/BaseButton.vue";
import {Field, Form} from "vee-validate";
import * as yup from "yup";

export default {
  name: "Registration",
  components: {
    BaseButton,
    Field,
    Form
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
        password_confirm: '',
        firstname: '',
        lastname: '',
      },
      errors: {
        email: '',
        password: '',
        password_confirm: '',
        firstname: '',
        lastname: '',
      },
      error: false,
      respErr: null,
      errorText: '',
      isPassVisible: false,
      isPassConfirmationVisible: false,
      isChecked: false,
    }
  },
  methods: {
    ...mapActions('auth', ['signUp']),
    submit() {
      this.errors = {}
      this.errorText = ''
      if (!Object.keys(this.errors).length && this.isChecked) {
        this.signUp({
          email: this.form.email,
          firstname: this.form.firstname,
          lastname: this.form.lastname,
          password: this.form.password,
          password_confirm: this.form.password_confirm
        })
            .then(() => {
              this.error = false
              this.$router.push('/login');
            })
            .catch((e) => {
              this.error = true
              this.errorText = e
              console.error(e);
            })
      }
    },
    visiblePass () {
      this.isPassVisible = !this.isPassVisible;
      document.getElementById('password').setAttribute(
          "type",
          this.isPassVisible ? "input" : "password"
      );
    },
    visiblePassConfirmation() {
      this.isPassConfirmationVisible = !this.isPassConfirmationVisible;
      document.getElementById('password_confirm').setAttribute(
          "type",
          this.isPassConfirmationVisible ? "input" : "password"
      );
    },
  },
  setup() {
    const schema = yup.object({
      email: yup.string().required(),
      password: yup.string().required(),
      password_confirm: yup.string().required(),
      firstname: yup.string().required(),
      lastname: yup.string().required(),
    });
    return {
      schema,
    };
  }
}
</script>

<style lang="scss" scoped>
.registration {
  min-height: 100vh;
  .button-primary {
    background: #0274CD;
    height: fit-content;
    &:hover {
      background: lighten(#0274CD, 15%);
    }
  }
  .disabled {
    cursor: not-allowed;
    @apply bg-gray-600 hover:bg-gray-600;
  }
  .pass-visible {
    position: absolute;
    top: 8px;
    right: 10px;
    height: 21px;
    display: flex;
    align-items: center;
    cursor: pointer;

    .ico-pass-visible {
      fill: #1e1e1e;
      opacity: 0.2;
      margin-right: 5px;
    }

    [dir="rtl"] & {
      right: auto;
      left: 0;
    }
  }
}
</style>