<?php

namespace Kjjdion\Laracrud\Traits;

use Illuminate\Support\Facades\Schema;

trait ColumnFillable
{
    // set model fillable using database table columns
    public function getFillable()
    {
        return Schema::getColumnListing($this->getTable());
    }
}