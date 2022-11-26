<?php

namespace App;

use App\UserController;

describe('User Resource Spec', function() {

    context('Tests User Class', function() {

        it('returns a single user', function() {
            $user = new UserController();

            $data = [
                    'data' => [
                        'id' => 5,
                        'email' => 'charles.morris@reqres.in',
                        'first_name' => 'Charles',
                        'last_name' => 'Morris',
                        'avatar' => 'https://reqres.in/img/faces/5-image.jpg',
                    ],
                    'support' => [
                        'url' => 'https://reqres.in/#support-heading',
                        'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
                    ]
            ];

            $request = $user->show(5)['data'];
            
            expect($request)->toBe($data);
        });

        it('returns an empty object when a user is not found.', function() {
            $user = new UserController();

            $request = $user->show(1000)['data'];

            expect($request)->toBe([]);
        });

        it('returns status not found status code when user is not found.', function() {
            $user = new UserController();

            // Since the api has max of 13 id's that can be fetched, so, an attempt to read fetch users from 13 and above should return 404.
            $status = $user->show(mt_rand(13, 1000))['status'];

            expect($status)->toBe(404);
        });

        it('returns users list.', function() {
            $user = new UserController();

            $status = $user->all()['status'];

            expect($status)->toBe(200);
        });
    });
});