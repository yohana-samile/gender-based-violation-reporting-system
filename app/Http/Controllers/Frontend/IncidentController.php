<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incident\StoreIncidentRequest;
use App\Models\Evidence;
use App\Models\SupportService;
use App\Models\System\Code;
use App\Models\System\CodeValue;
use App\Models\System\District;
use App\Repositories\Frontend\Eloquent\IncidentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    private $incidentRepository;
    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
        $this->middleware('access.routeNeedsPermission:reporter', [
            'only' => ['index', 'create', 'store', 'show']
        ]);
    }

    public function index(Request $request)
    {
        $incidents = $this->incidentRepository->getByReporter(user_id());
        return view('pages.frontend.incidents.index', compact('incidents'));
    }

    public function create()
    {
        $codeTypeId = Code::query()->where('name', 'Case Type')->value('id');
        $codeGenderId = Code::query()->where('name', 'Gender')->value('id');
        $codeVulnerability = Code::query()->where('name', 'Case Vulnerability')->value('id');
        $data['incidentTypes'] = CodeValue::getIncidentType($codeTypeId);
        $data['locations'] = District::all();
        $data['vulnerabilities'] = CodeValue::getIncidentVulnerabilities($codeVulnerability);
        $data['genders'] = CodeValue::getIncidentGender($codeGenderId);
        return view('pages.frontend.incidents.create', $data);
    }

    public function store(StoreIncidentRequest $request)
    {
        $validated = $request->validated();
        try {
            $incident = $this->incidentRepository->create($validated);
            return redirect()->route('frontend.incident.show', $incident->uid)->with('success', 'Incident reported successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating incident: '.$e->getMessage());
        }
    }

    public function show($uid)
    {
        $caseStatus = Code::query()->where('name', 'Case Status')->value('id');
        $data['incident'] = $this->incidentRepository->getIncidentByUid($uid);
        $data['incidentStatus'] = CodeValue::getIncidentStatus($caseStatus);
        $data['supportServices'] = SupportService::all();
        return view('pages.frontend.incidents.show', $data);
    }

    public function view($uid)
    {
        $evidence = Evidence::query()->where('uid', $uid)->first();
        if (!$evidence->file_path) {
            redirect()->back()->with('error', "No attachment found");
        }
        logger("file ". $evidence->file_path);
        if (!Storage::disk('public')->exists($evidence->file_path)) {
            abort(404, 'File not found');
        }

        $mimeType = Storage::disk('public')->mimeType($evidence->file_path);
        $fileContents = Storage::disk('public')->get($evidence->file_path);

        return response($fileContents, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . basename($evidence->file_path) . '"');
    }
}
