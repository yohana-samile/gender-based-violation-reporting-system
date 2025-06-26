<?php

namespace App\Models\Access\Attribute;
trait RoleAttribute
{

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /*Get Is Administrative label*/
    public function getIsAdminLabelAttribute()
    {
        if ($this->isAdmin()){
            return __('label.yes');
        }else {
            return  __('label.no');
        }
    }

    /*check if is administrative */
    public function isAdmin()
    {
        return $this->isadmin == 1;
    }

    public function checkIfCanBeDeleted() {
        if ($this->users || $this->permissions) {
            return false;
        }
        else{
            return true;
        }
    }
}
