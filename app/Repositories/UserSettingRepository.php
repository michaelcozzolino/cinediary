<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

class UserSettingRepository extends BaseRepository
{
    public function __construct(protected App $app, protected Model $model)
    {
        parent::__construct($this->app, $this->model);
    }

    protected function model(): string
    {
        return Setting::class;
    }
}
