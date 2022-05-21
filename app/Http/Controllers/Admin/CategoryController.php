<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd(Gate::allows('categories.index'));

        Gate::authorize('categories.index');

        // if(!Gate::allows('categories.index')) {
        //     abort(403, 'حبيبي انت مش مصرح الك حل عن راسي');
        // }

        $categories = Category::with('products', 'parent')->withCount('products')->orderBy('id', 'desc')->paginate(10);

        // dd($categories);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('categories.create');
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');
        // validate input
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // upload the file
        $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/images'), $new_image);

        // Save data to database
        Category::create([
            'name' => $request->name,
            'image' => $new_image,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Created')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('categories.edit');
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('id', '<>', $category->id)->get();
        return view('admin.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('categories.edit');
        // validate input
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);
        $new_image = $category->image;
        if($request->hasFile('image')) {
            // upload the file
            $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images'), $new_image);
        }

        // Save data to database
        $category->update([
            'name' => $request->name,
            'image' => $new_image,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Updated')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('categories.delete');
        $category = Category::findOrFail($id);

        // Delete image
        if(file_exists(public_path('uploads/images/'.$category->image))) {
            File::delete(public_path('uploads/images/'.$category->image));
        }

        // set parent id to null
        Category::where('parent_id', $category->id)->update(['parent_id' => null]);
        // Category::where('parent_id', $category->id)->delete();

        // delete item
        $category->delete();

        return redirect()->route('admin.categories.index')->with('msg', 'Category Deleted')->with('type', 'danger');
    }
}
