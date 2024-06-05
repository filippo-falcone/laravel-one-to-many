@extends('layouts.admin')

@section('content')
    <div>
        <a class="link-dark" href="{{ route('admin.projects.index') }}">
            <i class="fa-solid fa-arrow-left fa-sm"></i>
        </a>
    </div>
    <h2 class="fs-4 text-secondary my-4">Edit Project</h2>
    <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingName" name="name"
                value="{{ old('name', $project->name) }}" placeholder="Project name">
            <label for="floatingName">Project name</label>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($project->image)
                <div>
                    <img src="{{ asset('storage/' . $project->image) }}" class="img-thumbnail" alt="{{ $project->name }}"
                        width="150">
                </div>
            @else
                <small>Image not found</small>
            @endif
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="floatingClientName"
                name="client_name" value="{{ old('client_name', $project->client_name) }}" placeholder="Client name">
            <label for="floatingClientName">Client name</label>
            @error('client_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control @error('summary') is-invalid @enderror" name="summary" rows="9"
                placeholder="Leave a summary here" id="floatingSummary">{{ old('summary', $project->summary) }}</textarea>
            <label for="floatingSummary">Summary</label>
            @error('summary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
