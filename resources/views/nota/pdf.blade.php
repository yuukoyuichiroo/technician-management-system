<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota - {{ $transaksi->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #333;
        }
        
        .nota-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 11px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .info-label {
            display: table-cell;
            width: 35%;
            font-weight: bold;
            padding: 5px 0;
        }
        
        .info-value {
            display: table-cell;
            width: 65%;
            padding: 5px 0;
        }
        
        .divider {
            border-top: 1px dashed #333;
            margin: 20px 0;
        }
        
        .detail-section {
            margin-bottom: 20px;
        }
        
        .detail-section h3 {
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .items-table th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            border: 1px solid #333;
            font-weight: bold;
            font-size: 11px;
        }
        
        .items-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .status-dibayar {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-belum-dibayar {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .status-selesai {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .status-belum-selesai {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .total-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #333;
        }
        
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .total-label {
            display: table-cell;
            width: 70%;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            padding: 5px 10px 5px 0;
        }
        
        .total-value {
            display: table-cell;
            width: 30%;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            padding: 5px 0;
        }
        
        .payment-info {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .thank-you {
            margin-top: 30px;
            text-align: center;
            font-style: italic;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $tokoInfo->nama_toko ?? 'Jasa Teknisi Komputer' }}</h1>
            @if($tokoInfo && $tokoInfo->nomor_telepon)
                <p>Telp: {{ $tokoInfo->nomor_telepon }}</p>
            @endif
            @if($tokoInfo && $tokoInfo->alamat)
                <p>{{ $tokoInfo->alamat }}</p>
            @endif
        </div>

        <!-- Info Pesanan -->
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">ID Pesanan:</div>
                <div class="info-value">#{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal:</div>
                <div class="info-value">{{ $transaksi->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Pelanggan:</div>
                <div class="info-value">{{ $transaksi->nama_pelanggan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi:</div>
                <div class="info-value">{{ $transaksi->lokasi }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Detail Jasa -->
        <div class="detail-section">
            <h3>Detail Layanan</h3>
            
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 45%;">Nama Jasa</th>
                        <th style="width: 10%;" class="text-center">Qty</th>
                        <th style="width: 20%;" class="text-right">Harga Satuan</th>
                        <th style="width: 20%;" class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->jasa->nama_jasa }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">TOTAL PEMBAYARAN:</div>
                <div class="total-value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="info-row" style="margin-bottom: 5px;">
                <div class="info-label">Tipe Pembayaran:</div>
                <div class="info-value">{{ $transaksi->tipe_pembayaran == 'cash' ? 'Cash' : 'Non Cash' }}</div>
            </div>
            <div class="info-row" style="margin-bottom: 5px;">
                <div class="info-label">Status Pembayaran:</div>
                <div class="info-value">
                    <span class="status-badge {{ $transaksi->status_pembayaran == 'dibayar' ? 'status-dibayar' : 'status-belum-dibayar' }}">
                        {{ $transaksi->status_pembayaran == 'dibayar' ? 'DIBAYAR' : 'BELUM DIBAYAR' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status Pengerjaan:</div>
                <div class="info-value">
                    <span class="status-badge {{ $transaksi->status_pengerjaan == 'selesai' ? 'status-selesai' : 'status-belum-selesai' }}">
                        {{ $transaksi->status_pengerjaan == 'selesai' ? 'SELESAI' : 'BELUM SELESAI' }}
</span>
</div>
</div>
</div>
    <!-- Thank You Message -->
    <div class="thank-you">
        <p>Terima kasih atas kepercayaan Anda!</p>
        <p>Kami siap melayani kebutuhan IT Anda</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Nota ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>Simpan nota ini sebagai bukti transaksi yang sah</p>
    </div>
</div>
</body>
</html>