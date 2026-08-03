<?php

namespace App\Interfaces;

use App\Models\User;


    Interface UserInterface{
        public function findByEmail(string $email);
        public function findByResetToken(string $TOKEN);
        public function count();
        public function create(array $data);
        public function update(User $user,array $data):User;
        
        public function delete(user $user);
        public function getDevices(User $user);
        public function removeDevice(User $user,int $tokenId);

    }