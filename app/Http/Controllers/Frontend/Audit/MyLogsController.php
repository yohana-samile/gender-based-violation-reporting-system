<?php

    namespace App\Http\Controllers\Frontend\Audit;
    use App\Http\Controllers\Controller;
    use App\Repositories\Audit\AuditRepository;
    use Illuminate\Support\Facades\DB;

    class MyLogsController extends  Controller {
        protected $audit_repo;

        public function __construct() {
            $this->audit_repo = new AuditRepository();
        }

        public function index() {
            return view('pages.frontend.my_logs.index');
        }

        public function profile($audit) {
            $data = DB::table('audits')
                ->leftJoin('users', 'audits.user_id', '=', 'users.id')
                ->select('audits.*',
                    DB::raw("CASE
                    WHEN audits.user_type = 'App\Models\User' THEN users.email
                    ELSE 'Guest User'
                END as user_email")
                )
                ->where('audits.id', $audit)->first();

            return view('pages.frontend.my_logs.profile.profile')->with('audits',  $data);
        }

        public function getAllForDt() {
            return response(['data' => $this->audit_repo->getMyLogsForDt()]);
        }
    }
