<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media (prefers-color-scheme: dark) {
                .dark\:bg-gray-200 {
                    --tw-bg-opacity: 1;
                    background-color: darkblue!important;
                }
            }
            .bg-white {
                background-color: rgb(23 21 39) !important;
            }
            .form-control,
            .form-select,
            .form-check-input,
            .form-check-label,
            textarea {
                background-color: #212529 !important;
                color: #ffffff !important;
                border-color: #495057 !important;
            }

            .form-control::placeholder,
            textarea::placeholder {
                color: #b0b3b8 !important;
            }

            .form-control:focus,
            .form-select:focus {
                background-color: #212529 !important;
                color: #ffffff !important;
                border-color: #0d6efd !important;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            }

            .form-check-input {
                background-color: #343a40 !important;
                border-color: #6c757d !important;
            }

            .form-check-input:checked {
                background-color: #0d6efd !important;
                border-color: #0d6efd !important;
            }

            .btn-dark {
                background-color: #343a40 !important;
                border-color: #6c757d !important;
                color: #ffffff !important;
            }

            .btn-dark:hover {
                background-color: #23272b !important;
                border-color: #1d2124 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased" data-bs-theme="dark">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
