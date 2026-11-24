<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Туристичний оператор')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Туристичний оператор
            </a>

            <div class="navbar-nav flex-row flex-wrap gap-3">
                <a class="nav-link" href="{{ route('home') }}">Головна</a>
                <a class="nav-link" href="{{ route('tours.index') }}">Тури</a>
                <a class="nav-link" href="{{ route('tours.search') }}">Пошук турів</a>

                @if (auth()->user()?->role === 'manager')
                    <a class="nav-link" href="{{ route('bookings.index') }}">Бронювання</a>
                    <a class="nav-link" href="{{ route('categories.index') }}">Категорії</a>
                    <a class="nav-link" href="{{ route('destinations.index') }}">Напрямки</a>
                    <a class="nav-link" href="{{ route('hotels.index') }}">Готелі</a>
                    <a class="nav-link" href="{{ route('departures.index') }}">Виїзди</a>
                    <a class="nav-link" href="{{ route('itinerary.index') }}">Програма турів</a>
                    <a class="nav-link" href="{{ route('travelers.index') }}">Туристи</a>
                    <a class="nav-link" href="{{ route('payments.index') }}">Платежі</a>
                @endif

                @if (auth()->user()?->role === 'customer')
                    <a class="nav-link" href="{{ route('bookings.index') }}">Бронювання</a>
                @endif

                @if (auth()->user()?->role === 'admin')
                    <a class="nav-link" href="{{ route('users.index') }}">Користувачі</a>
                @endif

                @guest
                    <a class="nav-link" href="{{ route('login') }}">Увійти</a>
                @endguest

                @auth
                    <span class="navbar-text">
                        {{ auth()->user()->full_name }}
                        ({{ auth()->user()->role }})
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-outline-light">
                            Вийти
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>