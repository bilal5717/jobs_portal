<?php

?><?php

// CompanyFilter.php

namespace App\Filters;
$company_id;
class CompanyFilter
{
    public function filter($builder, $value)
    {
    	$this->company_id = $value;
        return $builder->whereHas('companies', function($query) {
		    $query->where('company_id', $this->company_id);
		});
    }
}