<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/admin/app.scss'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 px-4">
                <div class="flex justify-center mb-10">
                    <style>
                         #banner_image {
                                max-width: 50%;
                                padding-bottom: 10px;
                                margin-left: 26%;
                            }
                        @media (max-width: 576px) {
                            #banner_image {
                                max-width: 33%;
                                padding-bottom: 10px;
                                margin-left: 33%;
                            }
                        }
                    </style>
                    <a href="/">
                        <img id="banner_image" src="{{ URL::asset('img/logo.png') }}" alt="Job Portal"
                            class="w-5 h-5" />
                    </a>
                </div>
                <div class="card shadow-sm rounded-0">
                    <div class="card-body p-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
