<?php

namespace Redooor\Redminstore\App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;

class StorefrontAssets
{
    public static function tags(): HtmlString
    {
        if ($hotTags = self::hotTags()) {
            return new HtmlString($hotTags);
        }

        $manifest = self::manifest();

        if (! $manifest || ! isset($manifest['src/resources/js/app.js'])) {
            return new HtmlString('');
        }

        $entry = $manifest['src/resources/js/app.js'];
        $tags = [];

        foreach ($entry['css'] ?? [] as $css) {
            $tags[] = '<link rel="stylesheet" href="' . e(self::assetUrl($css)) . '">';
        }

        $tags[] = '<script type="module" src="' . e(self::assetUrl($entry['file'])) . '"></script>';

        return new HtmlString(implode(PHP_EOL, $tags));
    }

    private static function hotTags(): ?string
    {
        $hotFile = __DIR__ . '/../../public/hot';

        if (! File::exists($hotFile)) {
            return null;
        }

        $url = rtrim(trim(File::get($hotFile)), '/');

        return implode(PHP_EOL, [
            '<script type="module" src="' . e($url . '/@vite/client') . '"></script>',
            '<script type="module" src="' . e($url . '/src/resources/js/app.js') . '"></script>',
        ]);
    }

    private static function manifest(): ?array
    {
        $candidates = [
            public_path('vendor/redooor/redminstore/build/.vite/manifest.json'),
            public_path('vendor/redooor/redminstore/build/manifest.json'),
            __DIR__ . '/../../public/build/.vite/manifest.json',
            __DIR__ . '/../../public/build/manifest.json',
        ];

        $path = collect($candidates)->first(fn (string $candidate) => File::exists($candidate));

        if (! $path) {
            return null;
        }

        return json_decode(File::get($path), true);
    }

    private static function assetUrl(string $path): string
    {
        if (File::exists(public_path('vendor/redooor/redminstore/build/' . $path))) {
            return asset('vendor/redooor/redminstore/build/' . $path);
        }

        return asset('vendor/redooor/redminstore/build/' . $path);
    }
}
