<?php

namespace App\Models\Access\Attribute;
use App\Models\Access\User;
use Carbon\Carbon;

trait UserAttribute
{

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

    public function getCreatedAtFormattedAttribute()
    {
        return  Carbon::parse($this->created_at)->format('d-M-Y');
    }

    public function getLastLoginFormattedAttribute()
    {
        return  Carbon::parse($this->last_login)->format('d-M-Y');
    }


    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed == 1;
    }

    public function getOtpConfirmedFormattedAttribute()
    {
        return sysdef()->data('OTPVERIF') ?  $this->otp_confirmed : true;
    }

    /*Check if can manage project*/
    public function checkIspm($project)
    {
        $team = $project->teams()->where('user_id', $this->id)->first();
        if($team){
            if ($team->pivot->ispm == 1 || $team->pivot->can_manage_project == 1) {
                return true;
            }
        }

        return false;
    }

    /* Active status label*/
    public function getActiveStatusLabelAttribute()
    {
        if ($this->isactive == 1) {
            return "<span class='badge badge-pill badge-success' data-toggle='tooltip' data-html='true' title='" . trans('label.active') . "'>" . trans('label.active') . "</span>";
        } else {
            return "<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-html='true' title='" . trans('label.inactive') . "'>" . trans('label.inactive') . "</span>";
        }
    }

    /*Get Roles of the users*/

    public function getRoleLabelAttribute() {
        $roles = [];
        if ($this->roles()->count() > 0) {
            foreach ($this->roles as $role) {
                array_push($roles, $role->name);
            }
            return implode(", ", $roles);
        } else {
            return '<span class="tag tag-danger">'. trans('label.none') . '</span>';
        }
    }
}
