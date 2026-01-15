<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Apply only when user is authenticated AND model has company_id
        if (Auth::check() && in_array('company_id', $model->getFillable())) {
            $builder->where(
                $model->getTable() . '.company_id',
                Auth::user()->company_id
            );
        }
    }
}
