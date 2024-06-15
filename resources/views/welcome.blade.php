<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-cover {
            background-size: cover;
        }
        .btn-custom {
            background-color: #f79312;
        }
        .btn-custom:hover {
            background-color: #e68310;
        }
    </style>
</head>

<body class="antialiase bg-white">

    <div class="relative flex flex-col justify-center items-center bg-cover bg-center"
        style="background-image: url('https://eclectics.io/wp-content/themes/yootheme/cache/mobile-wallet-solution-0617f8b7.jpeg'); height: 100vh;">


        <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
            <div class="flex justify-center mb-8">
                <a href="/login">
                    <img src="{{ URL::asset('img/logo.png') }}" alt="Job Portal" class="w-auto h-16" />
                </a>
            </div>

            <h1 class="text-5xl font-bold text-white">Find Your Dream Job</h1>
            <p class="mt-4 text-lg text-white">Connecting talented individuals with top companies around the world.
            </p>
            @if (Route::has('login'))
                @auth
                @else
                    <div class="mt-4">
                        <a href="{{ route('login') }}"
                            class="bg-yellow-500 text-white font-bold py-2 px-6 rounded-md hover:bg-gray-700 transition duration-300">Get Started</a>
                    </div>
                @endauth
            @endif
        </div>
    </div>

</body>

</html>
