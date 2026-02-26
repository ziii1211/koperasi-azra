<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login - Koperasi Azra' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">
    
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>