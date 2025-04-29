<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <style>
        body {
            background-color: #f8fafc;
        }
        
        .sidebar {
            background-color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 40;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4b5563;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.15s ease-in-out;
        }

        .nav-link:hover {
            background-color: #f3f4f6;
            color: #1d4ed8;
        }

        .nav-link.active {
            background-color: #1d4ed8;
            color: white;
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .stats-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: transform 0.15s ease-in-out;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .content-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
    </style>
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @auth
    <div class="flex min-h-screen">
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-8 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-user-circle text-lg mr-2"></i>
                            {{ Auth::user()->nama }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <!-- Tambahkan ini di akhir body -->
    @stack('scripts')
</body>
</html>
