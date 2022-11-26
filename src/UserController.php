<?php

namespace App;

use App\Services\BaseJsonApiService;
use App\Transformers\UserTransformer;

class UserController extends BaseJsonApiService
{
    public function __construct()
    {
        parent::__construct('https://reqres.in/api', []);
    }

    public function show(int $id) : array
    {
        $data = $this->get("users/$id");

        return (new UserTransformer($data))->transform();
    }

    public function all() : array
    {
        return [];
    }
}