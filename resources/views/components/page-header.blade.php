<div class="flex items-center justify-between px-4 py-3 bg-white">
    <!-- Left side - Logo -->
    <div class="flex items-center gap-2">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
        </svg>
        <span class="font-semibold text-lg">Plandev</span>
    </div>
    
    <!-- Center - Your content (absolutely centered) -->
    <div class="absolute left-1/2 transform -translate-x-1/2">
        {{ $slot }}
    </div>
    
    <!-- Right side - Icon -->
    <div>
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
        </svg>
    </div>
</div>