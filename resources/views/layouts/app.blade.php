<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- different view has different approach. $slot was default approach.  --}}
                @if(View::hasSection('content'))
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>

        <script>
            function copyToClipboard() {
                // Extract the URL from the anchor tag
                const linkElement = document.querySelector('.text-blue-500');
                const textToCopy = linkElement.getAttribute('href');

                // Use the Clipboard API to copy the text
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // Change button appearance briefly to indicate success
                    const btn = document.getElementById('copyBtn');
                    const originalHTML = btn.innerHTML;

                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    `;

                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                    }, 2000);

                }).catch(err => {
                        console.error('Failed to copy: ', err);
                });
            }
        </script>


    </body>
</html>
