import axios from "axios";

const instance = axios.create({
    baseURL: 'http://laravel.test/api'
});

export default instance;
