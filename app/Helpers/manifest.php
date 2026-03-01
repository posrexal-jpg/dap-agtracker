<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('vite_manifest')) {
    function vite_manifest(): array
    {
        static $manifest = null;

        if ($manifest !== null) {
            return $manifest;
        }

        $path = public_path('build/manifest.json');

        if (!file_exists($path)) {
            $manifest = [];
            return $manifest;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            $manifest = [];
            return $manifest;
        }

        $manifest = $data;
        return $manifest;
    }
}

if (!function_exists('manifest_asset')) {
    function manifest_asset(string $entry): string
    {
        $manifest = vite_manifest();

        if (isset($manifest[$entry]) && isset($manifest[$entry]['file'])) {
            return asset('build/' . ltrim($manifest[$entry]['file'], '/'));
        }

        // Fallback to asset() on the given path
        return asset($entry);
    }
}

if (!function_exists('manifest_styles')) {
    /**
     * Return HTML <link> tags for given manifest entries.
     * Use in Blade with: {!! manifest_styles(['resources/css/app.css']) !!}
     */
    function manifest_styles(array $entries): string
    {
        $html = '';
        foreach ($entries as $entry) {
            $href = manifest_asset($entry);
            $html .= '<link rel="stylesheet" href="' . $href . '">' . PHP_EOL;
        }
        return $html;
    }
}

if (!function_exists('manifest_scripts')) {
    /**
     * Return HTML <script> tags for given manifest entries.
     * Use in Blade with: {!! manifest_scripts(['resources/js/app.js']) !!}
     */
    function manifest_scripts(array $entries): string
    {
        $html = '';
        foreach ($entries as $entry) {
            $src = manifest_asset($entry);
            $html .= '<script src="' . $src . '" defer></script>' . PHP_EOL;
        }
        return $html;
    }
}
