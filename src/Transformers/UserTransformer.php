<?php

namespace App\Transformers;

use App\Transformers\Traits\Objectify;

class UserTransformer
{
    use Objectify;

    /**
     * The user data to transform.
     * 
     * @var $data;
     */
    private $data;

    /**
     * 
     * @param $data;
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * Transforms the incoming user data instance into an array.
     * 
     * @param $user;
     * @return array
     */
    public function transform() : array
    {
        $data = $this->data;
        
        return [
            'data' => $data['response'] ?? null,
            'status' => $data['status'] ?? null,
            '_links' => $this->objectify(
                $this->getLinks($data['response'])
            )
        ];
    }

    private function getLinks(array $data): array
    {

        // Checks is data is expected to be a paginated data.
        if (!isset($data['page']) || empty($data['page'])) {
            return [];
        }

        $links = [];

        $per_page = $data['per_page'];
        $next_page = $data['page'] + 1;

        $links[] = $this->buildLink(
            "https://reqres.in/api/users?page=$next_page&per_page=$per_page",
        );

        return $links;
    }

    private function buildLink(string $url) : array
    {
        return compact('url');
    }
}