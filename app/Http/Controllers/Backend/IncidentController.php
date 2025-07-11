<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incident\StoreIncidentRequest;
use App\Http\Requests\Incident\UpdateIncidentRequest;
use App\Http\Resources\IncidentResource;
use App\Models\Evidence;
use App\Models\SupportService;
use App\Models\System\Code;
use App\Models\System\CodeValue;
use App\Models\System\District;
use App\Repositories\Frontend\Eloquent\IncidentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    private $incidentRepository;
    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function index(Request $request)
    {
        $incidents = $this->incidentRepository->all();
        return view('pages.backend.incidents.index', compact('incidents'));
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
        return view('pages.backend.incidents.create', $data);
    }

    public function store(StoreIncidentRequest $request)
    {
        $validated = $request->validated();
        try {
            $incident = $this->incidentRepository->create($validated);
            return redirect()->route('backend.incident.show', $incident->uid)->with('success', 'Incident reported successfully');
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
        return view('pages.backend.incidents.show', $data);
    }

    public function edit($uid)
    {
        $codeId = Code::query()->where('name', 'Case Type')->value('id');
        $caseStatus = Code::query()->where('name', 'Case Status')->value('id');

        $data['locations'] = District::all();
        $data['incident'] = $this->incidentRepository->getIncidentByUid($uid);
        $data['supportServices'] = SupportService::all();
        $data['incidentTypes'] = CodeValue::getIncidentType($codeId);
        $data['incidentStatus'] = CodeValue::getIncidentStatus($caseStatus);

        return view('pages.backend.incidents.edit', $data);
    }

    public function update(UpdateIncidentRequest $request, string $uid)
    {
        $validated = $request->validated();
        try {
            $updated = $this->incidentRepository->update($uid, $validated);
            if (!$updated) {
                return back()
                    ->withInput()
                    ->with('error', 'Failed to update incident');
            }
            return back()->with('success', 'Incident updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating incident: '.$e->getMessage());
        }
    }

    public function destroy(string $uid)
    {
        try {
            $incident = $this->incidentRepository->getIncidentByUid($uid);
            if (!$incident) {
                return redirect()
                    ->route('backend.incident.index')
                    ->with('error', 'Failed to delete incident: no incident found');
            }
            $deleted = $this->incidentRepository->delete($incident->id);
            if (!$deleted) {
                return redirect()
                    ->route('backend.incident.index')
                    ->with('error', 'Failed to delete incident');
            }
            Cache::forget('dashboard_metrics');
            return redirect()
                ->route('backend.incident.index')
                ->with('success', 'Incident deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('backend.incident.index')
                ->with('error', 'Error deleting incident: '.$e->getMessage());
        }
    }

    public function updateStatus(UpdateIncidentRequest $request, string $uid)
    {
        $validated = $request->validated();
        try {
            $this->incidentRepository->addCaseUpdate($uid, [
                'update_text' => $validated['update_text'],
                'status' => $validated['status'] ?? null,
                'status_change' => $validated['status'] ?? null,
            ]);
            Cache::forget('dashboard_metrics');
            return redirect()
                ->route('backend.incident.show', $uid)
                ->with('success', 'Incident status updated successfully');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating status: '.$e->getMessage());
        }
    }

    public function attachServices(Request $request, string $uid)
    {
        $request->validate([
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:support_services,id',
            'notes' => 'nullable|string'
        ]);

        try {
            $this->incidentRepository->attachSupportServices(
                $uid,
                $request->input('service_ids'),
                ['notes' => $request->input('notes')]
            );
            Cache::forget('dashboard_metrics');
            return redirect()
                ->route('backend.incident.show', $uid)
                ->with('success', 'Support services attached successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error attaching services: '.$e->getMessage());
        }
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

    public function getByStatus(string $status): JsonResponse
    {
        $incidents = $this->incidentRepository->getByStatus($status);
        return response()->json(IncidentResource::collection($incidents));
    }

    public function getByType(string $type): JsonResponse
    {
        $incidents = $this->incidentRepository->getByType($type);
        return response()->json(IncidentResource::collection($incidents));
    }

    public function getUserIncidents(Request $request): JsonResponse
    {
        $incidents = $this->incidentRepository->getByReporter($request->user()->id);
        return response()->json(IncidentResource::collection($incidents));
    }
}
