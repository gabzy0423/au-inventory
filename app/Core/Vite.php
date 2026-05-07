<?php

namespace App\Core;

class Vite
{
    private static $manifest = null;

    public static function tags($entry)
    {
        // For development (assuming npm run dev is running)
        // We check if we can connect to the vite server or use a dev flag
        if (self::isDev()) {
            return '
                <script type="module" src="http://localhost:5174/@vite/client"></script>
                <script type="module" src="http://localhost:5174/' . ltrim($entry, '/') . '"></script>
            ';
        }

        // For production (loading from manifest.json)
        return self::productionTags($entry);
    }

    private static function isDev()
    {
        // Simple check: if manifestation file doesn't exist, assume dev
        $manifestPath = __DIR__ . '/../../public/build/.vite/manifest.json';
        return !file_exists($manifestPath);
    }

    private static function productionTags($entry)
    {
        if (self::$manifest === null) {
            $path = __DIR__ . '/../../public/build/.vite/manifest.json';
            if (file_exists($path)) {
                self::$manifest = json_decode(file_get_contents($path), true);
            }
        }

        if (self::$manifest && isset(self::$manifest[$entry])) {
            $file = self::$manifest[$entry]['file'];
            $css = self::$manifest[$entry]['css'] ?? [];
            
            $tags = '';
            foreach ($css as $style) {
                $tags .= '<link rel="stylesheet" href="/au_inventory/public/build/' . $style . '">';
            }
            $tags .= '<script type="module" src="/au_inventory/public/build/' . $file . '"></script>';
            return $tags;
        }

        return '';
    }
}
