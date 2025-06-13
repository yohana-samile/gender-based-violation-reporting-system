<?php
    namespace App\Models\Access;
    use App\Models\Access\Attribute\UserAttribute;
    use App\Models\Access\Relationship\UserRelationship;
    use App\Traits\HasProfilePhoto;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use OwenIt\Auditing\Auditable;
    use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
    use PragmaRX\Google2FAQRCode\Google2FA;

    class User extends Authenticatable implements AuditableContract {
        use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UserRelationship, UserAttribute, UserAccess, HasProfilePhoto, Auditable;
        protected $guarded = ['id'];

        protected static function booted()
        {
            static::creating(function ($user) {
                $user->uid = str_unique();
            });
        }

        public static function getUserIdByUid($uid)
        {
            return self::query()->where('uid', $uid)->first();
        }

        public static function getUserIdById($id)
        {
            return self::query()->where('id', $id)->first();
        }

        public static function getUserIdByEmail($email)
        {
            return User::query()->where('email', $email)->first();
        }

        public function twoFactorQrCodeSvg()
        {
            $google2fa = new Google2FA();
            return $google2fa->getQRCodeInline(
                config('app.name'),
                $this->email,
                decrypt($this->two_factor_secret)
            );
        }

        protected $hidden = [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ];

        /**
         * The accessors to append to the model's array form.
         *
         * @var array<int, string>
         */
        protected $appends = [
            'profile_photo_url',
        ];

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
            ];
        }
    }

