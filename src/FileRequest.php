<?php

namespace Pythagus\LaravelFileRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FileRequest
 * @package Pythagus\LaravelFileRequest
 *
 * @author: Damien MOLINA
 */
class FileRequest extends FormRequest {

    use FileRequestTrait ;

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated() {
        $this->setUp() ;

        return parent::validated() ;
    }

}
