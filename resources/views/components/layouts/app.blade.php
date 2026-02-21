<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Koperasi Azra' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-slate-50 font-sans text-slate-800">
    
    <nav class="bg-blue-600 shadow-md p-4">
        <div class="max-w-7xl mx-auto flex justify-between text-white font-semibold">
            <span>Koperasi Azra - Dashboard</span>
            <span>Halo, Admin</span>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>