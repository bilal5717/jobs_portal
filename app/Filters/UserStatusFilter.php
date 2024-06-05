<?php

?><?php

// UserStatusFilter.php

namespace App\Filters;

class UserStatusFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('user_status', $value);
    }
}