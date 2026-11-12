<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory;

    public const PERIOD_MONTHLY = 'monthly';
    public const PERIOD_YEARLY = 'yearly';

    public const PERIODS = [
        self::PERIOD_MONTHLY => 'Monthly',
        self::PERIOD_YEARLY => 'Yearly',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED = 'expired';

    public const STATUSES = [
        self::STATUS_PENDING => 'Pending confirmation',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_EXPIRED => 'Expired',
    ];

    protected $fillable = [
        'reference', 'subscription_plan_id', 'plan_name', 'billing_period', 'price',
        'name', 'phone', 'email', 'car', 'notes', 'status', 'starts_at', 'ends_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'starts_at' => 'date',
            'ends_at' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Subscription $subscription) {
            $subscription->reference ??= static::newReference();
        });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /** Human friendly unique code, e.g. "SUB-7K2QX9MD". */
    public static function newReference(): string
    {
        do {
            $reference = 'SUB-'.strtoupper(Str::random(8));
        } while (static::where('reference', $reference)->exists());

        return $reference;
    }


    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getPeriodLabelAttribute(): string
    {
        return self::PERIODS[$this->billing_period] ?? ucfirst((string) $this->billing_period);
    }

    /** End date for a subscription that starts on $start. */
    public function endDateFrom(Carbon $start): Carbon
    {
        return $this->billing_period === self::PERIOD_YEARLY
            ? $start->copy()->addYearNoOverflow()
            : $start->copy()->addMonthNoOverflow();
    }

    /**
     * Apply an admin status change. Activating fills in the term automatically
     * (starts today, ends after one billing period) unless dates were given.
     */
    public function applyStatus(string $status, ?Carbon $startsAt = null, ?Carbon $endsAt = null): void
    {
        $this->status = $status;

        if ($status === self::STATUS_ACTIVE) {
            $this->starts_at = $startsAt ?? $this->starts_at ?? today();
            $this->ends_at = $endsAt ?? $this->endDateFrom($this->starts_at);
        } elseif ($startsAt || $endsAt) {
            $this->starts_at = $startsAt ?? $this->starts_at;
            $this->ends_at = $endsAt ?? $this->ends_at;
        }

        $this->save();
    }
}
