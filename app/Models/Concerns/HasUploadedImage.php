<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Shared handling of an uploaded photo for models.
 *
 * The using model defines:
 *   IMAGE_COLUMN     attribute that stores the path
 *   IMAGE_DIRECTORY  folder on the uploads disk (e.g. "cars")
 *   IMAGE_DISK       filesystem disk (the "uploads" disk lives in /public/uploads)
 *
 * Stored values can be:
 *   "<IMAGE_DIRECTORY>/xxx.jpg"  an upload made through the admin panel
 *   "assets/..."                 a bundled demo image under /public/assets
 *   "http(s)://..."              a legacy external link (still rendered, never deleted)
 */
trait HasUploadedImage
{
    /** Public URL of the stored image, or the given fallback asset. */
    protected function resolveImageUrl(string $fallbackAsset): string
    {
        $path = (string) $this->{static::IMAGE_COLUMN};

        if ($path === '') {
            return asset($fallbackAsset);
        }

        if (Str::startsWith($path, static::IMAGE_DIRECTORY.'/')) {
            return Storage::disk(static::IMAGE_DISK)->url($path);
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    /** Remove the uploaded file (bundled demo files and legacy links are left alone). */
    public function deleteImageFile(): void
    {
        $path = (string) $this->{static::IMAGE_COLUMN};

        if (Str::startsWith($path, static::IMAGE_DIRECTORY.'/')) {
            Storage::disk(static::IMAGE_DISK)->delete($path);
        }
    }
}
