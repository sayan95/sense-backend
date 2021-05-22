<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseContract;

interface AppSettingsContract extends BaseContract {
    public function getAppSettingsEntry();
}