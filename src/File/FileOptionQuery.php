<?php

namespace Pythagus\LaravelFileRequest\File;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class FileOptionQuery
 * @package Pythagus\LaravelFileRequest\File
 *
 * @property Builder query
 * @property string  field
 *
 * @author: Damien MOLINA
 */
class FileOptionQuery {

    /**
     * Query to search a unique name.
     *
     * @var Builder
     */
    private $query ;

    /**
     * Field in the datatable.
     *
     * @var string
     */
    private $field ;

    /**
     * Determine whether a name already exists.
     *
     * @param string $name
     * @return bool
     */
    public function nameAlreadyExists(string $name) {
        return $this->query->where($this->field, $name)->exists() ;
    }

    /**
     * @param Builder $query
     * @param string $field
     */
    public function __construct(Builder $query, string $field) {
        $this->query = $query ;
        $this->field = $field ;
    }

}
