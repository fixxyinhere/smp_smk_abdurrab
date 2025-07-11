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

        .confidential-notice {
            background: #fffbf0;
            border: 1px solid #fde68a;
            border-left: 3px solid #d69e2e;
            padding: 12px;
            margin-bottom: 25px;
            font-size: 10px;
        }

        .confidential-title {
            font-weight: bold;
            color: #b7791f;
            margin-bottom: 5px;
            font-size: 11px;
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
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .stat-card {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: center;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2d3748;
        }

        .stat-label {
            font-size: 10px;
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-breakdown {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 25px;
        }

        .role-breakdown-title {
            font-weight: 600;
            margin-bottom: 12px;
            color: #2d3748;
            font-size: 13px;
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
            border: 1px solid #e2e8f0;
            font-size: 10px;
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

        .badge.admin {
            border-color: #e53e3e;
            color: #c53030;
        }

        .badge.kepsek {
            border-color: #dd6b20;
            color: #c05621;
        }

        .badge.user {
            border-color: #3182ce;
            color: #2c5282;
        }

        .badge.active {
            border-color: #38a169;
            color: #2f855a;
        }

        .badge.inactive {
            border-color: #718096;
            color: #4a5568;
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

        .security-notes {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-top: 25px;
            font-size: 10px;
        }

        .security-notes-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d3748;
            font-size: 11px;
        }

        .security-notes ul {
            margin-left: 15px;
            color: #718096;
            line-height: 1.4;
        }

        .security-notes li {
            margin-bottom: 3px;
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

    <!-- Confidential Notice -->
    <div class="confidential-notice">
        <div class="confidential-title">DOKUMEN RAHASIA</div>
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
    <div class="stats-section">
        <div class="stats-title">RINGKASAN STATISTIK</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total'] ?></div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['admin'] ?></div>
                <div class="stat-label">Admin</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['kepsek'] ?></div>
                <div class="stat-label">Kepsek</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['user'] ?></div>
                <div class="stat-label">User</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['active'] ?></div>
                <div class="stat-label">Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['inactive'] ?></div>
                <div class="stat-label">Tidak Aktif</div>
            </div>
        </div>
    </div>

    <!-- Role Breakdown -->
    <div class="role-breakdown">
        <div class="role-breakdown-title">DISTRIBUSI PENGGUNA BERDASARKAN ROLE</div>
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
        <div class="table-header">DAFTAR PENGGUNA SISTEM</div>
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
                        <td style="font-size: 9px;"><?= $user['email'] ?></td>
                        <td class="text-center">
                            <span class="badge <?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= $user['status'] === 'active' ? 'active' : 'inactive' ?>">
                                <?= $user['status'] === 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                            </span>
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
    <div class="security-notes">
        <div class="security-notes-title">CATATAN KEAMANAN</div>
        <ul>
            <li>Pastikan semua pengguna menggunakan password yang kuat</li>
            <li>Review secara berkala akses pengguna yang tidak aktif</li>
            <li>Administrator memiliki akses penuh ke semua fitur sistem</li>
            <li>Kepala Sekolah memiliki akses khusus untuk laporan dan dashboard</li>
            <li>Lakukan audit rutin untuk memastikan keamanan data</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="notes">
            <strong>Catatan:</strong><br>
            • Dokumen ini bersifat rahasia dan internal<br>
            • Data personal harus dijaga kerahasiaannya<br>
            • Hanya untuk keperluan administrasi sekolah
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