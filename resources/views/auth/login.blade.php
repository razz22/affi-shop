<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login &mdash; DailyShop</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-navy-900 px-4">
    <div class="w-full max-w-sm">
        <div class="mb-6 text-center text-2xl font-extrabold text-white">
            <span class="text-brand">Daily</span>Shop <span class="text-sm font-normal text-slate-400">Admin</span>
        </div>

        <div class="card p-6">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-deal/10 px-4 py-3 text-sm text-deal">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="input">
                </div>
                <div>
                    <label for="password" class="label">Password</label>
                    <input type="password" name="password" id="password" required class="input">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300"> Remember me
                </label>
                <button type="submit" class="btn-brand w-full">
                    <i class="fa-solid fa-right-to-bracket"></i> Log In
                </button>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-brand">&larr; Back to site</a>
        </p>
    </div>
</body>
</html>
