import axios from 'axios';

const API_URL = 'http://localhost';

export function request(url, method, data = [])
{
    return axios({
        url: `${API_URL}/api/${url}`,
        method,
        data,
    });
}

