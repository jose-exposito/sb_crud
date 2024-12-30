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

    public $items;

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

    public function generateCSV(){
        $items = Item::all(); // Obtiene todos los items desde la base de datos

        // Definir el nombre del archivo
        $filename = 'items_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // Abre un archivo temporal en lugar de directamente 'php://output'
        $handle = fopen('php://temp', 'r+');

        // Escribir la cabecera del CSV
        fputcsv($handle, ['ID', 'Nombre', 'Descripción', 'Categoría', 'Imagen', 'Fecha de Creación', 'Fecha de Actualización']);

        // Escribir los datos de cada item
        foreach ($items as $item) {
            fputcsv($handle, [
                $item->id,
                $item->name,
                $item->description,
                $item->category->name, // Se accede al nombre de la categoría asociada
                $item->image,
                $item->created_at,
                $item->updated_at
            ]);
        }

        // Mover el puntero al principio del archivo para que se pueda leer
        rewind($handle);

        // Retornar la respuesta para descargar el archivo CSV
        return response()->stream(
            function () use ($handle) {
                // Genera el flujo de salida y lo entrega como descarga
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
        $this->getItems();
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.item-list'); 
    }
}
