<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreIncidentRequest;
use App\Http\Requests\Frontend\UpdateIncidentRequest;
use App\Http\Resources\IncidentResource;
use App\Models\SupportService;
use App\Repositories\Frontend\Eloquent\IncidentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    private $incidentRepository;
    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function index(Request $request)
    {
        $incidents = $this->incidentRepository->paginate(10);
        return view('pages.backend.incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('pages.backend.incidents.create');
    }

    public function store(StoreIncidentRequest $request)
    {
        $validated = $request->validated();
        try {
            $incident = $this->incidentRepository->create($validated);
            return redirect()->route('backend.incident.show', $incident->id)->with('success', 'Incident reported successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating incident: '.$e->getMessage());
        }
    }

    public function show($uid)
    {
        $data['incident'] = $this->incidentRepository->getIncidentById($uid);
        $data['supportServices'] = SupportService::all();
        return view('pages.backend.incidents.show', $data);
    }

    public function edit($uid)
    {
        $incident = $this->incidentRepository->getIcidentByUid($uid);
        $supportServices = SupportService::all();
        return view('pages.backend.incidents.edit', compact('incident', 'supportServices'));
    }

    public function update(UpdateIncidentRequest $request, string $uid)
    {
        $validated = $request->validated();
        $updated = $this->incidentRepository->update($uid, $validated);

        if (!$updated) {
            return response()->json([
                'message' => 'Failed to update incident'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Incident updated successfully',
            'data' => new IncidentResource($this->incidentRepository->find($uid))
        ]);
    }

    public function destroy(string $uid): JsonResponse
    {
        $incident = $this->incidentRepository->getIcidentByUid($uid)->id;
        if (!$incident) {
            return response()->json([
                'message' => 'Failed to delete incident, no incident match'
            ], Response::HTTP_BAD_REQUEST);
        }

        $deleted = $this->incidentRepository->delete($incident);
        if (!$deleted) {
            return response()->json([
                'message' => 'Failed to delete incident'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Incident deleted successfully'
        ]);
    }

    public function updateStatus(UpdateIncidentRequest $request, string $uid): JsonResponse
    {
        $validated = $request->validated();

        $this->incidentRepository->addCaseUpdate($uid, [
            'update_text' => $validated['update_text'],
            'status' => $validated['status'] ?? null,
            'status_change' => $validated['status'] ?? null,
        ]);

        return response()->json([
            'message' => 'Incident status updated successfully',
            'data' => new IncidentResource($this->incidentRepository->getIcidentByUid($uid))
        ]);
    }

    public function attachServices(Request $request, string $uid): JsonResponse
    {
        $request->validate([
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:support_services,id',
            'notes' => 'nullable|string'
        ]);

        $this->incidentRepository->attachSupportServices(
            $uid,
            $request->input('service_ids'),
            ['notes' => $request->input('notes')]
        );

        return response()->json([
            'message' => 'Support services attached successfully',
            'data' => new IncidentResource($this->incidentRepository->getIcidentByUid($uid))
        ]);
    }

    public function reports()
    {
        $incidentsByStatus = $this->incidentRepository->all()->groupBy('status');
        $incidentsByType = $this->incidentRepository->all()->groupBy('type');

        return view('incidents.reports', compact('incidentsByStatus', 'incidentsByType'));
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
