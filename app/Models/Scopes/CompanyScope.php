<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to automatically filter by company_id for multi-tenancy
     */
    public function apply(Builder $builder, Model $model)
    {
        // Apply only when user is authenticated AND model has company_id column
        if (Auth::check() && Auth::user()->company_id && $this->hasCompanyIdColumn($model)) {
            $builder->where(
                $model->getTable() . '.company_id',
                Auth::user()->company_id
            );
        }
    }

    /**
     * Check if model has company_id column
     */
    private function hasCompanyIdColumn(Model $model): bool
    {
        try {
            $table = $model->getTable();
            $columns = Schema::getColumnListing($table);
            return in_array('company_id', $columns);
        } catch (\Exception $e) {
            // Fallback to fillable check if schema inspection fails
            return in_array('company_id', $model->getFillable());
        }
    }

    /**
     * Remove scope for cross-tenant operations (admin only)
     */
    public function remove(Builder $builder, Model $model)
    {
        $builder->withoutGlobalScope($this);
    }
}
