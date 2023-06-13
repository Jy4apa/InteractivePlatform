import store from "../store";
import router from "./index";

export const scrollBehavior = (to, from, savedPosition) => {
    return new Promise(resolve => {
        setTimeout(() => {
            if (`${to.path}${to.hash}` === `${from.path}${from.hash}`) return
            if(to.hash) {
                resolve({
                    selector: to.hash,
                    behavior: 'smooth',
                })
            }
            if (savedPosition) {
                resolve(savedPosition)
            } else {
                resolve({ x: 0, y: 0 })
            }
        }, 500)
    })
}

export const authGuard = (to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters['auth/isAuthenticated']) {
            router.push('/login');
        }
    }
    next()
};
