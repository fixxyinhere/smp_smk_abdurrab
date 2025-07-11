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
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
            margin-bottom: 30px;
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
            background: linear-gradient(135deg, #dc2626, #ef4444);
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

        .stat-card.danger {
            border-left: 4px solid #dc2626;
        }

        .stat-card.warning {
            border-left: 4px solid #ea580c;
        }

        .stat-card.info {
            border-left: 4px solid #0ea5e9;
        }

        .stat-card.success {
            border-left: 4px solid #16a34a;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.danger .stat-number {
            color: #dc2626;
        }

        .stat-card.warning .stat-number {
            color: #ea580c;
        }

        .stat-card.info .stat-number {
            color: #0ea5e9;
        }

        .stat-card.success .stat-number {
            color: #16a34a;
        }

        .stat-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        .urgent-section {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .urgent-title {
            color: #dc2626;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
            padding: 10px 6px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #e2e8f0;
            font-size: 9px;
        }

        td {
            padding: 8px 6px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge.warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge.info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .badge.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge.secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .priority-legend {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-top: 20px;
            font-size: 10px;
        }

        .legend-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .legend-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
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
        <div class="stat-card danger">
            <div class="stat-number"><?= isset($stats['total']) ? $stats['total'] : count($damages) ?></div>
            <div class="stat-label">Total Laporan</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-number"><?= isset($stats['pending']) ? $stats['pending'] : 0 ?></div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card info">
            <div class="stat-number"><?= isset($stats['verified']) ? $stats['verified'] : 0 ?></div>
            <div class="stat-label">Verified</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number"><?= isset($stats['resolved']) ? $stats['resolved'] : 0 ?></div>
            <div class="stat-label">Resolved</div>
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
            <div class="urgent-title">⚠️ LAPORAN PRIORITAS URGENT</div>
            <div style="font-size: 10px;">
                <?php foreach (array_slice($urgentReports, 0, 3) as $urgent): ?>
                    <div style="margin-bottom: 5px;">
                        <strong><?= $urgent['report_number'] ?></strong> - <?= $urgent['item_name'] ?>
                        (<?= ucfirst($urgent['damage_type']) ?>) - Pelapor: <?= $urgent['user_name'] ?>
                    </div>
                <?php endforeach; ?>
                <?php if (count($urgentReports) > 3): ?>
                    <div style="color: #dc2626; font-weight: bold;">
                        Dan <?= count($urgentReports) - 3 ?> laporan urgent lainnya...
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-header">
            🔧 Daftar Laporan Kerusakan
        </div>
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
                            <?php
                            $priorities = [
                                'low' => ['secondary', 'Low'],
                                'medium' => ['info', 'Medium'],
                                'high' => ['warning', 'High'],
                                'urgent' => ['danger', 'Urgent']
                            ];
                            $priority = $priorities[$damage['priority']] ?? ['secondary', 'Unknown'];
                            ?>
                            <span class="badge <?= $priority[0] ?>"><?= $priority[1] ?></span>
                        </td>
                        <td class="text-center">
                            <?php if ($damage['status'] === 'pending'): ?>
                                <span class="badge warning">Pending</span>
                            <?php elseif ($damage['status'] === 'verified'): ?>
                                <span class="badge info">Verified</span>
                            <?php elseif ($damage['status'] === 'approved'): ?>
                                <span class="badge success">Approved</span>
                            <?php elseif ($damage['status'] === 'rejected'): ?>
                                <span class="badge danger">Rejected</span>
                            <?php elseif ($damage['status'] === 'resolved'): ?>
                                <span class="badge success">Resolved</span>
                            <?php else: ?>
                                <span class="badge secondary"><?= ucfirst($damage['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="currency">
                            <?php if (!empty($damage['estimated_cost'])): ?>
                                Rp <?= number_format($damage['estimated_cost'], 0, ',', '.') ?>
                            <?php else: ?>
                                <span style="color: #64748b;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Priority Legend -->
    <div class="priority-legend">
        <div class="legend-title">Keterangan Prioritas:</div>
        <div class="legend-grid">
            <div class="legend-item">
                <span class="badge secondary">Low</span>
                <span>Tidak mengganggu operasional</span>
            </div>
            <div class="legend-item">
                <span class="badge info">Medium</span>
                <span>Sedikit mengganggu operasional</span>
            </div>
            <div class="legend-item">
                <span class="badge warning">High</span>
                <span>Mengganggu operasional normal</span>
            </div>
            <div class="legend-item">
                <span class="badge danger">Urgent</span>
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
        <div>
            <div style="font-size: 10px; color: #64748b;">
                <strong>Catatan:</strong><br>
                • Laporan ini dibuat secara otomatis oleh sistem<br>
                • Prioritas urgent membutuhkan penanganan segera<br>
                • Estimasi biaya dapat berubah setelah inspeksi detail
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