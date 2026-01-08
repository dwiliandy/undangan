<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
  public function index()
  {
    $templates = EventTemplate::latest()->get();
    return view('admin.templates.index', compact('templates'));
  }

  public function create()
  {
    return view('admin.templates.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'thumbnail' => 'nullable|string', // Just a string for now, could be url
      'preview_image' => 'nullable|string',
      'view_path' => 'required|string|max:255', // e.g., frontend.templates.modern
    ]);

    $data = $request->all();
    $data['slug'] = Str::slug($request->name);

    EventTemplate::create($data);

    return redirect()->route('admin.templates.index')->with('success', 'Template created successfully.');
  }

  public function edit(EventTemplate $template)
  {
    return view('admin.templates.edit', compact('template'));
  }

  public function update(Request $request, EventTemplate $template)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'thumbnail' => 'nullable|string',
      'preview_image' => 'nullable|string',
      'view_path' => 'required|string|max:255',
    ]);

    $data = $request->all();
    $data['slug'] = \Illuminate\Support\Str::slug($request->name);

    $template->update($data);

    return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully.');
  }

  public function destroy(EventTemplate $template)
  {
    $template->delete();
    return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully.');
  }
}
