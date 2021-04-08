<?php

namespace App\PaddleLeague;

use App\PaddleLeague\Category;

class PaddleLeague
{

    public $category;

    public function __construct()
    {
        $this->category = array();
    }


    public function addCategory(Category $name)
    {
        $this->category[] = $name;
    }

    public function existCategory($name)
    {
        return strlen(array_search($name, array_column($this->category, 'name'))) != 0;
    }
}
