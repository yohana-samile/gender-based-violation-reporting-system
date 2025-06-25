<?php

namespace App\Models\System\Attribute;

use App\Repositories\Business\OfferRepository;
use App\Repositories\Business\TenderRepository;
use App\Repositories\Operation\Sales\ClientDiscountRepository;
use Carbon\Carbon;

trait CodeValueAttribute
{




    /**
     * @return string
     * Is Active attribute
     */
    public function getActiveAttribute()
    {
        if ($this->is_active()){
            return __('label.yes');
        }else {
            return  __('label.no');
        }

    }

    /**
     * @return string
     * is Mandatory attribute
     */
    public function getMandatoryAttribute()
    {
        if ($this->is_mandatory()){
            return __('label.yes');
        }else {
            return  __('label.no');
        }

    }


    /*
 *SYstem defined label
 *
 */
    public function getSystemDefinedAttribute()
    {
        if ($this->systemDefined()){
            return __('label.yes');
        }else {
            return  __('label.no');
        }
    }


//    Flags
    public function systemDefined() {
        return $this->is_system_defined == 1;
    }



    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if (!$this->systemDefined()) {
            return '<a href="' . route('code.value.edit', $this->id) . '"  class="btn btn-xs btn-primary" ><i class="icon fa fa-edit" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i>'.' '. trans('buttons.general.crud.edit').'</a> ';
        }
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return  $this->getEditButtonAttribute();

    }

    /*Mandatory*/
    public function is_mandatory(){
        return $this->is_mandatory == 1;
    }

    /*Is Active flag*/
    public function is_active(){
        return $this->isactive == 1;
    }

    public static function getIncidentStatus($codeId)
    {
        return self::query()->where('code_id', $codeId)->get();
    }

    public static function getIncidentType($codeId)
    {
        return self::query()->where('code_id', $codeId)->get();
    }

    public static function getIncidentGender($codeId)
    {
        return self::query()->where('code_id', $codeId)->get();
    }
    public static function getIncidentVulnerabilities($codeId)
    {
        return self::query()->where('code_id', $codeId)->get();
    }

}
