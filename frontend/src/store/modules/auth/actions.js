import {useToast} from "vue-toastification";
import {STORAGE_KEYS} from "@/common/const/config";
import axiosConfig from "@/common/axiosConfig";

const toast = useToast()

export default {
    signIn({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/login`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        if (res.data.token) {
                            localStorage.setItem(STORAGE_KEYS.ACCESS, res.data.token);
                            commit('setAuthData', res.data.token);
                            resolve()
                        }
                    } else {
                        toast.error(res?.data?.error || 'Ошибка авторизации! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка авторизации! Повторите позже')
                    reject()
                })
        })
    },
    signUp({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/signup`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve()
                    } else {
                        toast.error(res?.data?.error || 'Ошибка регистрации! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка регистрации! Повторите позже')
                    reject()
                })
        })
    },
    changePassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/change-password`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Пароль успешно изменен')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка смены пароля! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка смены пароля! Повторите позже')
                    reject()
                })
        })
    },
    signOut(context) {
        localStorage.removeItem(STORAGE_KEYS.ACCESS);
        context.commit('logout');
        const payload = {
            email: '',
            role: '',
            scores: '',
            firstname: '',
            lastname: '',
        }
        context.commit('cabinet/setInfo', payload, { root: true })
    },
}
