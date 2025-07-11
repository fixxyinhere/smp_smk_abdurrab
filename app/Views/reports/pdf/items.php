<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        .school-info h1 {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .school-info h2 {
            font-size: 16px;
            color: #475569;
            margin-bottom: 5px;
        }

        .school-info p {
            font-size: 11px;
            color: #64748b;
        }

        .report-title {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .report-title h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .report-title p {
            font-size: 12px;
            opacity: 0.9;
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11px;
            color: #64748b;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            position: relative;
        }

        .stat-card.primary {
            border-left: 4px solid #2563eb;
        }

        .stat-card.success {
            border-left: 4px solid #16a34a;
        }

        .stat-card.warning {
            border-left: 4px solid #ea580c;
        }

        .stat-card.danger {
            border-left: 4px solid #dc2626;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.primary .stat-number {
            color: #2563eb;
        }

        .stat-card.success .stat-number {
            color: #16a34a;
        }

        .stat-card.warning .stat-number {
            color: #ea580c;
        }

        .stat-card.danger .stat-number {
            color: #dc2626;
        }

        .stat-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            background: #1e293b;
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th {
            background: #f1f5f9;
            color: #1e293b;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #e2e8f0;
            font-size: 10px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        tr:hover {
            background: #f1f5f9;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge.warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge.danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .currency {
            text-align: right;
            font-weight: 500;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            border-top: 2px solid #e2e8f0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-section {
            text-align: center;
            min-width: 200px;
        }

        .signature-line {
            border-top: 1px solid #64748b;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 11px;
            color: #64748b;
        }

        .summary-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-top: 20px;
            font-size: 11px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
        }

        /* Print optimizations */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-container {
                break-inside: avoid;
            }

            tr {
                break-inside: avoid;
            }
        }

        .page-break {
            page-break-before: always;
        }

        .no-break {
            break-inside: avoid;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="school-info">
                <h1>SMK ABDURRAB PEKANBARU</h1>
                <h2>Sistem Manajemen Sarana & Prasarana</h2>
                <p>Jl. Contoh Alamat No. 123, Pekanbaru, Riau 28000 | Tel: (0761) 123456 | Email: info@smkabdurrab.sch.id</p>
            </div>
        </div>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h3><?= $title ?></h3>
        <p>Periode: Semua Data | Dicetak pada: <?= $date ?> pukul <?= $time ?> WIB</p>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <div>
            <strong>Tanggal Cetak:</strong> <?= $date ?>
        </div>
        <div>
            <strong>Waktu Cetak:</strong> <?= $time ?> WIB
        </div>
        <div>
            <strong>Dicetak oleh:</strong> <?= session()->get('full_name') ?>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-number"><?= $stats['total'] ?></div>
            <div class="stat-label">Total Barang</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number"><?= $stats['good'] ?></div>
            <div class="stat-label">Kondisi Baik</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-number"><?= $stats['damaged'] ?></div>
            <div class="stat-label">Kondisi Rusak</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-number"><?= $stats['lost'] ?></div>
            <div class="stat-label">Hilang</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-header">
            <i class="fas fa-boxes"></i> Daftar Inventaris Barang
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 12%;">Kode</th>
                    <th style="width: 25%;">Nama Barang</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 8%;">Jumlah</th>
                    <th style="width: 10%;">Kondisi</th>
                    <th style="width: 15%;">Lokasi</th>
                    <th style="width: 10%;">Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totalValue = 0; ?>
                <?php foreach ($items as $item): ?>
                    <?php $totalValue += ($item['price'] * $item['quantity']); ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= $item['code'] ?></strong></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['category_name'] ?></td>
                        <td class="text-center"><?= $item['quantity'] ?></td>
                        <td class="text-center">
                            <?php if ($item['condition_status'] === 'baik'): ?>
                                <span class="badge success">Baik</span>
                            <?php elseif ($item['condition_status'] === 'rusak'): ?>
                                <span class="badge warning">Rusak</span>
                            <?php else: ?>
                                <span class="badge danger">Hilang</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $item['location'] ?></td>
                        <td class="currency">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Information -->
    <div class="summary-info">
        <div class="summary-row">
            <span>Total Jumlah Barang:</span>
            <span><?= array_sum(array_column($items, 'quantity')) ?> unit</span>
        </div>
        <div class="summary-row">
            <span>Total Nilai Inventaris:</span>
            <span>Rp <?= number_format($totalValue, 0, ',', '.') ?></span>
        </div>
        <div class="summary-row">
            <span>Persentase Kondisi Baik:</span>
            <span><?= $stats['total'] > 0 ? round(($stats['good'] / $stats['total']) * 100, 1) : 0 ?>%</span>
        </div>
        <div class="summary-row">
            <span>Status Laporan:</span>
            <span>Data Valid per <?= $date ?></span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>
            <div style="font-size: 10px; color: #64748b;">
                <strong>Catatan:</strong><br>
                • Laporan ini dibuat secara otomatis oleh sistem<br>
                • Data yang ditampilkan akurat sesuai database pada waktu cetak<br>
                • Untuk verifikasi, hubungi bagian administrasi
            </div>
        </div>

        <div class="signature-section">
            <div>Mengetahui,</div>
            <div class="signature-line">
                Kepala Sekolah<br>
                <strong>SMK Abdurrab Pekanbaru</strong>
            </div>
        </div>

        <div class="signature-section">
            <div>Dicetak oleh,</div>
            <div class="signature-line">
                <?= session()->get('full_name') ?><br>
                <strong><?= ucfirst(session()->get('role')) ?></strong>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>