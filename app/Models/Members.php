<?php

namespace App\Models;

use App\Models\Concerns\HasUploadedImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory, HasUploadedImage;

    public const IMAGE_COLUMN = 'img';
    public const IMAGE_DISK = 'uploads';
    public const IMAGE_DIRECTORY = 'members';

    protected $fillable = ['name', 'phone_number', 'age', 'img', 'place_of_residence', 'role'];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveImageUrl('assets/dist/img/avatar.png'));
    }
}
