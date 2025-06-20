<?php

namespace App\Http\Controllers\Gbv;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Eloquent\IncidentRepository;

class ReportController extends Controller
{
    private $incidentRepository;

    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function reports()
    {
        $data['incidentsByStatus'] = $this->incidentRepository->all()->groupBy('status');
        $data['incidentsByType'] = $this->incidentRepository->all()->groupBy('type');
        return view('pages.incidents.reports', $data);
    }
}
