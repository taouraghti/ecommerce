<?php
class item extends Controller{
    public function __construct()
    {
            $this->itemModel = $this->model('items');
            $this->userModel = $this->model('users');
    }

}