<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $_request;
    protected $_builder;
    protected $_filters = [];

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function apply($builder)
    {
        $this->_builder = $builder;

        foreach ($this->_getFilters() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->_builder;
    }

    protected function _getFilters(): array
    {
        return $this->_request->intersect($this->_filters);
    }
}