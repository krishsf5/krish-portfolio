<!DOCTYPE html>
<html lang="en" x-data="{ theme: localStorage.theme || 'dark' }" x-init="if (theme === 'dark') {
    document.documentElement.classList.add('dark')
}">

<head>

    <meta charset="UTF-8">

    <title>{{ $title ?? 'Krish Bhojwani Portfolio' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body class="bg-[#080a14] text-white">

    <div class="min-h-screen flex flex-col">

        <header class="border-b border-slate-800">

            <div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">

                <h1 class="text-cyan-400 font-semibold text-lg">
                    Krish.dev
                </h1>

                <nav class="flex gap-8 text-sm">

                    <a href="#projects" class="nav-link">Projects</a>
                    <a href="#skills" class="nav-link">Skills</a>
                    <a href="#about" class="nav-link">About</a>

                </nav>

                <button class="btn-ghost"
                    @click="
theme = theme==='dark'?'light':'dark';
localStorage.theme = theme;

if(theme==='dark'){
document.documentElement.classList.add('dark')
}else{
document.documentElement.classList.remove('dark')
}
">
                    Theme
                </button>

            </div>

        </header>

        <main class="flex-1">

            {{ $slot }}

        </main>

        <footer class="border-t border-slate-800 py-6 text-center text-slate-400 text-sm">

            © {{ date('Y') }} Krish Bhojwani

        </footer>

    </div>

    @livewireScripts

</body>

</html>
