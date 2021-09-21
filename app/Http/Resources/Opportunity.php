<?php

namespace App\Http\Resources;

use App\Http\Resources\Lookups\Category;
use App\Http\Resources\Lookups\Country;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Opportunity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'opportunityTitle' => $this->title,
            'category' => new  Category($this->category),
            'country' => new  Country($this->country),
            'deadline' => $this->deadline->toDayDateTimeString(),
            'user' => new \App\Http\Resources\User($this->user),
            'organizer' => $this->organizer,
            'createAt' => $this->created_at->toFormattedDateString(),
        ];
    }
}
