<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Products;
use App\Models\Category;
use App\Models\User;
use Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Attribute;
use App\Models\ProductAttribute;

use Intervention\Image\ImageManagerStatic as Image;

class StoreProductController extends Controller
{
    //-----
    public function index(Request $request){
		$title = array(
			'title' => 'Products',
			'slug' => 'Listing All The Products',
			'active' => 'products'
		);		
		
		$orders = Products::where('reorder', null)->get();
		foreach($orders as $order){
			$order->reorder = $order->id;
			$order->save();
		}
		
		$category = Category::where('status', '1')->where('is_delete', '0')->orderBy('id', 'asc')->pluck('name', 'id');
		
		$products = Products::where('is_delete', '0')->where('store_id',\Auth::id());
		if(@$request->search){
			$search = $request->search;
			$products = $products->where(function ($query) use ($search) {
				$query->where('title', 'like', '%'.$search.'%');
				$query->orWhere('description', 'like', '%'.$search.'%');
				$query->orWhere('sku', 'like', '%'.$search.'%');
			});
		}
		if(@$request->status){
			if($request->status=='active'){
				$products = $products->where('status', '1');
			}
			else {
				$products = $products->where('status', '0');
			}
		}
		if(@$request->quantity){
			$products = $products->where('qty', '<=', $request->quantity);
		}
		if(@$request->category){
			$products = $products->where('category', $request->category);
		}
		
		$products = $products->orderBy('reorder', 'asc')->paginate(10);
		
		return view('store.product.index', compact('title', 'products', 'category'));
	}
	
