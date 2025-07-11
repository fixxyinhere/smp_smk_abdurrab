<?php
// File: app/Views/reports/pdf/loans.php
?>
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
            border-bottom: 3px solid #ea580c;
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
            background: linear-gradient(135deg, #ea580c, #f97316);
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
        }

        .stat-card.primary {
            border-left: 4px solid #2563eb;
        }

        .stat-card.warning {
            border-left: 4px solid #ea580c;
        }

        .stat-card.success {
            border-left: 4px solid #16a34a;
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

        .stat-card.warning .stat-number {
            color: #ea580c;
        }

        .stat-card.success .stat-number {
            color: #16a34a;
        }

        .stat-card.danger .stat-number {
            color: #dc2626;
        }

        .stat-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        .overdue-section {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .overdue-title {
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

        tr.overdue {
            background: #fef2f2 !important;
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

        .badge.primary {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .badge.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
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
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-number"><?= $stats['total'] ?></div>
            <div class="stat-label">Total Pinjaman</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-number"><?= $stats['active'] ?></div>
            <div class="stat-label">Aktif</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number"><?= $stats['returned'] ?></div>
            <div class="stat-label">Dikembalikan</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-number">
                <?php
                $overdueCount = 0;
                foreach ($loans as $loan) {
                    if ($loan['status'] === 'active' && $loan['return_date'] < date('Y-m-d')) {
                        $overdueCount++;
                    }
                }
                echo $overdueCount;
                ?>
            </div>
            <div class="stat-label">Terlambat</div>
        </div>
    </div>

    <!-- Overdue Loans Section -->
    <?php
    $overdueLoans = array_filter($loans, function ($loan) {
        return $loan['status'] === 'active' && $loan['return_date'] < date('Y-m-d');
    });
    ?>
    <?php if (!empty($overdueLoans)): ?>
        <div class="overdue-section">
            <div class="overdue-title">⚠️ PINJAMAN TERLAMBAT</div>
            <div style="font-size: 10px;">
                <?php foreach (array_slice($overdueLoans, 0, 5) as $overdue): ?>
                    <?php
                    $returnDate = new DateTime($overdue['return_date']);
                    $today = new DateTime();
                    $diff = $today->diff($returnDate);
                    ?>
                    <div style="margin-bottom: 5px;">
                        <strong><?= $overdue['loan_number'] ?></strong> - <?= $overdue['user_name'] ?>
                        (Terlambat <?= $diff->days ?> hari) - Seharusnya kembali: <?= date('d/m/Y', strtotime($overdue['return_date'])) ?>
                    </div>
                <?php endforeach; ?>
                <?php if (count($overdueLoans) > 5): ?>
                    <div style="color: #dc2626; font-weight: bold;">
                        Dan <?= count($overdueLoans) - 5 ?> pinjaman terlambat lainnya...
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-header">🤝 Daftar Pinjaman Sarana Prasarana</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">No. Pinjaman</th>
                    <th style="width: 20%;">Peminjam</th>
                    <th style="width: 12%;">Tgl Pinjam</th>
                    <th style="width: 12%;">Tgl Kembali</th>
                    <th style="width: 12%;">Tgl Dikembalikan</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 12%;">Hari Pinjam</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($loans as $loan): ?>
                    <?php
                    $isOverdue = $loan['status'] === 'active' && $loan['return_date'] < date('Y-m-d');
                    $loanDate = new DateTime($loan['loan_date']);
                    $returnDate = $loan['actual_return_date'] ?
                        new DateTime($loan['actual_return_date']) :
                        new DateTime($loan['return_date']);
                    $daysDiff = $loanDate->diff($returnDate)->days;
                    ?>
                    <tr <?= $isOverdue ? 'class="overdue"' : '' ?>>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= $loan['loan_number'] ?></strong></td>
                        <td><?= $loan['user_name'] ?></td>
                        <td><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($loan['return_date'])) ?></td>
                        <td><?= $loan['actual_return_date'] ? date('d/m/Y', strtotime($loan['actual_return_date'])) : '-' ?></td>
                        <td class="text-center">
                            <?php if ($loan['status'] === 'active'): ?>
                                <?php if ($isOverdue): ?>
                                    <span class="badge danger">Terlambat</span>
                                <?php else: ?>
                                    <span class="badge primary">Aktif</span>
                                <?php endif; ?>
                            <?php elseif ($loan['status'] === 'returned'): ?>
                                <span class="badge success">Dikembalikan</span>
                            <?php else: ?>
                                <span class="badge warning">Overdue</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= $loan['status'] === 'returned' ? $daysDiff : '-' ?> hari
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Information -->
    <div class="summary-info">
        <div class="summary-row">
            <span>Total Pinjaman:</span>
            <span><?= count($loans) ?> pinjaman</span>
        </div>
        <div class="summary-row">
            <span>Tingkat Pengembalian:</span>
            <span><?= $stats['total'] > 0 ? round(($stats['returned'] / $stats['total']) * 100, 1) : 0 ?>%</span>
        </div>
        <div class="summary-row">
            <span>Pinjaman Belum Dikembalikan:</span>
            <span><?= $stats['active'] ?> pinjaman</span>
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
                • Pinjaman terlambat perlu ditindaklanjuti segera<br>
                • Koordinasi dengan peminjam untuk pengembalian
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
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>