<?php
namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create();   // show login form
    public function login(array $data): User;  // login user
    public function profile();  // show user profile
    public function profile_update(array $data);  // update user profile

    public function getusers();  // get all users
    public function get_create_data();  // get create data
    public function store_user(array $data);  // store user

    public function get_user($id);  // get user by id

    public function update_user(array $data, $id);  // update user by id

    public function delete_user($id);  // delete user by id
}


?>