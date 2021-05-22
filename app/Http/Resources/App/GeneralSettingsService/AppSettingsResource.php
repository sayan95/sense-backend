<?php

namespace App\Http\Resources\App\GeneralSettingsService;

use Illuminate\Http\Resources\Json\JsonResource;

class AppSettingsResource extends JsonResource
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
            'app_name' => $this->app_name,
            'app_logo' => $this->app_logo
        ];
    }
}
