<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;

class ItemList extends Component
{

    public $item;

    public $items;

    public $categories;

    public string $selectedItemName;

    public string $selectedItemDescription;

    public Category $selectedItemCategory;

    public string $selectedItemImage;

    public function delete(int $itemId){

        $item = Item::find($itemId);

        if ($item) {
            $item->delete();
            $this->getItems();
            session()->flash('message', 'Elemento eliminado correctamente.');
        }
    }

    public function selectItem(int $itemId){
        $this->item = Item::find($itemId);

        $this->selectedItemName = $this->item->name;
        $this->selectedItemDescription = $this->item->description;
        $this->selectedItemCategory = $this->item->category;
        $this->selectedItemImage = $this->item->image;
    }

    public function editItem(){
        $this->item->update([
            'name' => $this->selectedItemName,
            'description' => $this->selectedItemDescription,
            'category' => $this->selectedItemCategory,
            'image' => $this->selectedItemImage
        ]);

        $this->getItems();
    }

    #[On('itemCreated')]
    public function getItems(){
        $this->items = Item::all();
    }

    public function mount(){
        $this->getItems();
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.item-list');
    }
}
