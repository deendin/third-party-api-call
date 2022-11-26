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
        $results = 12;
        $perPage = 6;
        $pages = ceil($results/$perPage);
        $result = [];

        for ($i=1; $i < $pages; $i++){
            $data = $this->get("users?page=$i&per_page=$perPage");
            $result = (new UserTransformer($data))->transform();
        }

        return $result;
    }
}