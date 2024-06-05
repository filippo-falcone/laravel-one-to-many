@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <a class="link-dark" href="{{ route('admin.projects.index') }}">
            <i class="fa-solid fa-arrow-left fa-sm"></i>
        </a>
    </div>
    @include('partials.flash-messages')
    <div class="card">
        <div class="card-header">
            <h3>{{ $project->name }}</h3>
        </div>
        @if ($project->image)
            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}">
        @endif
        <div class="card-body">
            <p class="card-text"><strong>Slug:</strong> {{ $project->slug }}</p>
            <p class="card-text"><strong>Client Name:</strong>
                {{ $project->client_name ? $project->client_name : 'Empty' }}</p>
            <p class="card-text"><strong>Created at:</strong> {{ $project->created_at }}</p>
            <p class="card-text"><strong>Updated at:</strong> {{ $project->updated_at }}</p>
            <p class="card-text">{{ $project->summary }}</p>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-warning" href="{{ route('admin.projects.edit', $project->slug) }}" role="button">
                    <i class="fa-solid fa-pencil fa-sm"></i>
                </a>
                <form class="d-inline" action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
