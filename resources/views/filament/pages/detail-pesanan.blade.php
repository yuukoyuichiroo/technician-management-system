<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <div>
            <p class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                <x-heroicon-o-tag class="w-4 h-4" />
                ID Pesanan
            </p>
            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                #{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        <div>
            <p class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                <x-heroicon-o-calendar-days class="w-4 h-4" />
                Tanggal Pesanan
            </p>
            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                {{ $record->created_at->format('d F Y, H:i') }} WIB
            </p>
        </div>
    </div>

    <!-- Data Pelanggan -->
    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Pelanggan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-user class="w-4 h-4" />
                    Nama Pelanggan
                </p>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $record->nama_pelanggan }}</p>
            </div>
            <div>
                <p class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-map-pin class="w-4 h-4" />
                    Lokasi
                </p>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $record->lokasi }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Jasa -->
    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Jasa</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-800 dark:text-gray-100">No</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-800 dark:text-gray-100">Nama Jasa</th>
                        <th class="px-4 py-2 text-center font-medium text-gray-800 dark:text-gray-100">Jumlah</th>
                        <th class="px-4 py-2 text-right font-medium text-gray-800 dark:text-gray-100">Harga Satuan</th>
                        <th class="px-4 py-2 text-right font-medium text-gray-800 dark:text-gray-100">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($record->items as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white font-medium">{{ $item->jasa->nama_jasa }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $item->jumlah }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-gray-900 dark:text-white">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-900 dark:text-white font-semibold">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pembayaran -->
    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center pb-3 border-b border-gray-300 dark:border-gray-600">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Total Pembayaran</span>
                <span class="text-2xl font-bold text-green-600 dark:text-green-400">
                    Rp {{ number_format($record->total_harga, 0, ',', '.') }}
                </span>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe Pembayaran</p>
                    <span
                        class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $record->tipe_pembayaran == 'cash' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                        {{ $record->tipe_pembayaran == 'cash' ? 'Cash' : 'Non Cash' }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                    <span
                        class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $record->status_pembayaran == 'dibayar' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        {{ ucfirst(str_replace('_', ' ', $record->status_pembayaran)) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pengerjaan</p>
                    <span
                        class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $record->status_pengerjaan == 'selesai' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                        {{ ucfirst(str_replace('_', ' ', $record->status_pengerjaan)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
