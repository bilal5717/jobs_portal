<?php

// FileFilter.php

namespace App\Filters;
use App\Filters\NameFilter;
use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class FileFilter extends AbstractFilter
{
    protected $filters = [
        'name' => NameFilter::class
    ];
    
}