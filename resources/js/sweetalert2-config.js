/**
 * Modern SweetAlert2 Configuration
 * Advanced alert system with Indonesian localization
 */

import Swal from 'sweetalert2';

// SweetAlert2 Configuration
const sweetalert2Config = {
    default: {
        confirmButtonColor: '#5c6bc0',
        cancelButtonColor: '#ef5350',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__faster',
            backdrop: 'swal2-backdrop-show',
            icon: 'swal2-icon-show'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOut animate__faster',
            backdrop: 'swal2-backdrop-hide',
            icon: 'swal2-icon-hide'
        },
        timer: 3000,
        timerProgressBar: true,
        scrollbarPadding: false,
        allowOutsideClick: false,
        allowEscapeKey: true,
        backdrop: true,
        toast: false,
        position: 'center',
        icon: 'success',
        title: 'Berhasil!',
        text: '',
        footer: '',
        width: '32rem',
        padding: '1.5rem',
        background: '#fff',
        timer: null,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    }
};

// Indonesian Localization
const indonesianLocale = {
    title: 'Peringatan!',
    text: 'Apakah Anda yakin?',
    footer: '',
    icon: 'warning',
    confirmButtonText: 'Ya, Lanjutkan!',
    cancelButtonText: 'Batal',
    showCancelButton: true,
    showConfirmButton: true,
    focusConfirm: false,
    focusCancel: true,
    confirmButtonAriaLabel: 'Ya, lanjutkan tindakan',
    cancelButtonAriaLabel: 'Batalkan tindakan'
};

// Custom Themes
const themes = {
    modern: {
        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#ef5350'
    },
    success: {
        background: 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
        confirmButtonColor: '#11998e',
        cancelButtonColor: '#ef5350'
    },
    danger: {
        background: 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)',
        confirmButtonColor: '#eb3349',
        cancelButtonColor: '#9e9e9e'
    },
    warning: {
        background: 'linear-gradient(135deg, #f2994a 0%, #f2c94c 100%)',
        confirmButtonColor: '#f2994a',
        cancelButtonColor: '#ef5350'
    },
    info: {
        background: 'linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%)',
        confirmButtonColor: '#2193b0',
        cancelButtonColor: '#ef5350'
    },
    glass: {
        background: 'rgba(255, 255, 255, 0.95)',
        backdropFilter: 'blur(10px)',
        confirmButtonColor: '#5c6bc0',
        cancelButtonColor: '#ef5350'
    },
    dark: {
        background: 'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#ef5350',
        color: '#fff',
        titleColor: '#fff',
        textColor: '#e0e0e0'
    },
    neon: {
        background: 'linear-gradient(to right, #0f0c29, #302b63, #24243e)',
        confirmButtonColor: '#00d2ff',
        cancelButtonColor: '#ff6b6b',
        color: '#fff',
        titleColor: '#00d2ff',
        textColor: '#e0e0e0'
    }
};

