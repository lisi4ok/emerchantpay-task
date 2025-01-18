<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        if (Auth::user()) {
//            static::updating(function($table) {
//                $table->updated_by = Auth::user()->id;
//            });

            static::saving(function($table) {
                $table->created_by = Auth::user()->id;
            });
        }
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //'type' => TransactionTypeEnum::class,
            'amount' => 'decimal:2',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id','id', 'users');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id', 'users');
    }
}
