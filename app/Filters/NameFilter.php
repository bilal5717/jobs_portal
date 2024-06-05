<?php

?><?php

// NameFilter.php

namespace App\Filters;

class NameFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('name', 'LIKE', '%' . $value . '%');
    }
}