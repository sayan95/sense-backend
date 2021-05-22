<?php

namespace App\Services\Interfaces;

interface IAppSettingsService {
    public function getAllAppSettings();
    public function updateAppSettings($id, $data);
}