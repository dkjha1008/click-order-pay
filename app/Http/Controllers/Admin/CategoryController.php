<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    //-----
    public function index(Request $request){
		$title = array(
			'title' => 'Categories',
			'slug' => 'Listing All The Categories',
			'active' => 'category'
		);

		$category = Category::where('reorder', null)->get();
		foreach($category as $cat){
			$cat->reorder = $cat->id;
			$cat->save();
		}

		$category = Category::query();
		if(@$request->search){
			$category = $category->where('name', 'like', '%'.$request->search.'%');
		}
		$category = $category->where('is_delete', '0')->orderBy('reorder', 'asc')->paginate(10);

		return view('admin.category.index', compact('title', 'category'));
	}
	
	
	//-----
    public function create(){
		$title = array(
			'title' => 'Categories',
			'slug' => 'Add New Category',
			'active' => 'category'
		);
		
		return view('admin.category.create', compact('title'));
	}
	
	//store
	public function store(Request $request)
    {
		$request->validate([
			'name' => 'required|max:100|unique:categories,name|unique:categories,slug',
			'image' => 'required|mimes:jpeg,png,svg,html,jpg|max:2048',
			'status' => 'required'
		]);
		
		$store = new Category;
		
		if ($request->file('image')) {
			$path = ('storage/category/');
			if(!is_dir($path)) {
				mkdir($path, 0775, true);
				chown($path, exec('whoami'));
			}
			
			$file = $request->file('image');
			$image = 'category-'. auth()->user()->id .'-'. md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
			
			$file->move($path, $image);
			//image
			$store->image = $image;
		}
		
		$store->store_id = auth()->user()->store->id;
		$store->name = $request->name;
		$store->slug = Str::slug($request->name, '-');
		$store->status = $request->status;
		$store->save();
		
		$request->session()->flash('success', "Category Created Successfully");
		return redirect()->route("admin.category");		
	}
	
	//edit
	public function edit(Request $request, Category $category)
    {
		$title = array(
			'title' => 'Categories',
			'slug' => 'Edit Category',
			'active' => 'category'
		);
		
		return view('admin.category.edit', compact('title', 'category'));
    }
	
	//update
	public function update(Request $request, Category $category)
    {
		$request->validate([
			'name' => 'required|max:100|unique:categories,name,'.$category->id.'|unique:categories,slug,'.$category->id,
			'image' => 'mimes:jpeg,png,svg,html,jpg|max:2048',
			'status' => 'required'
		]);
		
		if ($request->file('image')) {
			$path = ('storage/category/');
			if(!is_dir($path)) {
				mkdir($path, 0775, true);
				chown($path, exec('whoami'));
			}
			
			$file = $request->file('image');
			$image = 'category-'. auth()->user()->id .'-'. md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
			
			$file->move($path, $image);
			//image
			$category->image = $image;
		}
		
		$category->store_id = auth()->user()->store->id;
		$category->name = $request->name;
		$category->slug = Str::slug($request->name, '-');
		$category->status = $request->status;
		$category->save();
		
		$request->session()->flash('success', "Category Updated Successfully");
		return redirect()->route("admin.category");
	}
	
	//delete
	public function destroy(Request $request, Category $category)
    {
		$category->is_delete = '1';
		$category->save();
		$request->session()->flash('success', "Category Deleted");
		return redirect()->route("admin.category");
    }

    public function categoryPosition(Request $request, Category $category)
	{
		$reorder = $category->reorder;
		$otherCategory = Category::where('is_delete', '0');
		if($request->action=='down'){
			$otherCategory = $otherCategory->where('reorder', '>', $reorder)
				->orderBy('reorder', 'asc');
		}
		else {
			$otherCategory = $otherCategory->where('reorder', '<', $reorder)
				->orderBy('reorder', 'desc');
		}
		
		$otherCategory = $otherCategory->first();
		
		$category->reorder = $otherCategory->reorder;
		$category->save();

		//otherCategory
		$otherCategory->reorder = $reorder;
		$otherCategory->save();

		$request->session()->flash('success', "Category position updated");
		return redirect()->back();
	}
	
	
}
