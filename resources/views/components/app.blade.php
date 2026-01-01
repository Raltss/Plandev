<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <main>
            @yield('content') 
            {{ $slot ?? '' }} 
        </main>
    </div>

    @livewireScripts
</body>