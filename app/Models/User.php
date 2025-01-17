<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Interfaces\ImageInterface;
use App\Traits\Imageable;

//use App\Interfaces\HasImageInterface;
//use App\Traits\HasImage;

class User extends Authenticatable implements ImageInterface // MustVerifyEmail, HasImageInterface
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug, Imageable; //, HasImage;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'description',
        'amount',
        'role',
        'status',
        'email_verified_at',
        'remember_token',
    ];

//    protected $appends = [
//        'image_url',
//        'default_image_url',
//    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected ?Collection $permissions;

    protected static function boot()
    {
        parent::boot();

        if (!Auth::user()) {
            return;
        }

        static::updating(function($table) {
            $table->updated_by = Auth::user()->id;
        });

        static::saving(function($table) {
            $table->created_by = Auth::user()->id;
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatusEnum::class,
            'amount' => 'decimal:2',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        // return SlugOptions::createWithLocales(array_keys(config('app`.available_locales')))
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingLanguage(config('app.locale'));
    }

    public function activeScope()  {

    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles',
            'user_id', 'role_id')->with('permissions');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', UserStatusEnum::ACTIVE->value);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('status', UserStatusEnum::INACTIVE->value);
    }

    public function scopePermissions(Builder $query): void
    {
        $query->select(['permissions.id', 'permissions.name'])
              ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
              ->join('roles_permissions', 'users_roles.role_id', '=', 'roles_permissions.role_id')
              ->join('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
              ->groupBy(['permissions.id']);
    }

    public function getPermissionsAttribute()
    {
        if (empty($this->permissions)) {
            $this->permissions = $this->permissions()->pluck('name','id');
        }

        return $this->permissions;
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id', 'users');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id', 'users');
    }


}
