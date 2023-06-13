import {useToast} from "vue-toastification";
import axiosConfig from "@/common/axiosConfig";

const toast = useToast()

export default {
    getInfo({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/get-info`)
                .then((res) => {
                    if(res?.data?.success) {
                        if(res?.data?.data) {
                            commit('setInfo', res.data.data);
                        }
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    getProfile({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/profile`)
                .then((res) => {
                    if(res?.data?.success) {
                        commit('setProfile', res.data.data);
                        resolve(res?.data?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    setUpdateProfile({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/update-profile`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    getEssay({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/essay`)
                .then((res) => {
                    if(res?.data?.success) {
                        // Массив, обработка пока 1 эссе
                        commit('setEssay', res?.data?.data[0] || null);
                        resolve(res?.data?.data[0] || null)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    setCreateEssay({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/essay`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    setUpdateEssay({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.put(`/v1/cabinet/essay`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    // страны для гражданства
    getCountries({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/countries`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res?.data?.data || [])
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    // теги опыта работы
    getSpecializations({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/specializations`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res?.data?.data || [])
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    // направления
    getDirections({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/directions`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res?.data?.data || [])
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    getCandidate({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/get-candidate`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    setCreateOrder({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/create-candidate-order`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Заявка успешно принята')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data.error || 'Ваша заявка не прошла по критериям отбора')
                        resolve(res?.data)
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    setAddEducation({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/add-education`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    setAddExperience({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/add-experience`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    setNextStage({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/next-stage`)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Поздравляем! Вы прошли на следующий этап!')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Заявка отклонена')
                        resolve(res?.data)
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },

    // вакансии
    setCreateVacancy({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/create-vacancy`, payload)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },
    getOrganizationListVacancy({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/organization/list-vacancy`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    setUpdateVacancy({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/update-vacancy/${payload.id}`, payload.date)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно сохранено')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },

    // вакансии открытые
    getCabinetVacancy({commit}, id) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/get-vacancy/${id}`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    getListVacancy({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/list-vacancy`, {
                params: payload
            })
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
    setAddVacancy({commit}, id) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/approve-vacancy/${id}`,)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно опубликована')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка данных! Повторите позже')
                    reject()
                })
        })
    },
    setCancelVacancy({commit}, id) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/cancel-vacancy/${id}`)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно отклонена')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка данных! Повторите позже')
                    reject()
                })
        })
    },

    // заявки
    getListCandidate({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/list-candidate`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },

    setEditVacancy({commit}, payload) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/edit-vacancy/${payload.id}`, payload.date)
                .then((res) => {
                    if(res?.data?.success) {
                        toast.success('Успешно отклонена')
                        resolve(res?.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка сохранения данных! Повторите позже')
                    reject()
                })
        })
    },

    // Список свободных наставников
    getListMentors({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/list-mentors`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },

    // Отклик на вакансию
    setReply({commit}, id) {
        return new Promise((resolve, reject) => {
            axiosConfig.post(`/v1/cabinet/reply`, {vacancy_id: id})
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.success)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка отправки заявки! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка отправки заявки! Повторите позже')
                    reject()
                })
        })
    },

    // Информация о наставнике
    getMentor({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/get-mentor`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },

    // Список откликов на вакансию
    getListReplies({commit}) {
        return new Promise((resolve, reject) => {
            axiosConfig.get(`/v1/cabinet/list-replies`)
                .then((res) => {
                    if(res?.data?.success) {
                        resolve(res.data.data)
                    } else {
                        toast.error(res?.data?.error || 'Ошибка получения данных! Повторите позже')
                    }
                })
                .catch((err) => {
                    console.error(err)
                    toast.error(err?.response?.data?.error || 'Ошибка получения данных! Повторите позже')
                    reject()
                })
        })
    },
}
