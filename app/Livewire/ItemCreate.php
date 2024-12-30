<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;

class ItemCreate extends Component
{
    public $categories;

    public string $itemName;
    
    public string $itemDescription;

    public int $itemCategory;

    public string $itemImage = '';

    public function createItem(){

        Item::create([
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'category_id' => $this->itemCategory,
            'image' => $this->itemImage
        ]);

        $this->dispatch('itemCreated');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemCategory', 'itemImage']);
    }

    public function mount(){
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.item-create');
    }
}
