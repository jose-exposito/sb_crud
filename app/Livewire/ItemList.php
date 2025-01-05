<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ItemList extends Component
{
    use WithPagination;

    public $item;

    public $categories;

    public string $selectedItemName;

    public string $selectedItemDescription;

    public Category $selectedItemCategory;

    public string $selectedItemImage;

    public $pagination = 1;

    public function delete(int $itemId){

        $item = Item::find($itemId);

        if ($item) {
            $item->delete();
            $this->resetPage();
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

    }

    #[On('itemCreated')]
    public function getItems(){
        $this->resetPage();
    }

    public function generateCSV(){
        $items = Item::all(); 

        $filename = 'items_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, ['ID', 'Nombre', 'Descripción', 'Categoría', 'Imagen', 'Fecha de Creación', 'Fecha de Actualización']);

        foreach ($items as $item) {
            fputcsv($handle, [
                $item->id,
                $item->name,
                $item->description,
                $item->category->name, 
                $item->image,
                $item->created_at,
                $item->updated_at
            ]);
        }

        rewind($handle);

        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]
        );
    }

    public function mount(){
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.item-list',
    ['items' => Item::with('category')->paginate(5)]); 
    }
}
