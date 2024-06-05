@extends('layouts.admin')

@section('content')
    @include('partials.flash-messages')
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2 class="fs-4 text-secondary">Projects</h2>
        <a class="btn btn-outline-success btn-sm" href="{{ route('admin.projects.create') }}" role="button">
            <i class="fa-solid fa-plus"></i>
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Client Name</th>
                <th class="d-none d-lg-table-cell" scope="col">Created at</th>
                <th class="d-none d-lg-table-cell" scope="col">Updated at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td class="d-none d-lg-table-cell">{{ $project->created_at }}</td>
                    <td class="d-none d-lg-table-cell">{{ $project->updated_at }}</td>
                    <td>
                        <div class="d-flex flex-column flex-md-row align-items-center">
                            <a class="btn btn-outline-primary btn-sm"
                                href="{{ route('admin.projects.show', $project->slug) }}" role="button">
                                <i class="fa-solid fa-eye fa-sm"></i>
                            </a>
                            <a class="btn btn-outline-warning btn-sm my-2 my-md-0 mx-md-2"
                                href="{{ route('admin.projects.edit', $project->slug) }}" role="button">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form class="d-inline" action="{{ route('admin.projects.destroy', $project->slug) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
