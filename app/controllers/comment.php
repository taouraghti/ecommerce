<?php
class comment extends Controller{
    public function __construct()
    {
            $this->itemModel = $this->model('items');
            $this->commentModel = $this->model('comments');
            $this->userModel = $this->model('users');
    }
}