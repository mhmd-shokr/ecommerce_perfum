<?php
    namespace App\Interfaces;

    Interface UserInterface{
        public function count();
        public function create(array $data);
    }