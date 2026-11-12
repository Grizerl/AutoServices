<?php

namespace App\Models;

use App\Models\Concerns\HasUploadedImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory, HasUploadedImage;

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

    // ------------------------------------------------------------------ accessors

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveImageUrl('assets/images/Car_transport_travel_icon.png'));
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
