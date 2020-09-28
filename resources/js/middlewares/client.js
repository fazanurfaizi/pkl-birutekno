import store from '@/store'

export default function admin({ next, router }) {
    store.dispatch('user/me').then((user) => {
        if (user.role === "client") {
            return next();
        } else {
            return router.push({ name: 'dashboard' });
        }
    })
}
