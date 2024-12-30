<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryCreate extends Component
{

    public string $categoryName;

    public function createCategory(){

        Category::create([
            'name' => $this->categoryName
        ]);

        $this->dispatch('categoryCreated');

        $this->categoryName = '';

    }


    public function render()
    {
        return view('livewire.category-create');
    }
}
