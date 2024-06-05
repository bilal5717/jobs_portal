<?php

// FolderFilter.php

namespace App\Filters;
use App\Filters\NameFilter;
use App\Filters\EmailFilter;
use App\Filters\UserStatusFilter;
use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    protected $filters = [
        'name' => NameFilter::class,
        'email' => EmailFilter::class,
        'user_status' => UserStatusFilter::class
    ];
    
}