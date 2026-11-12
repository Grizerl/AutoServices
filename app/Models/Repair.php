<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_IN_PROGRESS => 'In progress',
        self::STATUS_COMPLETED => 'Completed',
    ];

    protected $table = 'repairs';

    protected $fillable = ['name', 'telephone', 'car', 'comment', 'price', 'done'];

    protected $attributes = [
        'done' => self::STATUS_PENDING,
        'price' => 0,
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->done] ?? ucfirst((string) $this->done);
    }
}
