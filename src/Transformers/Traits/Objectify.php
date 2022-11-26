<?php

namespace App\Transformers\Traits;

trait Objectify
{
    /**
     * Cobvcerts the given input to an object.
     * 
     */
     protected function objectify($input)
     {
        if (is_object($input)) {
            return $input;
        }

        if (is_array($input)) {

            return $this->objectify(
                json_encode($input)
            );
        }

        if (is_string($input)) {
            return json_decode($input);
        }

        return $input;
     }
}