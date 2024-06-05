<?php

?><?php

// CompanyFilter.php

namespace App\Filters;
$company_id;
class OneCompanyFilter
{
    public function filter($builder, $value)
    {
    	$this->company_id = $value;
        return $builder->whereHas('company', function($query) {
		    $query->where('company_id', $this->company_id);
		});
    }
}