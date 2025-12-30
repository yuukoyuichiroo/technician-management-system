<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">
                        Selamat Datang di Dashboard! 👋
                    </h2>
                    <p class="text-blue-100">
                        Aplikasi manajemen jasa teknisi kami membantu Anda mengelola layanan teknisi dengan mudah dan efisien.
                    </p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Widgets -->
        @livewire(\App\Filament\Widgets\StatsOverviewWidget::class)
        
        @livewire(\App\Filament\Widgets\RevenueChartWidget::class)
        
        @livewire(\App\Filament\Widgets\RecentTransactionsWidget::class)
    </div>
</x-filament-panels::page>