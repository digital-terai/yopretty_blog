<?php

namespace App\maguttiCms\Builders;

use Carbon\Carbon;

/**
 * Class UserBuilder
 * @package App\maguttiCms\Builders
 */
class UserBuilder extends LaraCmsBuilder
{

    public function todayUser()
    {
        return $this->whereDate('created_at', Carbon::today()->toDateString());
    }

    public function yesterdayUser()
    {
        return $this->whereDate('created_at', Carbon::yesterday()->toDateString());
    }
}
