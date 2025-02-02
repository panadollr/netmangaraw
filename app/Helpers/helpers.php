<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Rút gọn chuỗi string.
 *
 * @param string $string
 * @param int $limit
 * @return string
 */
if (! function_exists('limitString')) {
    function limitString($string, $limit)
    {
        return Str::limit($string, $limit);
    }
}

/**
 * Get a human-readable time difference with optional locale.
 *
 * @param string|Carbon $dateTime
 * @param string|null $locale
 * @param bool $short
 * @return string
 */
if (!function_exists('diffForHumans')) {
    function diffForHumans($dateTime, ?string $locale = null, bool $short = false): string
    {
        $locale = $locale ?? app()->getLocale();
        return Carbon::parse($dateTime)
            ->locale($locale)
            ->diffForHumans(['short' => $short]) ?: '-';
    }
}

/**
 * Initialize and configure a CURL request.
 *
 * @param string $url
 * @param int $timeout
 * @param int $connectTimeout
 * @return string|null
 */
function fetchCurlResponse(string $url, int $timeout = 200, int $connectTimeout = 200): ?string
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_CONNECTTIMEOUT => $connectTimeout,
        CURLOPT_TCP_KEEPALIVE => true,
        CURLOPT_TCP_KEEPIDLE => 120,
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return null;  // Return null if there’s an error.
    }

    curl_close($ch);
    return $response ?: null;  // Return null if no response.
}

/**
 * Fetch HTML content from a URL without using a proxy.
 *
 * @param string $url
 * @param int $timeout
 * @param int $connectTimeout
 * @return string|null
 */
function fetchHtml(string $url, int $timeout = 200, int $connectTimeout = 200): ?string
{
    return fetchCurlResponse($url, $timeout, $connectTimeout);
}

/**
 * Fetch JSON content from a URL without using a proxy.
 *
 * @param string $url
 * @param int $timeout
 * @param int $connectTimeout
 * @return mixed|null
 */
function fetchJsonResponse(string $url, int $timeout = 200, int $connectTimeout = 200)
{
    $response = fetchCurlResponse($url, $timeout, $connectTimeout);

    if ($response === null) {
        return null;
    }

    // Attempt to decode JSON response
    $jsonResponse = json_decode($response, true);

    // Return the decoded array if valid, otherwise return null
    return $jsonResponse !== null ? $jsonResponse : null;
}

/**
 * Format a date to 'dd/mm/yyyy' with optional locale.
 *
 * @param string|Carbon|null $date
 * @param string $locale
 * @return string|null
 */
if (!function_exists('formatDate')) {
    function formatDate($date, string $locale = 'vi'): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)
            ->locale($locale)
            ->isoFormat('DD/MM/YYYY');
    }
}

/**
 * Format views count into a readable format (e.g., 1.2k, 1.2M).
 *
 * @param int|null $views
 * @return string|null
 */
if (!function_exists('formatViews')) {
    function formatViews(?int $views): ?string
    {
        if ($views === null) {
            return null;
        }

        if ($views >= 1_000_000_000) {
            return number_format($views / 1_000_000_000, 1) . 'B';
        }

        if ($views >= 1_000_000) {
            return number_format($views / 1_000_000, 1) . 'M';
        }

        if ($views >= 1_000) {
            return number_format($views / 1_000, 1) . 'k';
        }

        return (string)number_format($views);
    }
}
