<?php

namespace App\Models;

use App\Models\Concerns\HasUploadedImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Car extends Model implements HasMedia
{
    use HasFactory, HasUploadedImage, InteractsWithMedia;

    /** Spatie Media Library collection that holds the car photo. */
    public const PHOTO = 'photo';

    public const FALLBACK_IMAGE = 'assets/images/Car_transport_travel_icon.png';

    public const IMAGE_COLUMN = 'image';
    public const IMAGE_DISK = 'uploads';
    public const IMAGE_DIRECTORY = 'cars';

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_SOLD = 'sold';

    public const STATUSES = [
        self::STATUS_AVAILABLE => 'Available',
        self::STATUS_RESERVED => 'Reserved',
        self::STATUS_SOLD => 'Sold',
    ];

    public const FUELS = [
        'petrol' => 'Petrol',
        'diesel' => 'Diesel',
        'hybrid' => 'Hybrid',
        'electric' => 'Electric',
        'lpg' => 'LPG / Gas',
    ];

    public const TRANSMISSIONS = [
        'manual' => 'Manual',
        'automatic' => 'Automatic',
    ];

    public const SORTS = [
        'newest' => 'Newest first',
        'price_asc' => 'Price: low to high',
        'price_desc' => 'Price: high to low',
        'year_desc' => 'Year: newest',
        'mileage_asc' => 'Mileage: lowest',
    ];

    protected $fillable = [
        'brand', 'model', 'year', 'mileage', 'price', 'old_price', 'fuel', 'transmission',
        'color', 'description', 'image', 'status', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'year' => 'integer',
            'mileage' => 'integer',
            'price' => 'integer',
            'old_price' => 'integer',
        ];
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(CarInquiry::class);
    }

    // ------------------------------------------------------------------ photo (Spatie Media Library)

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PHOTO)
            ->singleFile() // a new upload replaces the old photo together with its conversions
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // exact 4:3 card thumbnail: scaled to fill and cropped, never stretched
        $this->addMediaConversion('thumb')
            ->performOnCollections(self::PHOTO)
            ->fit(Fit::Crop, 640, 480)
            ->quality(82)
            ->nonQueued();

        // web-sized copy for the car page: keeps the original proportions
        $this->addMediaConversion('large')
            ->performOnCollections(self::PHOTO)
            ->fit(Fit::Max, 1400, 1050)
            ->quality(85)
            ->nonQueued();
    }

    // ------------------------------------------------------------------ accessors

    /**
     * Original photo. Cars created before the media library keep working through
     * the legacy "image" column (old uploads, bundled demo images, external links).
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl(self::PHOTO) ?: $this->resolveImageUrl(self::FALLBACK_IMAGE));
    }

    /** 640x480 thumbnail for cards and lists (never the full-size original). */
    protected function thumbUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl(self::PHOTO, 'thumb') ?: $this->resolveImageUrl(self::FALLBACK_IMAGE));
    }

    /** Web-sized copy (max 1400px, original proportions) for the car page. */
    protected function largeUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl(self::PHOTO, 'large') ?: $this->resolveImageUrl(self::FALLBACK_IMAGE));
    }

    protected function title(): Attribute
    {
        return Attribute::get(fn () => trim("{$this->brand} {$this->model}"));
    }

    protected function fuelLabel(): Attribute
    {
        return Attribute::get(fn () => self::FUELS[$this->fuel] ?? ucfirst((string) $this->fuel));
    }

    protected function transmissionLabel(): Attribute
    {
        return Attribute::get(fn () => self::TRANSMISSIONS[$this->transmission] ?? ucfirst((string) $this->transmission));
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUSES[$this->status] ?? ucfirst((string) $this->status));
    }

    /** Discount in percent when an old (higher) price is set. */
    protected function discountPercent(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->old_price || $this->old_price <= $this->price) {
                return null;
            }

            return (int) round((1 - $this->price / $this->old_price) * 100);
        });
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    // ------------------------------------------------------------------ scopes

    /**
     * Apply the catalog filters from the query string.
     *
     * @param  array{q?:?string,brand?:?string,fuel?:?string,transmission?:?string,max_price?:?int|string,status?:?string,sort?:?string}  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['q'] ?? null, function (Builder $q, string $term) {
                $q->where(function (Builder $w) use ($term) {
                    $like = '%'.addcslashes($term, '%_\\').'%';
                    $w->where('brand', 'like', $like)->orWhere('model', 'like', $like);
                });
            })
            ->when($filters['brand'] ?? null, fn (Builder $q, string $v) => $q->where('brand', $v))
            ->when($filters['fuel'] ?? null, fn (Builder $q, string $v) => $q->where('fuel', $v))
            ->when($filters['transmission'] ?? null, fn (Builder $q, string $v) => $q->where('transmission', $v))
            ->when($filters['max_price'] ?? null, fn (Builder $q, $v) => $q->where('price', '<=', (int) $v))
            ->when(($filters['status'] ?? null) === 'available', fn (Builder $q) => $q->where('status', self::STATUS_AVAILABLE));
    }

    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'year_desc' => $query->orderByDesc('year'),
            'mileage_asc' => $query->orderBy('mileage'),
            // available cars first, then reserved, sold last; newest first inside each group
            default => $query
                ->orderByRaw("case status when 'available' then 0 when 'reserved' then 1 else 2 end")
                ->orderByDesc('id'),
        };
    }
}
