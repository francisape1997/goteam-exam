import axios from "axios";

export const notAuthRequired = [
    'login',
    'register',
];

export const authRequired = (page) => {
    return !notAuthRequired.includes(page);
};

export const setToken = (token) => {
    localStorage.setItem('token', token);

    axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('token')}`;
};
