<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    /** Font Awesome icons an admin can pick for a plan. */
    public const ICONS = [
        'fa-snowflake' => 'Snowflake',
        'fa-bolt' => 'Bolt',
        'fa-star' => 'Star',
        'fa-crown' => 'Crown',
        'fa-gem' => 'Gem',
        'fa-shield-halved' => 'Shield',
        'fa-wrench' => 'Wrench',
    ];

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'price_monthly', 'price_yearly',
        'features', 'excluded_features', 'is_popular', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'price_monthly' => 'integer',
            'price_yearly' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('price_monthly');
    }

    // ------------------------------------------------------------------ pricing

    /** Yearly price: the explicit one, or 12 x monthly when not set. */
    protected function effectiveYearlyPrice(): Attribute
    {
        return Attribute::get(fn () => $this->price_yearly ?: $this->price_monthly * 12);
    }

    /** Percent saved by paying yearly instead of 12 monthly payments. */
    protected function yearlySavingPercent(): Attribute
    {
        return Attribute::get(function () {
            $full = $this->price_monthly * 12;

            return $full > 0 && $this->effective_yearly_price < $full
                ? (int) round((1 - $this->effective_yearly_price / $full) * 100)
                : 0;
        });
    }

    /** Price for the given billing period ("monthly" | "yearly"). */
    public function priceFor(string $period): int
    {
        return $period === Subscription::PERIOD_YEARLY ? $this->effective_yearly_price : $this->price_monthly;
    }

    // ------------------------------------------------------------------ feature lists

    /** @return list<string> */
    protected function featureList(): Attribute
    {
        return Attribute::get(fn () => self::lines($this->features));
    }

    /** @return list<string> */
    protected function excludedList(): Attribute
    {
        return Attribute::get(fn () => self::lines($this->excluded_features));
    }

    /** Split a "one item per line" text into clean items. */
    public static function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text) ?: [])));
    }
}
