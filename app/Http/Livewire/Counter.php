<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    protected $listeners = ['eventName' => 'functionName'];

    public function functionName()
    {
        $this->count++;
    }

    public function increment()
    {
        $this->emit('eventName');
    }

    public function decrement()
    {
        $this->count--;
    }

    public function clear(int $value)
    {
        $this->count = $value;
    }


    public function render()
    {
        return view('livewire.counter');
    }
}
