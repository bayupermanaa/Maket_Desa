// resources/js/bootstrap.js

import axios from 'axios';

// Set global Axios instance
window.axios = axios;

// Default headers untuk Laravel (penting agar dianggap AJAX request)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Optional: base URL kalau API di tempat lain
// window.axios.defaults.baseURL = 'http://localhost:8000';

// Optional: timeout default (dalam ms)
window.axios.defaults.timeout = 10000;

// Response interceptor untuk handle error global
window.axios.interceptors.response.use(
    response => response,  // Success: langsung return

    error => {
        // Handle error khusus Laravel
        if (error.response?.status === 419 || error.response?.status === 401) {
            console.warn('Session expired atau CSRF token mismatch. Silakan refresh halaman.');

            // Optional: auto refresh CSRF token (kalau pakai Sanctum/Breeze)
            // window.axios.get('/sanctum/csrf-cookie').then(() => {
            //     return window.axios(error.config); // retry request
            // });

            // Optional: redirect ke login
            // window.location.href = '/login';
        }

        return Promise.reject(error); // lempar error ke caller (then/catch)
    }
);

// Fungsi helper global untuk format angka Indonesia
window.formatNumber = (num, options = {}) => {
    if (typeof num !== 'number' || isNaN(num)) return '—';
    return num.toLocaleString('id-ID', {
        minimumFractionDigits: options.decimals || 0,
        maximumFractionDigits: options.decimals || 0,
        ...options,
    });
};

// Fungsi format Rupiah (dengan optional decimals)
window.formatRupiah = (num, decimals = 0) => {
    return 'Rp ' + window.formatNumber(num, { decimals });
};

// Contoh penggunaan:
// window.formatNumber(2450)          → "2.450"
// window.formatRupiah(800000000)     → "Rp 800.000.000"
// window.formatRupiah(1234.56, 2)    → "Rp 1.234,56"

export default window.axios;