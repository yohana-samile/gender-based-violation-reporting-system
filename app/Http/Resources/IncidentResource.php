<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'occurred_at' => $this->occurred_at->toDateTimeString(),
            'location' => $this->location,
            'status' => $this->status,
            'type' => $this->type,
            'is_anonymous' => $this->is_anonymous,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'reporter' => $this->when(!$this->is_anonymous, [
                'id' => $this->reporter->id,
                'name' => $this->reporter->name
            ]),
            'victims' => VictimResource::collection($this->victims),
            'perpetrators' => PerpetratorResource::collection($this->perpetrators),
            'evidence' => EvidenceResource::collection($this->evidence),
//            'support_services' => SupportServiceResource::collection($this->supportServices),
            'case_updates' => CaseUpdateResource::collection($this->updates),
            'links' => [
                'self' => route('incidents.show', $this->id),
            ]
        ];
    }
}
