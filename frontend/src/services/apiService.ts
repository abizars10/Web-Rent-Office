import axios from "axios";

const API_KEY = import.meta.env.VITE_REACT_API_KEY;
const BASE_URL = import.meta.env.VITE_REACT_API_URL;

const apiClient = axios.create({
  baseURL: BASE_URL,
  headers: {
    "X-API-KEY": API_KEY,
  },
});

// export axios.isAxiosError
export const isAxiosError = axios.isAxiosError;

export default apiClient;
