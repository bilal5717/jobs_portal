<?php

// FolderFilter.php

namespace App\Filters;
use App\Filters\NameFilter;
use App\Filters\CompanyFilter;
use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class FolderFilter extends AbstractFilter
{
    protected $filters = [
        'name' => NameFilter::class,
        'company_id' => CompanyFilter::class
    ];
    
}