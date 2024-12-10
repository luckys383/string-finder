<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{

    const DB_DATETIME_FORMAT = 'Y-m-d H:i:s';
    const DB_DATE_FORMAT = 'Y-m-d';
    const DISPLAY_DATE_FORMAT = 'd-m-Y';
    const DISPLAY_DATETIME_FORMAT = 'd-m-Y H:i:s';
    
    protected $likeFilterFields = [];

    /**
     * set id of contract.
     * 
     * @param $value: integer id.
     */
    public function setKey($value)
    {
    	$this->id = $value;
    	return $this;
    }

    /**
     * get id of contract.
     * 
     * @return integer id.
     */
    public function getKey()
    {
    	return $this->id;
    }

    /**
     * add filtering.
     * 
     * @param  $builder: query builder.
     * @param  $filters: array of filters.
     * @return query builder.
     */
    public function scopeFilter($builder, $filters = [])
    {
        if(!$filters) {
            return $builder;
        }

        foreach ($filters as $field => $value) {
            if(!in_array($field, $this->fillable) || !$value) {
                continue;
            }

            if(in_array($field, $this->likeFilterFields)) {

                $builder->where($field, 'LIKE', '%' . $value . '%');
            } else {
                $builder->where($field, $value);
            }
        }

        return $builder;
    }
}