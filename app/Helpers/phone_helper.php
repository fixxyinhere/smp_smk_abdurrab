<?php
// File: app/Helpers/phone_helper.php (Updated to match existing format)

if (!function_exists('formatPhoneNumber')) {
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
}

if (!function_exists('formatWhatsAppNumber')) {
    function formatWhatsAppNumber($phone)
    {
        $formatted = formatPhoneNumber($phone);
        return str_replace('+', '', $formatted);
    }
}

if (!function_exists('validateIndonesianPhone')) {
    /**
     * Validate Indonesian phone number format
     * 
     * @param string $phone
     * @return bool
     */
    function validateIndonesianPhone($phone)
    {
        if (empty($phone)) {
            return false;
        }

        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Check if it's a valid Indonesian mobile number
        // Indonesian mobile numbers start with 08 and have 10-13 digits total
        if (preg_match('/^08[0-9]{8,11}$/', $phone)) {
            return true;
        }

        // Also accept format starting with 8 (without 0)
        if (preg_match('/^8[0-9]{8,11}$/', $phone)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('displayPhoneNumber')) {
    /**
     * Display phone number in a user-friendly format
     * 
     * @param string $phone
     * @return string
     */
    function displayPhoneNumber($phone)
    {
        if (empty($phone)) {
            return '-';
        }

        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Format as 08XX-XXXX-XXXX for display
        if (substr($phone, 0, 2) === '08' && strlen($phone) >= 10) {
            $formatted = substr($phone, 0, 4) . '-' .
                substr($phone, 4, 4) . '-' .
                substr($phone, 8);
            return $formatted;
        }

        return $phone;
    }
}
