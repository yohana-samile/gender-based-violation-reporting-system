<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param $param1
     * @param $param2
     * @throws GeneralException
     * Check if owner by comparing parameters
     */
    public function checkIfIsOwnerGeneral($param1, $param2)
    {
        try {
            if ($param1 == $param2) {
                //ok
            } else {
                //not owner
                throw new GeneralException(__('exceptions.general.owner_restriction'));
            }

        } catch (\Exception $exception) {
            throw new GeneralException(__('exceptions.general.owner_restriction'));
        }
    }
}
