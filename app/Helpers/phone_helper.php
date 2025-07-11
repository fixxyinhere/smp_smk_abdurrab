<?php
function formatPhoneNumber($phone)
{
    if (empty($phone)) {
        return '';
    }

    // Remove semua karakter non-digit
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // Jika dimulai dengan 08, ganti dengan +628
    if (substr($phone, 0, 2) === '08') {
        return '+62' . substr($phone, 1);
    }

    // Jika dimulai dengan 8, tambah +62
    if (substr($phone, 0, 1) === '8') {
        return '+62' . $phone;
    }

    // Default: anggap nomor Indonesia dan tambah +62
    return '+62' . ltrim($phone, '0');
}

function formatWhatsAppNumber($phone)
{
    $formatted = formatPhoneNumber($phone);
    return str_replace('+', '', $formatted);
}