	//-----
    public function csvExport(Request $request){
		
		$products = Products::where('is_delete', '0')->where('store_id',\Auth::id())->get();
		
		//csv
		$filename = auth()->user()->id . date('Y_m_d_h_i');
		
		$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=".$filename.".csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
		
		$columns = array('Sku', 'Title', 'Qty', 'Description', 'Category', 'Price', 'Image');
		
		$callback = function() use ($products, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);
			
			foreach($products as $product){
			
				$datas = array();
				
				$datas['Sku'] = @$product->sku;
				$datas['Title'] = @$product->title;
				$datas['Qty'] = @$product->qty;
				$datas['Description'] = @$product->description;
				$datas['Category'] = @$product->categoryTO->name;
				$datas['Price'] = @$product->price;
				$datas['Image'] = asset('storage/products/'.$product->image);
				
				fputcsv($file, $datas);
			}
			fclose($file);
		};
		
		
		return response()->stream($callback, 200, $headers);
		
	}
	
	//-----
    public function create(){
		$title = array(
			'title' => 'Products',
			'slug' => 'Add New Product',
			'active' => 'products'
		);
		$attributes = Attribute::pluck('attribute','id');
		$relatedProducts = Products::where('status','1')->where('is_delete','0')->where('store_id',\Auth::user()->id)->pluck('title','id');
		$category = Category::where('status', '1')->where('is_delete', '0')->where('store_id', auth()->user()->store->id)->orderBy('id', 'desc')->pluck('name', 'id');
		return view('store.product.create', compact('title','category','relatedProducts','attributes'));
	}
	
	//store
	public function store(Request $request)
    {
		
		
		$request->validate([
			'title' => 'required|max:255|unique:products,title|unique:products,slug',
			'image' => 'required|mimetypes:image/jpeg,image/png,image/jpg,image/webp|max:2048',
			'description' => 'max:255',
			'category' => 'required',
			'sku' => 'required',
			'qty' => 'required',
			'price' => 'required',
			'status' => 'required',
			'related_products' => 'required',
			'product_type' => 'required',
			'attribute' => $request->product_type === 'Variable' ? 'required': 'nullable',
			'attribute_values' => $request->product_type === 'Variable' ? 'required': 'nullable',
			'attribute_price' => $request->product_type === 'Variable' ? 'required|': 'nullable',
			
		]);
		
		$store = new Products;
		
		if ($request->file('image')) {
			$path = ('storage/products/');
			if(!is_dir($path)) {
				mkdir($path, 0775, true);
				chown($path, exec('whoami'));
			}
			
			$image = 'product-'. auth()->user()->id .'-'. md5(uniqid() . time()) .'.webp';
			Image::make($request->file('image'))->encode('webp', 90)->resize(400, 400)->save($path.$image);
			//image
			$store->image = $image;
		}
		
		$store->category = $request->category;
		$store->store_id = $request->store;
		$store->title = $request->title;
		$store->slug = Str::slug($request->title, '-');
		$store->description = $request->description;
		$store->sku = $request->sku;
		$store->qty = $request->qty;
		$store->price = $request->price;
		$store->nutrition_info = $request->nutrition_info;
		$store->tag = $request->tag;
		$store->status = $request->status;
		$store->store_id = \Auth::id();
		$store->related_products = implode(',',$request->related_products)??null;
		$store->product_type = $request->product_type;
		$store->save();


		if($request->product_type === 'Variable'){
			for($i = 0; $i < count($request->attribute); $i++){
				ProductAttribute::create([
	
					'products_id'      => $store->id,
					'attributes_id'   => $request->attribute[$i],
					'value'           => $request->attribute_values[$i],
					'price'           => $request->attribute_price[$i],

				]);	
			}
		}
		
		$request->session()->flash('success', "Product Created Successfully");
		return redirect()->route("store.products");		
	}
	
	//edit
	public function edit(Request $request, Products $product)
    {
		$title = array(
			'title' => 'Products',
			'slug' => 'Edit Product',
			'active' => 'products'
		);
		$attributes = Attribute::pluck('attribute','id');
		$relatedProducts = Products::where('status','1')->where('is_delete','0')->where('store_id',\Auth::user()->id)->pluck('title','id');
		$relatedProducts = Products::where('status','1')->where('is_delete','0')->pluck('title','id');
		$category = Category::where('status', '1')->where('is_delete', '0')->where('store_id', auth()->user()->store->id)->orderBy('id', 'desc')->pluck('name', 'id');
		return view('store.product.edit', compact('title', 'product', 'category','relatedProducts', 'attributes'));
    }
	
	//update
	public function update(Request $request, Products $product)
    {
		$request->validate([
			'title' => 'required|max:100|unique:products,title,'.$product->id.'|unique:products,slug,'.$product->id,
			'image' => 'mimetypes:image/jpeg,image/png,image/jpg,image/webp|max:2048',
			'description' => 'max:255',
			'category' => 'required',
			'sku' => 'required',
			'qty' => 'required',
			'price' => 'required',
			'status' => 'required',
			'related_products'=> 'required',
			'product_type' => 'required',
			'attribute' => $request->product_type === 'Variable' ? 'required': 'nullable',
			'attribute_values' => $request->product_type === 'Variable' ? 'required': 'nullable',
			'attribute_price' => $request->product_type === 'Variable' ? 'required': 'nullable',
		]);
		
		if ($request->file('image')) {
			$path = ('storage/products/');
			if(!is_dir($path)) {
				mkdir($path, 0775, true);
				chown($path, exec('whoami'));
			}
			
			$image = 'product-'. auth()->user()->id .'-'. md5(uniqid() . time()) .'.webp';
			Image::make($request->file('image'))->encode('webp', 90)->resize(400, 400)->save($path.$image);
			//image
			$product->image = $image;
		}
		
		$product->category = $request->category;
		$product->title = $request->title;
		$product->slug = Str::slug($request->title, '-');
		$product->description = $request->description;
		$product->qty = $request->qty;
		$product->sku = $request->sku;
		$product->price = $request->price;
		$product->tag = $request->tag;
		$product->status = $request->status;
		$product->store_id = \Auth::id();
		$product->related_products = implode(',',$request->related_products)??null;
		$product->product_type = $request->product_type;
		$product->save();

		if($request->product_type === 'Variable'){
			ProductAttribute::where('products_id',$product->id)->whereNotIn('id',$request->attr_id??[])->delete()??null;
			for($i = 0; $i < count($request->attribute); $i++){
				ProductAttribute::updateOrCreate(
					['id' => $request->attr_id[$i]??null],
					[
					'products_id'     => $product->id,
					'attributes_id'   => $request->attribute[$i],
					'value'           => $request->attribute_values[$i],
					'price'           => $request->attribute_price[$i],
		
				]);
				
			}
		}
		
		$request->session()->flash('success', "Product Updated Successfully");
		return redirect()->route("store.products");
	}
	
	//delete
	public function destroy(Request $request, Products $product)
    {
		$product->is_delete = '1';
		$product->save();
		$request->session()->flash('success', "Product Deleted");
		return redirect()->route("store.products");
    }
	
	
	//csv
	public function uploadCSV(Request $request)
    {
		$request->validate([
			'file' => 'required|file',
		]);
		
		if ($request->file('file')) {
			
			$file=$request->file('file');
			
			$path = 'storage/csv/';
			if(!is_dir($path)) {
				mkdir($path, 0775, true);
				chown($path, exec('whoami'));
			}
			
			$filename = md5(uniqid().time()).'.'.$file->getClientOriginalExtension();
			// Upload file
			$file->move($path, $filename);
			
			// Import CSV to Database
			$filepath = ('public/csv/'.$filename);
			
			// Reading file
			$data = Storage::get($filepath);
			
			
			$csv = array_map(function($row) {
				$data = str_getcsv($row);
				//insert teams
				if(@$data && $data[0] && is_numeric($data[13])){
					$check = Products::where('sku', $data[6])->first();
					$category = Category::where('name', 'like', '%'.$data[5].'%')->first();
					
					$store = new Products;
					
					if (!$check && $data[4]) {
						$path = ('storage/products/');
						if(!is_dir($path)) {
							mkdir($path, 0775, true);
							chown($path, exec('whoami'));
						}
						
						$imgPath = 'https://static.wixstatic.com/media/'.$data[4];
						//$img = explode('.', $data[4]);
						//$image = 'product-'. auth()->user()->id .'-'. $img[0] .'.webp';
						$image = 'product-'. auth()->user()->id .'-'. $data[4];
						
						$flag = true;
						$try = 1;
						while ($flag && $try <= 3):
							try {
								//Image::make($imgPath)->encode('webp', 90)->resize(400, 400)->save($path.$image);
								Image::make($imgPath)->resize(400, 400)->save($path.$image);
								//Image migrated successfully
								$flag = false;
							} catch (\Exception $e) {
								//not throwing  error when exception occurs
							}
							$try++;
						endwhile;

						//store image
						$store->image = $image;
					}
					
					if(@$check){
						$store->id = $check->id;
						$store->exists = true;
					}
					$store->category = $category->id ?? '';
					$store->title = $data[2];
					$store->slug = Str::slug($data[2], '-');
					$store->description = $data[3];
					
					$store->sku = $data[6];
					$store->qty = $data[13];
					$store->price = $data[8];
					$store->tag = $data[7];
					$store->status = '1';
					$store->store_id = \Auth::id();
					$store->save();
				}
			}, explode("\n", $data)); 
				
			
			$request->session()->flash('success', "Product Export Completed");
			return redirect()->route("store.products");
		}
    }
	
	
	public function productsPosition(Request $request, Products $product)
	{
		$reorder = $product->reorder;
		$otherProduct = Products::where('is_delete', '0');
		if($request->action=='down'){
			$otherProduct = $otherProduct->where('reorder', '>', $reorder)
				->orderBy('reorder', 'asc');
		}
		else {
			$otherProduct = $otherProduct->where('reorder', '<', $reorder)
				->orderBy('reorder', 'desc');
		}
		
		$otherProduct = $otherProduct->where('category', $product->category)
			->first();
		
		$product->reorder = $otherProduct->reorder;
		$product->save();

		//otherProduct
		$otherProduct->reorder = $reorder;
		$otherProduct->save();

		$request->session()->flash('success', "Product position updated");
		return redirect()->back();
	}
	
	
}
