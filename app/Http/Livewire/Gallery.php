<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Gallery as GalleryModel;

class Gallery extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $photos = [];

    public function save()
    {
        if (COUNT($this->photos) == 0)
            return;
        //$this->validate([
            //'photo' => 'image|max:1024', // 1MB Max
        //]);
        $ext = explode('/', $this->photos[0]->getMimeType())[1];
        $uid = (string) floor(microtime(true) * 1000) . '.' . $ext;
        foreach($this->photos as $index => $photo) {
            $name = $uid;
            if ($index === 1) {
                $name = 'thumb_' . $name;
            }
            rename(storage_path('app/' . $photo->storeAs('photos', $name)), public_path('galleries/') . $name);
        }
        $store = new GalleryModel;
        $store->name = $uid;
        $store->save();
        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.gallery', [
            'collections' => GalleryModel::orderBy('created_at', 'desc')->paginate(12),
        ]);
    }
}
