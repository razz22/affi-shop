<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') &mdash; DailyShop Admin</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100" x-data="{ sidebarOpen: false }">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.1/cdn.min.js" integrity="sha512-ytM6hP1K9BkRTjUQZpxZKFjJ2TvE4QXaK7phVymsm7NimaI5H09TWWW6f2JMbonLp4ftYU6xfwQGoe3C8jta9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-64 transform bg-navy-900 text-slate-200 transition-transform duration-200 lg:static lg:translate-x-0">
            <div class="flex h-16 items-center gap-2 px-5 text-xl font-extrabold text-white">
                <span class="text-brand">Daily</span>Shop <span class="text-xs font-normal text-slate-400">Admin</span>
            </div>
            <nav class="mt-2 flex flex-col gap-1 px-3 text-sm">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'label' => 'Dashboard'],
                        ['route' => 'admin.products.index', 'icon' => 'fa-box', 'label' => 'Products'],
                        ['route' => 'admin.categories.index', 'icon' => 'fa-grip', 'label' => 'Categories'],
                        ['route' => 'admin.brands.index', 'icon' => 'fa-award', 'label' => 'Brands'],
                        ['route' => 'admin.banners.index', 'icon' => 'fa-images', 'label' => 'Hero Banners'],
                    ];
                @endphp
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs($item['route'].'*') ? 'bg-brand text-navy-900 font-semibold' : 'hover:bg-white/10' }}">
                        <i class="fa-solid {{ $item['icon'] }} w-4"></i> {{ $item['label'] }}
                    </a>
                @endforeach

                <div class="my-2 h-px bg-white/10"></div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-white/10">
                    <i class="fa-solid fa-arrow-up-right-from-square w-4"></i> View Site
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left hover:bg-white/10">
                        <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-black/40 lg:hidden"></div>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-5">
                <button @click="sidebarOpen = true" class="text-lg text-slate-500 lg:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-lg font-bold text-navy-900">@yield('title', 'Dashboard')</h1>
                <div class="ml-auto flex items-center gap-2 text-sm text-slate-500">
                    <i class="fa-solid fa-circle-user text-lg"></i> {{ auth()->user()->name }}
                </div>
            </header>

            <main class="flex-1 p-5">
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-success/10 px-4 py-3 text-sm font-semibold text-success">
                        <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-deal/10 px-4 py-3 text-sm text-deal">
                        <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> Please fix the following:</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
