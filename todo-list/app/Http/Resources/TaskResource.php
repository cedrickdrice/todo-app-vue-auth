<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->task_title,
            'description'   => $this->task_description,
            'priority'      => $this->priority->priority_name,
            'status'        => $this->status->status_name,
            'due_date'      => $this->when($this->due_date !== null, $this->due_date),
            'order'        => $this->task_order
        ];
    }
}
