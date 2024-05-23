<div class="d-flex justify-content-center mt-5">
    {{-- Success is as dangerous as failure. --}}
    <div class="container w-50">
        {{-- Crreate to do container --}}
        <div class="p-4 shadow-sm">
            <h5 class="text-dark">Create new TODO</h5>
            <form method="post" wire:submit="save">
                @csrf
                <div>
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" wire:model="name" placeholder="eg.Learn Laravel"
                        class="form-control">
                    @error('name')
                        <small class="text-danger"> {{ $message }} </small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4">{{ $btnName }}</button>
                @if (session('msg'))
                    <small class="text-success"> {{ session('msg') }} </small>
                @endif
            </form>

        </div>
        {{-- Search container --}}
        <div class="shadow-sm mt-4 p-4">
            <input type="search" wire:model.live.debounce.600ms="search" class="form-control"
                placeholder="Search my TODO">
        </div>
        {{-- Show todos container --}}
        <div class="shadow-sm mt-4 p-4">
            @foreach ($todos as $todo)
                <div>
                    <div class="d-flex justify-content-between mb-5">
                        <div class="d-flex flex-column">
                            @if ($editingTodoId === $todo->id)
                                <form class="d-flex" wire:submit="updateTodo({{$todo->id}})">
                                    <input type="text" wire:model="editingTodoName" class="form-control">
                                    <button type="submit" class="ms-2 d-block btn btn-primary">Update</button>
                                    @if (session('updateSuccess'))
                                        <small class="text-danger"> {{session('updateSuccess')}} </small>
                                    @endif
                                </form>
                            @endif

                            <b> {{ $todo->name }} </b>
                            <small> {{ $todo->created_at->diffForHumans() }} </small>
                        </div>
                        <div>
                            <button wire:click="editTodo({{ $todo->id }})" class="btn btn-warning">Edit</button>
                            <button wire:click="deleteTodo({{ $todo->id }}) "class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="mt-4">
            {{ $todos->links('vendor.livewire.bootstrap') }}
        </div>
    </div>
</div>
