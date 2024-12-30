<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public $search = '';

    public $categories;

    public $category;

    public $categoryName = '';

    public function updatingSearch()
    {
        $this->resetPage(); 
    }

    public function editCategory(int $categoryId){
        $this->category->update(
            [
                'name' => $this->categoryName
            ]
        );

        $this->getCategories();
    }

    public function selectCategory(int $categoryId){
        $this->category = Category::find($categoryId);

        $this->categoryName = $this->category->name;
    }

    public function delete(int $categoryId){
        $category = Category::find($categoryId);

        if ($category) {
            $category->delete();
            $this->getCategories();
            session()->flash('message', 'Categoría eliminada correctamente.');
        }
    }

    public function mount(){
        $this->getCategories();
    }

    #[On('categoryCreated')]
    public function getCategories(){
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.category-list');
    }
}