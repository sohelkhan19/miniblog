<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mini Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Styling --}}
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #343a40 !important;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        .btn-outline-danger,
        .btn-outline-primary,
        .btn-outline-success {
            font-weight: 500;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">📇 Laravel Blog</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item me-3">
                            <a class="nav-link" href="{{ route('blog.myPosts') }}">📂 My Posts</a>
                        </li>
                        {{-- Divider --}}
                        <li class="nav-item d-flex align-items-center me-3">
                            <div style="width: 1px; height: 25px; background-color: #ccc;"></div>
                        </li>
                        <li class="nav-item me-3">
                            <span class="text-dark fw-semibold">Hi, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container">
        <h1 class="text-center mb-4">Mini Laravel Blog</h1>
        @yield('content')
    </div>

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>