<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Todo extends Component
{
    use WithPagination;
    #[Rule('required|string|max:250')]
    public $name;
    public $editingTodoName;
    public $editingTodoId;
    public $btnName = 'Save';
    public $search;
    public function render()
    {
        return view('livewire.todo',['todos'=>\App\Models\Todo::latest()->where('name','like',"%{$this->search}%")->paginate(2)]);
    }
    function save(){
        $validated = $this->validateOnly('name');
        \App\Models\Todo::create($validated);
        $this->reset('name');
        session()->flash('msg',"Success");

    }
    function deleteTodo( \App\Models\Todo $id){
        // \App\Models\Todo::findOrFail($id)->delete();
        $id->delete();

    }
    function editTodo($id){
        $this->editingTodoId = $id;
        $this->editingTodoName = \App\Models\Todo::findOrFail($id)->name;
    }
    function updateTodo($id){
        // dd($this->editingTodoName);
        \App\Models\Todo::findOrFail($id)->update(['name'=>$this->editingTodoName]);
        session()->flash('updateSuccess','Record updated successfully');
        $this->reset('editingTodoName');
    }
}
