<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function edit($id);
    public function update($data, $id);
    public function changePassword($id);
    public function updatePassword($data, $id);
}
