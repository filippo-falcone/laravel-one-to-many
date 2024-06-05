<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $data = [
            'projects' => $projects
        ];
        return view('admin.projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'name' => 'required|min:5|max:255|unique:projects,name',
                'image' => 'nullable|image|max:512',
                'client_name' => 'nullable|min:5|max:200',
                'summary' => 'nullable|min:10',
            ]
        );
        $formData = $request->all();
        $formData['slug'] = Str::slug($formData['name'], '-');
        if ($request->hasFile('image')) {
            $img_path = Storage::disk('public')->put('projects_images', $formData['image']);
            $formData['image'] = $img_path;
        }
        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->save();
        return redirect()->route('admin.projects.show', ['project' => $newProject->slug])->with('message', $newProject->name . ' successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $data = [
            'project' => $project
        ];
        return view('admin.projects.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $data = [
            'project' => $project
        ];
        return view('admin.projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validate = $request->validate(
            [
                'name' => [
                    'required',
                    'max:255',
                    Rule::unique('projects')->ignore($project),
                ],
                'image' => 'nullable|image|max:512',
                'client_name' => 'nullable|min:5|max:200',
                'summary' => 'nullable|min:10',
            ]
        );
        $formData = $request->all();
        $project->slug = Str::slug($formData['name'], '-');
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image);
            }
            $img_path = Storage::disk('public')->put('projects_images', $formData['image']);
            $formData['image'] = $img_path;
        }
        $project->update($formData);
        session()->flash('message', $project->name . ' successfully updated.');
        return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('message', $project->name . ' successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', $project->name . ' successfully deleted.');
    }
}
