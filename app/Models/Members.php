<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Members extends Model
{
    use HasFactory;

    /** Disk and folder for uploaded member photos. */
    public const IMAGE_DISK = 'uploads';
    public const IMAGE_DIRECTORY = 'members';

    protected $fillable = ['name', 'phone_number', 'age', 'img', 'place_of_residence', 'role'];

    /**
     * Public URL of the member photo.
     *
     * - "members/xxx.jpg"  uploaded through the admin panel (uploads disk)
     * - "assets/..."       bundled demo photos under /public/assets
     * - "http(s)://..."    legacy rows that stored an external link
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            $path = (string) $this->img;

            if ($path === '') {
                return asset('assets/dist/img/avatar.png');
            }

            if (Str::startsWith($path, self::IMAGE_DIRECTORY.'/')) {
                return Storage::disk(self::IMAGE_DISK)->url($path);
            }

            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            return asset(ltrim($path, '/'));
        });
    }

    /** Remove the stored upload (never touches bundled demo files or legacy links). */
    public function deleteImageFile(): void
    {
        if (Str::startsWith((string) $this->img, self::IMAGE_DIRECTORY.'/')) {
            Storage::disk(self::IMAGE_DISK)->delete($this->img);
        }
    }
}
