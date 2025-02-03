import axios from 'axios';

// Set the base URL for API requests
axios.defaults.baseURL = 'http://127.0.0.1:8000'; 

// Enable credentials (cookies) to be sent with each request
axios.defaults.withCredentials = true;

// Set the CSRF token for Axios to send with requests
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken.content;
}

export default axios;
