import axios from 'axios';

// Create an axios instance with default settings
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // This will automatically prepend '/api' to all requests
  withCredentials: true,
  withXSRFToken: true
});

export default api