<?php
// File: app/Views/reports/pdf/users.php
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
            border-bottom: 3px solid #0ea5e9;
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
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
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
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }

        .stat-card.primary {
            border-left: 4px solid #2563eb;
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

        .stat-card.secondary {
            border-left: 4px solid #64748b;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.primary .stat-number {
            color: #2563eb;
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

        .stat-card.secondary .stat-number {
            color: #64748b;
        }

        .stat-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
        }

        .role-breakdown {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .role-breakdown-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e293b;
            font-size: 14px;
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .role-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
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

        .confidential-notice {
            background: #fef3c7;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .confidential-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 5px;
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

    <!-- Confidential Notice -->
    <div class="confidential-notice">
        <div class="confidential-title">🔒 DOKUMEN RAHASIA</div>
        <div>Laporan ini berisi data personal pengguna sistem. Hanya untuk keperluan internal administrasi sekolah. Dilarang menyebarluaskan tanpa izin.</div>
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
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-number"><?= $stats['admin'] ?></div>
            <div class="stat-label">Admin</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-number"><?= $stats['kepsek'] ?></div>
            <div class="stat-label">Kepsek</div>
        </div>
        <div class="stat-card info">
            <div class="stat-number"><?= $stats['user'] ?></div>
            <div class="stat-label">User</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number"><?= $stats['active'] ?></div>
            <div class="stat-label">Aktif</div>
        </div>
        <div class="stat-card secondary">
            <div class="stat-number"><?= $stats['inactive'] ?></div>
            <div class="stat-label">Tidak Aktif</div>
        </div>
    </div>

    <!-- Role Breakdown -->
    <div class="role-breakdown">
        <div class="role-breakdown-title">📊 Distribusi Pengguna Berdasarkan Role</div>
        <div class="role-grid">
            <div class="role-item">
                <span><strong>Administrator:</strong></span>
                <span><?= $stats['admin'] ?> orang (<?= $stats['total'] > 0 ? round(($stats['admin'] / $stats['total']) * 100, 1) : 0 ?>%)</span>
            </div>
            <div class="role-item">
                <span><strong>Kepala Sekolah:</strong></span>
                <span><?= $stats['kepsek'] ?> orang (<?= $stats['total'] > 0 ? round(($stats['kepsek'] / $stats['total']) * 100, 1) : 0 ?>%)</span>
            </div>
            <div class="role-item">
                <span><strong>User Biasa:</strong></span>
                <span><?= $stats['user'] ?> orang (<?= $stats['total'] > 0 ? round(($stats['user'] / $stats['total']) * 100, 1) : 0 ?>%)</span>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-header">👥 Daftar Pengguna Sistem</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Username</th>
                    <th style="width: 25%;">Nama Lengkap</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 10%;">Role</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Tgl Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= $user['username'] ?></strong></td>
                        <td><?= $user['full_name'] ?></td>
                        <td style="font-size: 8px;"><?= $user['email'] ?></td>
                        <td class="text-center">
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge danger">Admin</span>
                            <?php elseif ($user['role'] === 'kepsek'): ?>
                                <span class="badge warning">Kepsek</span>
                            <?php else: ?>
                                <span class="badge info">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($user['status'] === 'active'): ?>
                                <span class="badge success">Aktif</span>
                            <?php else: ?>
                                <span class="badge secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Information -->
    <div class="summary-info">
        <div class="summary-row">
            <span>Total Pengguna Terdaftar:</span>
            <span><?= count($users) ?> pengguna</span>
        </div>
        <div class="summary-row">
            <span>Tingkat Aktivitas:</span>
            <span><?= $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100, 1) : 0 ?>% pengguna aktif</span>
        </div>
        <div class="summary-row">
            <span>Rasio Admin : User:</span>
            <span>1 : <?= $stats['admin'] > 0 ? round($stats['user'] / $stats['admin'], 1) : 0 ?></span>
        </div>
        <div class="summary-row">
            <span>Status Laporan:</span>
            <span>Data Valid per <?= $date ?></span>
        </div>
    </div>

    <!-- Security Notes -->
    <div style="background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; margin-top: 20px; font-size: 10px;">
        <div style="font-weight: bold; margin-bottom: 8px; color: #1e293b;">🔐 Catatan Keamanan:</div>
        <ul style="margin-left: 15px; color: #64748b;">
            <li>Pastikan semua pengguna menggunakan password yang kuat</li>
            <li>Review secara berkala akses pengguna yang tidak aktif</li>
            <li>Administrator memiliki akses penuh ke semua fitur sistem</li>
            <li>Kepala Sekolah memiliki akses khusus untuk laporan dan dashboard</li>
            <li>Lakukan audit rutin untuk memastikan keamanan data</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>
            <div style="font-size: 10px; color: #64748b;">
                <strong>Catatan:</strong><br>
                • Dokumen ini bersifat rahasia dan internal<br>
                • Data personal harus dijaga kerahasiaannya<br>
                • Hanya untuk keperluan administrasi sekolah
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