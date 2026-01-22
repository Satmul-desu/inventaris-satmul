<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventaris Satmul') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Google Fonts - Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Background with gradient and shapes -->
        <div class="min-h-screen bg-gradient-to-br from-purple-900 via-indigo-800 to-blue-600 relative overflow-hidden">
            
            <!-- Decorative circles -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            
            <!-- Small floating particles -->
            <div class="absolute top-20 right-40 w-4 h-4 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-40 left-20 w-3 h-3 bg-white/10 rounded-full animate-pulse delay-700"></div>
            <div class="absolute top-1/4 left-1/3 w-2 h-2 bg-white/10 rounded-full animate-pulse delay-300"></div>

            <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
                <div class="w-full max-w-6xl flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                    
                    <!-- Left Side - Branding -->
                    <div class="hidden lg:flex flex-col items-center lg:items-start lg:w-1/2 text-center lg:text-left space-y-6">
                        <!-- Logo Icon -->
                        <div class="w-24 h-24 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        
                        <div>
                            <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                                Inventaris<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-indigo-300">Barang Satmul</span>
                            </h1>
                            <p class="mt-4 text-lg text-purple-100/80 max-w-md">
                                Sistem manajemen inventaris modern untuk kebutuhan organisasi Anda. Mudah, efisien, dan terpercaya.
                            </p>
                        </div>

                        <!-- Feature highlights -->
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                            <div class="flex items-center gap-2 text-white/70">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm">Real-time Tracking</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm">Secure Data</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm">Easy Report</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form Card -->
                    <div class="w-full lg:w-1/2 max-w-md">
                        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-purple-900/20 overflow-hidden">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-semibold text-white">Selamat Datang</h2>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-8">
                                {{ $slot }}
                            </div>

                            <!-- Card Footer -->
                            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
                                <p class="text-center text-sm text-gray-600">
                                    Sistem Inventaris Barang - Satmul
                                </p>
                            </div>
                        </div>

                        <!-- Mobile logo (visible only on small screens) -->
                        <div class="lg:hidden text-center mt-6">
                            <div class="inline-flex items-center gap-2 text-white">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span class="text-xl font-bold">Inventaris Satmul</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
