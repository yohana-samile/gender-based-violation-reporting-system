<?php

namespace App\Http\Controllers\Gbv\Audit;

use App\Http\Controllers\Controller;
use App\Repositories\Audit\AuditRepository;
use Illuminate\Support\Facades\DB;

class AuditController extends  Controller
{
    protected $audit_repo;

    public function __construct() {
        $this->audit_repo = new AuditRepository();
        $this->middleware('access.routeNeedsPermission:manage_role_and_permissions,all_functions', [
            'only' => ['index', 'profile', 'getAllForDt']
        ]);
    }

    public function index() {
        return view('pages.audit.index');
    }

    public function profile($audit) {
        $audits = DB::table('audits')
            ->leftJoin('users', 'audits.user_id', '=', 'users.id')
            ->select('audits.*',
                DB::raw("CASE
                    WHEN audits.user_type = 'App\Models\User' THEN users.email
                    ELSE 'Guest User'
                END as user_email")
            )->where('audits.id', $audit)->first();

        $audits->new_values = json_decode($audits->new_values ?? '{}', true);
        $audits->old_values = json_decode($audits->old_values ?? '{}', true);
        return view('pages.audit.profile.profile', [
            'audits' => $audits,
        ]);
    }

    public function getAllForDt() {
        return response(['data' => $this->audit_repo->getAllForDt()]);
    }
}
