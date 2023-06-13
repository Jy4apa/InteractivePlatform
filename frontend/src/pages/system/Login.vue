<template>
  <div class="flex bg-white py-16 px-4 overflow-hidden sm:0 lg:py-24 login">
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
            Вход в систему
          </h2>
        </div>
        <Form
            v-slot="{ errors }"
            @submit="submit"
            :validation-schema="schema"
            class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 mt-12"
        >
          <div class="sm:col-span-6">
            <label class="block text-sm font-medium text-gray-700">Логин</label>
            <div class="relative">
              <Field
                  v-model="form.username"
                  as="input"
                  name="username"
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.username ? 'border-red-600 focus:border-red-600' : ''"
              />
              <span v-if="errors.username" class="text-red-600 text-sm">Заполните поле "Логин"</span>
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
                  class="block mt-1 w-full bg-white border border-gray-300 rounded-md py-2 px-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="errors.password ? 'border-red-600 focus:border-red-600' : ''"
              />
              <span v-if="errors.password" class="text-red-600 text-sm">Заполните поле "Пароль"</span>
            </div>
          </div>
          <div class="sm:col-span-6 mt-6">
            <div
                v-if="error"
                class="text-red-600 text-sm pb-2 text-center"
            >
                Неверный логин или пароль
              </div>
            <base-button
                class="w-full inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-md"
                :type="'primary'"
                :html-type="'submit'"
            >
              Войти
            </base-button>
          </div>
        </Form>
        <div class="flex text-sm mt-3 text-center justify-center">
          Нет аккаунта?
          <router-link
              class="text-blue-800 ml-2"
              to="/registration"
          >
            Зарегистрироваться
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
  name: "Login",
  components: {
    BaseButton,
    Field,
    Form
  },
  data() {
    return {
      form: {
        username: '',
        password: '',
      },
      errors: {
        username: '',
        password: '',
      },
      error: false,
      respErr: null,
    }
  },
  methods: {
    ...mapActions('auth', ['signIn']),
    submit() {
      this.errors = {}
      // axios.get(`${import.meta.env.VITE_APP_API_URL}/v1/hello`)
      if (!Object.keys(this.errors).length) {
        this.signIn({
          identity: this.form.username,
          password: this.form.password,
          rememberMe: true
        })
            .then(() => {
              this.error = false
              this.$router.push('/cabinet');
            })
            .catch((e) => {
              this.error = true
              console.error(e);
            })
      }
    },
  },
  setup() {
    const schema = yup.object().shape({
      username: yup.string().required(),
      password: yup.string().required(),
    });
    return {
      schema,
    };
  }
}
</script>

<style lang="scss" scoped>
.login {
  height: 100vh;
  .button-primary {
    background: #0274CD;
    height: fit-content;
    &:hover {
      background: lighten(#0274CD, 15%);
    }
  }
}
</style>