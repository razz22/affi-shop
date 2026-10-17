<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'DailyShop')) &mdash; {{ \App\Models\Setting::get('site_tagline', 'Your Daily Dose of Amazon Deals') }}</title>
    <meta name="description" content="@yield('meta_description', 'Hand-picked Amazon finds across electronics, fashion, home, beauty and more — curated daily.')">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.1/cdn.min.js" integrity="sha512-ytM6hP1K9BkRTjUQZpxZKFjJ2TvE4QXaK7phVymsm7NimaI5H09TWWW6f2JMbonLp4ftYU6xfwQGoe3C8jta9A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="flex min-h-screen flex-col bg-slate-50">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3">Skip to content</a>

    <header class="sticky top-0 z-40 shadow-md">
        {{-- Top bar --}}
        <div class="bg-navy-900 text-white">
            <div class="container-shop flex items-center gap-3 py-2.5">
                <button id="mobile-menu-toggle" class="rounded p-1.5 text-lg hover:bg-white/10 lg:hidden" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-1.5 text-xl font-extrabold tracking-tight">
                    <span class="text-brand">Daily</span><span>Shop</span>
                </a>

                <form action="{{ route('search') }}" method="GET" class="mx-2 hidden flex-1 sm:flex">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products, brands, categories&hellip;"
                           class="w-full rounded-l-lg border-0 px-4 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand">
                    <button type="submit" class="rounded-r-lg bg-brand px-4 text-navy-900 hover:bg-brand-dark" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <div class="ml-auto flex items-center gap-4 text-sm">
                    <a href="{{ route('deals') }}" class="hidden items-center gap-1.5 font-semibold hover:text-brand md:flex">
                        <i class="fa-solid fa-bolt text-brand"></i> Today's Deals
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden items-center gap-1.5 hover:text-brand sm:flex">
                            <i class="fa-solid fa-gauge"></i> Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden items-center gap-1.5 hover:text-brand sm:flex">
                            <i class="fa-solid fa-user-shield"></i> Admin
                        </a>
                    @endauth
                </div>
            </div>

            <form action="{{ route('search') }}" method="GET" class="container-shop flex pb-2.5 sm:hidden">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products&hellip;"
                       class="w-full rounded-l-lg border-0 px-4 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand">
                <button type="submit" class="rounded-r-lg bg-brand px-4 text-navy-900" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        {{-- Secondary nav --}}
        <nav class="bg-navy-800 text-sm text-slate-200">
            <div class="container-shop scrollbar-none flex items-center gap-5 overflow-x-auto py-2.5 whitespace-nowrap">
                <a href="{{ route('deals') }}" class="font-semibold text-brand hover:text-brand-light">Today's Deals</a>
                <a href="{{ route('bestsellers') }}" class="hover:text-white">Best Sellers</a>
                <a href="{{ route('new-arrivals') }}" class="hover:text-white">New Arrivals</a>
                <a href="{{ route('popular') }}" class="hover:text-white">Popular</a>
                <a href="{{ route('gift-cards') }}" class="hover:text-white">Gift Cards</a>
                <a href="{{ route('brands.index') }}" class="hover:text-white">Brands</a>
                <span class="h-4 w-px bg-white/20"></span>
                @foreach (\App\Models\Category::featured()->ordered()->get() as $navCategory)
                    <a href="{{ route('category.show', $navCategory) }}" class="hover:text-white">{{ $navCategory->name }}</a>
                @endforeach
            </div>
        </nav>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden bg-navy-800 text-slate-100 lg:hidden">
            <div class="container-shop flex flex-col gap-1 py-3 text-sm">
                <a href="{{ route('deals') }}" class="rounded px-2 py-2 font-semibold text-brand hover:bg-white/5">Today's Deals</a>
                <a href="{{ route('bestsellers') }}" class="rounded px-2 py-2 hover:bg-white/5">Best Sellers</a>
                <a href="{{ route('new-arrivals') }}" class="rounded px-2 py-2 hover:bg-white/5">New Arrivals</a>
                <a href="{{ route('popular') }}" class="rounded px-2 py-2 hover:bg-white/5">Popular</a>
                <a href="{{ route('gift-cards') }}" class="rounded px-2 py-2 hover:bg-white/5">Gift Cards</a>
                <a href="{{ route('brands.index') }}" class="rounded px-2 py-2 hover:bg-white/5">Brands</a>
                <div class="my-1 h-px bg-white/10"></div>
                @foreach (\App\Models\Category::ordered()->get() as $navCategory)
                    <a href="{{ route('category.show', $navCategory) }}" class="rounded px-2 py-2 hover:bg-white/5">{{ $navCategory->name }}</a>
                @endforeach
                <div class="my-1 h-px bg-white/10"></div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="rounded px-2 py-2 hover:bg-white/5"><i class="fa-solid fa-gauge mr-1"></i> Admin Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded px-2 py-2 hover:bg-white/5"><i class="fa-solid fa-user-shield mr-1"></i> Admin Login</a>
                @endauth
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="bg-success/10 text-success">
            <div class="container-shop py-2 text-sm font-semibold">
                <i class="fa-solid fa-circle-check mr-1"></i> {{ session('status') }}
            </div>
        </div>
    @endif

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-12 bg-navy-900 text-slate-300">
        <button id="back-to-top" class="fixed bottom-6 right-6 z-30 hidden rounded-full bg-brand p-3 text-navy-900 shadow-lg hover:bg-brand-dark" aria-label="Back to top">
            <i class="fa-solid fa-arrow-up"></i>
        </button>

        <div class="container-shop grid grid-cols-2 gap-8 py-12 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <h3 class="mb-3 text-lg font-extrabold text-white"><span class="text-brand">Daily</span>Shop</h3>
                <p class="text-sm text-slate-400">{{ \App\Models\Setting::get('site_tagline') }}</p>
            </div>
            <div>
                <h4 class="mb-3 font-semibold text-white">Shop</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('deals') }}" class="hover:text-brand">Today's Deals</a></li>
                    <li><a href="{{ route('bestsellers') }}" class="hover:text-brand">Best Sellers</a></li>
                    <li><a href="{{ route('new-arrivals') }}" class="hover:text-brand">New Arrivals</a></li>
                    <li><a href="{{ route('gift-cards') }}" class="hover:text-brand">Gift Cards</a></li>
                </ul>
            </div>
            <div>
                <h4 class="mb-3 font-semibold text-white">Categories</h4>
                <ul class="space-y-2 text-sm">
                    @foreach (\App\Models\Category::featured()->ordered()->take(5)->get() as $footerCategory)
                        <li><a href="{{ route('category.show', $footerCategory) }}" class="hover:text-brand">{{ $footerCategory->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="mb-3 font-semibold text-white">Brands</h4>
                <ul class="space-y-2 text-sm">
                    @foreach (\App\Models\Brand::featured()->ordered()->take(5)->get() as $footerBrand)
                        <li><a href="{{ route('brand.show', $footerBrand) }}" class="hover:text-brand">{{ $footerBrand->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 py-6">
            <div class="container-shop flex flex-col items-center gap-2 text-center text-xs text-slate-400 sm:flex-row sm:justify-between sm:text-left">
                <p>&copy; {{ date('Y') }} DailyShop. All rights reserved.</p>
                <p class="max-w-2xl">{{ \App\Models\Setting::get('footer_text') }}</p>
            </div>
        </div>
    </footer>

</body>
</html>
