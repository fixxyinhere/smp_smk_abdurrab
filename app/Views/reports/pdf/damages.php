<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @page {
            margin: 2cm 1.5cm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2d3748;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .school-info h1 {
            font-size: 22px;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .school-info h2 {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .school-info p {
            font-size: 11px;
            color: #718096;
            line-height: 1.4;
        }

        .report-title {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #2d3748;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }

        .report-title h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
        }

        .report-title p {
            font-size: 12px;
            color: #4a5568;
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 10px;
            color: #718096;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .stats-section {
            margin-bottom: 30px;
        }

        .stats-title {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .stat-card {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2d3748;
        }

        .stat-label {
            font-size: 11px;
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .urgent-section {
            background: #fffbf0;
            border: 1px solid #fed7d7;
            border-left: 3px solid #e53e3e;
            padding: 15px;
            margin-bottom: 25px;
        }

        .urgent-title {
            color: #c53030;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .table-container {
            background: white;
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }

        .table-header {
            background: #2d3748;
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th {
            background: #f7fafc;
            color: #2d3748;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            font-size: 10px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #f7fafc;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: white;
        }

        .badge.urgent {
            border-color: #e53e3e;
            color: #c53030;
        }

        .badge.high {
            border-color: #dd6b20;
            color: #c05621;
        }

        .badge.medium {
            border-color: #3182ce;
            color: #2c5282;
        }

        .badge.low {
            border-color: #718096;
            color: #4a5568;
        }

        .badge.pending {
            border-color: #dd6b20;
            color: #c05621;
        }

        .badge.verified {
            border-color: #3182ce;
            color: #2c5282;
        }

        .badge.resolved {
            border-color: #38a169;
            color: #2f855a;
        }

        .badge.rejected {
            border-color: #e53e3e;
            color: #c53030;
        }

        .legend-section {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-top: 25px;
            font-size: 10px;
        }

        .legend-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d3748;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-info {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-top: 25px;
            font-size: 11px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 4px 0;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            font-weight: 600;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 40px;
            border-top: 2px solid #e2e8f0;
            padding-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-section {
            text-align: center;
            min-width: 180px;
            font-size: 11px;
        }

        .signature-line {
            border-top: 1px solid #718096;
            margin-top: 50px;
            padding-top: 5px;
            color: #718096;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .currency {
            text-align: right;
            font-weight: 500;
        }

        .notes {
            font-size: 10px;
            color: #718096;
            line-height: 1.4;
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
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="school-info">
            <h1>SMK ABDURRAB PEKANBARU</h1>
            <h2>Sistem Manajemen Sarana & Prasarana</h2>
            <p>Jl. Contoh Alamat No. 123, Pekanbaru, Riau 28000 | Tel: (0761) 123456 | Email: info@smkabdurrab.sch.id</p>
        </div>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h3><?= $title ?></h3>
        <p>Periode: Semua Data | Dicetak pada: <?= $date ?> pukul <?= $time ?> WIB</p>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <div><strong>Tanggal Cetak:</strong> <?= $date ?></div>
        <div><strong>Waktu Cetak:</strong> <?= $time ?> WIB</div>
        <div><strong>Dicetak oleh:</strong> <?= session()->get('full_name') ?></div>
    </div>

    <!-- Statistics -->
    <div class="stats-section">
        <div class="stats-title">RINGKASAN STATISTIK</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= isset($stats['total']) ? $stats['total'] : count($damages) ?></div>
                <div class="stat-label">Total Laporan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= isset($stats['pending']) ? $stats['pending'] : 0 ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= isset($stats['verified']) ? $stats['verified'] : 0 ?></div>
                <div class="stat-label">Verified</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= isset($stats['resolved']) ? $stats['resolved'] : 0 ?></div>
                <div class="stat-label">Resolved</div>
            </div>
        </div>
    </div>

    <!-- Urgent Reports Section -->
    <?php
    $urgentReports = array_filter($damages, function ($damage) {
        return $damage['priority'] === 'urgent' && $damage['status'] !== 'resolved';
    });
    ?>
    <?php if (!empty($urgentReports)): ?>
        <div class="urgent-section">
            <div class="urgent-title">LAPORAN PRIORITAS URGENT</div>
            <div style="font-size: 10px;">
                <?php foreach (array_slice($urgentReports, 0, 3) as $urgent): ?>
                    <div style="margin-bottom: 5px;">
                        <strong><?= $urgent['report_number'] ?></strong> - <?= $urgent['item_name'] ?>
                        (<?= ucfirst($urgent['damage_type']) ?>) - Pelapor: <?= $urgent['user_name'] ?>
                    </div>
                <?php endforeach; ?>
                <?php if (count($urgentReports) > 3): ?>
                    <div style="color: #c53030; font-weight: bold;">
                        Dan <?= count($urgentReports) - 3 ?> laporan urgent lainnya...
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-header">DAFTAR LAPORAN KERUSAKAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 12%;">No. Laporan</th>
                    <th style="width: 10%;">Kode Barang</th>
                    <th style="width: 18%;">Nama Barang</th>
                    <th style="width: 15%;">Pelapor</th>
                    <th style="width: 12%;">Jenis Kerusakan</th>
                    <th style="width: 8%;">Prioritas</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 12%;">Estimasi Biaya</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totalCost = 0; ?>
                <?php foreach ($damages as $damage): ?>
                    <?php
                    if (!empty($damage['estimated_cost'])) {
                        $totalCost += $damage['estimated_cost'];
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= $damage['report_number'] ?></strong></td>
                        <td><?= $damage['item_code'] ?></td>
                        <td><?= substr($damage['item_name'], 0, 25) ?><?= strlen($damage['item_name']) > 25 ? '...' : '' ?></td>
                        <td><?= $damage['user_name'] ?></td>
                        <td><?= ucfirst(str_replace('_', ' ', $damage['damage_type'])) ?></td>
                        <td class="text-center">
                            <span class="badge <?= $damage['priority'] ?>"><?= ucfirst($damage['priority']) ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= $damage['status'] ?>"><?= ucfirst($damage['status']) ?></span>
                        </td>
                        <td class="currency">
                            <?php if (!empty($damage['estimated_cost'])): ?>
                                Rp <?= number_format($damage['estimated_cost'], 0, ',', '.') ?>
                            <?php else: ?>
                                <span style="color: #718096;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Priority Legend -->
    <div class="legend-section">
        <div class="legend-title">KETERANGAN PRIORITAS</div>
        <div class="legend-grid">
            <div class="legend-item">
                <span class="badge low">Low</span>
                <span>Tidak mengganggu operasional</span>
            </div>
            <div class="legend-item">
                <span class="badge medium">Medium</span>
                <span>Sedikit mengganggu operasional</span>
            </div>
            <div class="legend-item">
                <span class="badge high">High</span>
                <span>Mengganggu operasional normal</span>
            </div>
            <div class="legend-item">
                <span class="badge urgent">Urgent</span>
                <span>Butuh penanganan segera</span>
            </div>
        </div>
    </div>

    <!-- Summary Information -->
    <div class="summary-info">
        <div class="summary-row">
            <span>Total Laporan Kerusakan:</span>
            <span><?= count($damages) ?> laporan</span>
        </div>
        <div class="summary-row">
            <span>Laporan Belum Selesai:</span>
            <span><?= count(array_filter($damages, function ($d) {
                        return $d['status'] !== 'resolved';
                    })) ?> laporan</span>
        </div>
        <div class="summary-row">
            <span>Total Estimasi Biaya Perbaikan:</span>
            <span>Rp <?= number_format($totalCost, 0, ',', '.') ?></span>
        </div>
        <div class="summary-row">
            <span>Status Laporan:</span>
            <span>Data Valid per <?= $date ?></span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="notes">
            <strong>Catatan:</strong><br>
            • Laporan ini dibuat secara otomatis oleh sistem<br>
            • Prioritas urgent membutuhkan penanganan segera<br>
            • Estimasi biaya dapat berubah setelah inspeksi detail
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
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>