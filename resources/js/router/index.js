import Vue from 'vue';
import VueRouter from 'vue-router';

import DashboardLayout from '@/layout/DashboardLayout.vue';
import NotFound from '@/views/pages/NotFoundPage.vue';
import AppLayout from '@/views/layouts/AppLayout.vue';
import Home from '@/views/pages/Home.vue';
import UserProfile from '@/views/user/EditProfileForm.vue';
import Dashboard from '@/views/dashboard';

import Middlewares from '@/middlewares';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/login',
    name: 'login',
    component: () =>
      import(/* webpackChunkName: "login" */ '@/views/auth/Login.vue'),
    meta: {
      middleware: [Middlewares.guest],
    },
  },
  {
    path: '/forgot-password',
    name: 'forgotPassword',
    component: () =>
      import(
        /* webpackChunkName: "forgotPassword" */ '@/views/auth/ForgotPassword.vue'
      ),
    meta: {
      middleware: [Middlewares.guest],
    },
  },
  {
    path: 'register',
    name: 'register',
    component: () =>
      import(/* webpackChunkName: "register" */ '@/views/auth/Register.vue'),
    meta: {
      middleware: [Middlewares.guest],
    },
  },
  {
    path: '/reset-password',
    name: 'resetPassword',
    component: () =>
      import(
        /* webpackChunkName: "resetPassword" */ '@/views/auth/ResetPassword.vue'
      ),
    meta: {
      middleware: [Middlewares.guest],
    },
  },
  {
    path: '/verify-email',
    name: 'verifyEmail',
    component: () =>
      import(
        /* webpackChunkName: "verifyEmail" */ '@/views/auth/VerifyEmail.vue'
      ),
    meta: {
      middleware: [Middlewares.guest],
    },
  },  
  {
    path: '/dashboard',
    component: DashboardLayout,
    meta: {
      middleware: [Middlewares.auth]
    },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard,
      },
      {
        path: 'profile',
        name: 'profile',
        component: UserProfile,
      },
      {
        path: 'tickets',
        name: 'tickets',
        component: () => import('@/views/dashboard/client/components/ticket'),
        middleware: [Middlewares.client]
      },
      {
        path: 'add-ticket',
        name: 'add-ticket',
        component: () =>
          import('@/views/dashboard/client/components/ticket/Add.vue'),        
      },
      {
        path: 'show-ticket/:id',
        name: 'show-ticket',
        component: () =>
          import('@/views/dashboard/client/components/ticket/Show.vue'),        
      },
      {
        path: 'edit-ticket/:id',
        name: 'edit-ticket',
        component: () =>
          import('@/views/dashboard/admin/components/ticket/EditTicket.vue'),
        middleware: [Middlewares.admin]
      },
      {
        path: 'projects',
        name: 'projects',
        component: () => import('@/views/dashboard/client/components/project'),        
      },
    ],
  },
  { path: '*', component: NotFound },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.APP_URL,
  routes,
  linkActiveClass: 'nav-item active',
});

function nextCheck(context, middleware, index) {
  const nextMiddleware = middleware[index];

  if (!nextMiddleware) {
    return context.next;
  }

  return (...parameters) => {
    context.next(...parameters);
    const nextMid = nextCheck(context, middleware, index + 1);

    nextMiddleware({ ...context, next: nextMid });
  };
}

router.beforeEach((to, from, next) => {
  if (to.meta.middleware) {
    const middleware = Array.isArray(to.meta.middleware)
      ? to.meta.middleware
      : [to.meta.middleware];

    const ctx = {
      from,
      next,
      router,
      to,
    };

    const nextMiddleware = nextCheck(ctx, middleware, 1);

    return middleware[0]({ ...ctx, next: nextMiddleware });
  }

  return next();
});

export default router;
