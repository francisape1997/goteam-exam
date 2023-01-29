import router from '../router/index.js';
import { createToaster } from "@meforma/vue-toaster";

export const redirect =
{
    signInPage: (status) =>
    {
        if (status === 401)
        {
            localStorage.removeItem('token');

            router.push('/login').then(() => {
                const toaster = createToaster({});

                toaster.show('Unauthorized', {
                    position: 'bottom-left',
                    type: 'error',
                    duration: 5000
                });
            });
        }
    },
};
