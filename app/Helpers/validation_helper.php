<?php
// File: app/Helpers/validation_helper.php

if (!function_exists('custom_validation_errors')) {
    function custom_validation_errors($errors)
    {
        $output = '<div class="alert alert-danger"><ul class="mb-0">';
        foreach ($errors as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        $output .= '</ul></div>';
        return $output;
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('format_date_indo')) {
    function format_date_indo($date)
    {
        if (!$date) return '-';

        $months = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $timestamp = strtotime($date);
        $day = date('d', $timestamp);
        $month = $months[date('n', $timestamp)];
        $year = date('Y', $timestamp);

        return $day . ' ' . $month . ' ' . $year;
    }
}
