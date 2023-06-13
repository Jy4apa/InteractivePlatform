import { createRouter, createWebHistory } from 'vue-router'
import { scrollBehavior, authGuard} from './utils'
import {routes} from './routes';

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior
});

// * enable hooks
router.beforeEach(authGuard);

export default router
