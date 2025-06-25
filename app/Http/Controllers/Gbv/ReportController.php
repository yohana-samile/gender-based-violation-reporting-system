<?php

namespace App\Http\Controllers\Gbv;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Status;
use App\Repositories\Frontend\Eloquent\IncidentRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $incidentRepository;

    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function reports(Request $request)
    {
        $query = Incident::query()->with('statusModel');
        if ($request->date_from) {
            $query->where('occurred_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->where('occurred_at', '<=', $request->date_to);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }
        $incidents = $query->get();

        $incidentsByStatus = $incidents->groupBy('status')->filter(fn($group) => $group->isNotEmpty());
        $incidentsByType = $incidents->groupBy('type')->filter(fn($group) => $group->isNotEmpty());

        $statuses = Status::all();
        $types = Incident::distinct()->pluck('type');

        return view('pages.incidents.reports', compact('incidentsByStatus', 'incidentsByType', 'statuses', 'types'));
    }
}