// Helper Functions
const SweetAlert = {
    // Basic Alert Types
    success: (title = 'Berhasil!', text = 'Operasi berhasil dilakukan') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'success',
            title: title,
            text: text,
            timer: 3000,
            background: themes.success.background,
            confirmButtonColor: themes.success.confirmButtonColor
        });
    },

    error: (title = 'Gagal!', text = 'Terjadi kesalahan') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'error',
            title: title,
            text: text,
            timer: 4000,
            background: themes.danger.background,
            confirmButtonColor: themes.danger.confirmButtonColor
        });
    },

    warning: (title = 'Peringatan!', text = 'Harap periksa kembali') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'warning',
            title: title,
            text: text,
            timer: 4000,
            background: themes.warning.background,
            confirmButtonColor: themes.warning.confirmButtonColor
        });
    },

    info: (title = 'Informasi', text = 'Berikut adalah informasi untuk Anda') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'info',
            title: title,
            text: text,
            timer: 3000,
            background: themes.info.background,
            confirmButtonColor: themes.info.confirmButtonColor
        });
    },

    question: (title = 'Pertanyaan', text = 'Apakah Anda yakin?') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            text: text,
            background: themes.modern.background,
            confirmButtonColor: themes.modern.confirmButtonColor
        });
    },

    // Confirmation Dialogs
    confirm: (title = 'Konfirmasi', text = 'Apakah Anda yakin ingin melanjutkan?') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            background: themes.glass.background,
            confirmButtonColor: '#5c6bc0',
            cancelButtonColor: '#ef5350'
        });
    },

    confirmDelete: (title = 'Hapus Data', text = 'Data yang dihapus tidak dapat dikembalikan!') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'warning',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef5350',
            cancelButtonColor: '#9e9e9e',
            reverseButtons: true
        });
    },

    confirmDanger: (title = 'Peringatan!', text = 'Tindakan ini bersifat permanen dan tidak dapat dibatalkan!') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'error',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonText: 'Ya, Saya Yakin!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#9e9e9e',
            background: themes.danger.background,
            reverseButtons: true
        });
    },

    // Toast Notifications
    toast: (type = 'success', title = '', position = 'top-end', timer = 3000) => {
        const toastIcons = {
            success: '<i class="fas fa-check-circle" style="color: #4caf50;"></i>',
            error: '<i class="fas fa-times-circle" style="color: #f44336;"></i>',
            warning: '<i class="fas fa-exclamation-circle" style="color: #ff9800;"></i>',
            info: '<i class="fas fa-info-circle" style="color: #2196f3;"></i>'
        };

        return Swal.fire({
            toast: true,
            position: position,
            icon: type,
            title: toastIcons[type] + ' ' + title,
            timer: timer,
            timerProgressBar: true,
            showConfirmButton: false,
            showCancelButton: false,
            background: type === 'error' ? '#ffebee' : '#fff',
            iconColor: type === 'error' ? '#f44336' : 
                     type === 'success' ? '#4caf50' : 
                     type === 'warning' ? '#ff9800' : '#2196f3'
        });
    },

    toastSuccess: (title = 'Berhasil!', position = 'top-end') => {
        return SweetAlert.toast('success', title, position);
    },

    toastError: (title = 'Gagal!', position = 'top-end') => {
        return SweetAlert.toast('error', title, position);
    },

    toastWarning: (title = 'Peringatan!', position = 'top-end') => {
        return SweetAlert.toast('warning', title, position);
    },

    toastInfo: (title = 'Info', position = 'top-end') => {
        return SweetAlert.toast('info', title, position);
    },

    // Input Dialogs
    inputText: (title = 'Input Text', text = 'Masukkan data yang diperlukan') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            text: text,
            input: 'text',
            inputPlaceholder: 'Masukkan teks...',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Input tidak boleh kosong!';
                }
            }
        });
    },

    inputEmail: (title = 'Input Email', text = 'Masukkan email yang valid') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            text: text,
            input: 'email',
            inputPlaceholder: 'contoh@email.com',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Email tidak boleh kosong!';
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    return 'Format email tidak valid!';
                }
            }
        });
    },

    inputPassword: (title = 'Password', text = 'Masukkan password baru') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            text: text,
            input: 'password',
            inputPlaceholder: 'Masukkan password...',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Password tidak boleh kosong!';
                }
                if (value.length < 6) {
                    return 'Password minimal 6 karakter!';
                }
            }
        });
    },

    inputSelect: (title = 'Pilih Opsi', options = {}) => {
        const selectOptions = Object.entries(options)
            .map(([key, value]) => `<option value="${key}">${value}</option>`)
            .join('');

        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'question',
            title: title,
            html: `<select id="swal-select" class="swal2-select" style="display: block; padding: 10px; width: 100%; border: 1px solid #d3d3d3; border-radius: 5px; margin-top: 10px;">${selectOptions}</select>`,
            showCancelButton: true,
            confirmButtonText: 'Pilih',
            cancelButtonText: 'Batal',
            didOpen: () => {
                document.getElementById('swal-select').focus();
            }
        });
    },

    inputCheckbox: (title = 'Persetujuan', text = 'Silakan centang jika Anda setuju') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'info',
            title: title,
            html: `
                <div style="text-align: left; padding: 10px;">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" id="swal-checkbox" style="width: 20px; height: 20px; margin-right: 10px;">
                        <span>${text}</span>
                    </label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Setuju',
            cancelButtonText: 'Tidak',
            confirmButtonColor: '#4caf50',
            focusConfirm: false,
            inputValidator: (result) => {
                return !document.getElementById('swal-checkbox').checked && 'Anda harus menyetujui syarat dan ketentuan!';
            }
        });
    },

    // Rich Content Dialogs
    withImage: (title = '', text = '', imageUrl = '', imageWidth = 200) => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            imageUrl: imageUrl,
            imageWidth: imageWidth,
            imageAlt: title,
            background: themes.glass.background
        });
    },

    withHtml: (title = '', html = '') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            html: html,
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Batal',
            background: themes.glass.background
        });
    },

    // Progress Steps
    progressSteps: (title = 'Multi-step Process', steps = []) => {
        if (steps.length === 0) {
            steps = ['Langkah 1', 'Langkah 2', 'Langkah 3'];
        }

        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            html: 'Proses multi-langkah',
            progressSteps: steps,
            currentProgressStep: 0,
            showCancelButton: true,
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal',
            background: themes.glass.background
        });
    },

    // Timer Dialogs
    withTimer: (title = 'Loading...', timer = 3000, text = 'Sedang memproses...') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            timer: timer,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                // Custom actions after timer
            }
        });
    },

    // Ajax Requests
    ajaxRequest: (title = 'Mengirim Data...', method = 'POST', url = '#') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: 'Mohon tunggu sebentar...',
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },

    // Advanced Dialogs
    withCustomClass: (options = {}) => {
        return Swal.fire({
            ...sweetalert2Config.default,
            ...options,
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });
    },

    // RTL Support (Indonesian)
    rtl: (title = 'نجاح', text = 'تم بنجاح', position = 'center') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            dir: 'rtl',
            title: title,
            text: text,
            position: position,
            background: themes.glass.background
        });
    },

    // Dynamic Theme
    withTheme: (themeName, title, text) => {
        const theme = themes[themeName] || themes.modern;
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            background: theme.background,
            color: theme.color || '#333',
            confirmButtonColor: theme.confirmButtonColor
        });
    },

    // Login Form
    loginForm: (title = 'Login', text = 'Silakan masukkan kredensial Anda') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            html: `
                <div style="text-align: left;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email:</label>
                        <input type="email" id="swal-email" class="swal2-input" placeholder="Masukkan email" style="width: 100%; padding: 10px; border: 1px solid #d3d3d3; border-radius: 5px;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password:</label>
                        <input type="password" id="swal-password" class="swal2-input" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid #d3d3d3; border-radius: 5px;">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Login',
            cancelButtonText: 'Batal',
            focusConfirm: false,
            didOpen: () => {
                document.getElementById('swal-email').focus();
            }
        });
    },

    // Registration Form
    registerForm: (title = 'Pendaftaran', text = 'Silakan lengkapi data berikut') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            html: `
                <div style="text-align: left;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Lengkap:</label>
                        <input type="text" id="swal-name" class="swal2-input" placeholder="Masukkan nama lengkap" style="width: 100%; padding: 10px; border: 1px solid #d3d3d3; border-radius: 5px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email:</label>
                        <input type="email" id="swal-email" class="swal2-input" placeholder="Masukkan email" style="width: 100%; padding: 10px; border: 1px solid #d3d3d3; border-radius: 5px;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Password:</label>
                        <input type="password" id="swal-password" class="swal2-input" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid #d3d3d3; border-radius: 5px;">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Daftar',
            cancelButtonText: 'Batal',
            focusConfirm: false
        });
    },

    // File Upload
    fileUpload: (title = 'Upload File', text = 'Pilih file yang ingin diupload') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            html: `
                <div style="text-align: center; padding: 20px;">
                    <input type="file" id="swal-file" style="display: none;">
                    <label for="swal-file" style="cursor: pointer; display: inline-block; padding: 30px; border: 2px dashed #667eea; border-radius: 10px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #667eea;"></i>
                        <p style="margin-top: 10px; color: #333;">Klik untuk memilih file<br><small style="color: #666;">atau drag & drop file di sini</small></p>
                    </label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Upload',
            cancelButtonText: 'Batal',
            focusConfirm: false
        });
    },

    // Success with Timer
    successWithTimer: (title = 'Berhasil!', text = 'Redirect dalam {timer} detik...', timer = 3000) => {
        let timerInterval;
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'success',
            title: title,
            text: text,
            timer: timer,
            background: themes.success.background,
            confirmButtonColor: themes.success.confirmButtonColor,
            didOpen: () => {
                timerInterval = setInterval(() => {
                    const content = Swal.getContent();
                    if (content) {
                        const remainingTime = Swal.getTimerLeft();
                        const seconds = Math.ceil(remainingTime / 1000);
                        const textElement = content.querySelector('div.swal2-html-container');
                        if (textElement) {
                            textElement.innerHTML = text.replace('{timer}', seconds);
                        }
                    }
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
    },

    // Network Error
    networkError: (title = 'Koneksi Gagal!', text = 'Silakan periksa koneksi internet Anda') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'error',
            title: title,
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-wifi" style="font-size: 64px; color: #ef5350;"></i>
                    <p style="margin-top: 20px;">${text}</p>
                </div>
            `,
            timer: 5000,
            background: themes.danger.background,
            confirmButtonColor: themes.danger.confirmButtonColor
        });
    },

    // Server Error
    serverError: (title = 'Server Error!', text = 'Terjadi kesalahan pada server. Silakan coba lagi nanti.') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'error',
            title: title,
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-server" style="font-size: 64px; color: #ef5350;"></i>
                    <p style="margin-top: 20px;">${text}</p>
                    <code style="display: block; margin-top: 10px; padding: 10px; background: rgba(0,0,0,0.1); border-radius: 5px;">Error 500: Internal Server Error</code>
                </div>
            `,
            background: themes.danger.background,
            confirmButtonColor: themes.danger.confirmButtonColor
        });
    },

    // Not Found
    notFound: (title = 'Tidak Ditemukan!', text = 'Halaman atau data yang Anda cari tidak ditemukan.') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'error',
            title: title,
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-search" style="font-size: 64px; color: #ff9800;"></i>
                    <p style="margin-top: 20px;">${text}</p>
                </div>
            `,
            background: themes.warning.background,
            confirmButtonColor: themes.warning.confirmButtonColor
        });
    },

    // Access Denied
    accessDenied: (title = 'Akses Ditolak!', text = 'Anda tidak memiliki izin untuk mengakses halaman ini.') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'warning',
            title: title,
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-ban" style="font-size: 64px; color: #f44336;"></i>
                    <p style="margin-top: 20px;">${text}</p>
                </div>
            `,
            background: themes.danger.background,
            confirmButtonColor: themes.danger.confirmButtonColor
        });
    },

    // Welcome Message
    welcome: (name = 'Pengguna') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'success',
            title: `Selamat Datang, ${name}!`,
            text: 'Senang melihat Anda kembali di sistem inventaris.',
            background: themes.modern.background,
            confirmButtonColor: themes.modern.confirmButtonColor,
            timer: 4000
        });
    },

    // Goodbye Message
    goodbye: (name = '') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            icon: 'info',
            title: 'Terima Kasih!',
            text: name ? `Sampai jumpa, ${name}!` : 'Sampai jumpa kembali!',
            background: themes.info.background,
            confirmButtonColor: themes.info.confirmButtonColor,
            timer: 3000
        });
    },

    // Loading
    loading: (title = 'Memuat...', text = 'Mohon tunggu sebentar') => {
        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            showCancelButton: false
        });
    },

    // Custom Animation Theme
    withAnimation: (animationType, title, text) => {
        const animations = {
            slideInDown: 'animate__animated animate__slideInDown',
            slideInLeft: 'animate__animated animate__slideInLeft',
            slideInRight: 'animate__animated animate__slideInRight',
            fadeIn: 'animate__animated animate__fadeIn',
            fadeInUp: 'animate__animated animate__fadeInUp',
            fadeInDown: 'animate__animated animate__fadeInDown',
            zoomIn: 'animate__animated animate__zoomIn',
            flipInX: 'animate__animated animate__flipInX',
            bounceIn: 'animate__animated animate__bounceIn',
            jackInTheBox: 'animate__animated animate__jackInTheBox'
        };

        return Swal.fire({
            ...sweetalert2Config.default,
            title: title,
            text: text,
            showClass: {
                popup: `${animations[animationType] || animations.fadeInUp} animate__faster`
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            background: themes.glass.background
        });
    }
};

// Export both Swal and SweetAlert helper
window.Swal = Swal;
window.SweetAlert = SweetAlert;
window.sweetalert2Config = sweetalert2Config;
window.themes = themes;

export default SweetAlert;
export { Swal, SweetAlert, sweetalert2Config, themes, indonesianLocale };

