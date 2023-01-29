import { redirect } from './redirect.js';
import { request } from './request.js';
import { createToaster } from "@meforma/vue-toaster";

const showErrorMessage = (errors) => {
    const toaster = createToaster({});

    for (const [index, error] of Object.entries(errors)) {
        for (const message of error) {
            toaster.show(message, {
                duration: 10000,
                type: 'error',
                position: 'bottom-left'
            });
        }
    }
};

export const http =
{
    get: (url, method = 'GET') =>
        request(url, method)
            .then((response) =>
            {
                return response;
            })
            .catch((error) =>
            {
                redirect.signInPage(error.response.status);

                return error.response;
            }),

    post: (url, data, method = 'POST') =>
        request(url, method, data)
            .then((response) =>
            {
                return response;
            })
            .catch((error) =>
            {
                redirect.signInPage(error.response.status);

                if (error.response.status === 422) {
                    if (error.response.data?.errors) {
                        showErrorMessage(error.response?.data?.errors);
                    }
                }

                return error.response;
            }),

    put: (url, data, method = 'PUT') =>
        request(url, method, data)
            .then((response) =>
            {
                return response;
            })
            .catch((error) =>
            {
                redirect.signInPage(error.response.status);

                if (error.response.status === 422) {
                    if (error.response.data?.errors) {
                        showErrorMessage(error.response?.data?.errors);
                    }
                }

                return error.response;
            }),

    delete: (url, method = 'DELETE') =>
        request(url, method)
            .then((response) =>
            {
                return response;
            })
            .catch((error) =>
            {
                redirect.signInPage(error.response.status);

                return error.response;
            }),
};
