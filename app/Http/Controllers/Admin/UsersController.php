<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    //...
	public function index(Request $request)
	{
		
		$title = array(
			'title' => 'Users',
			'slug' => 'Listing All The Users',
			'active' => 'users'
		);
		
		$users = User::where('role', 'user')->orWhere('role', 'store');
		if(@$request->search){
			$search = $request->search;
			$users = $users->where(function ($query) use ($search) {
				$query->where('name', 'like', '%'.$search.'%');
				$query->orWhere('phone_number', 'like', '%'.$search.'%');
				$query->orWhere('address', 'like', '%'.$search.'%');
			});
		}
		if(@$request->verified){
			$users = $users->where('verified', $request->verified);
		}
		if(@$request->status){
			$users = $users->where('status', $request->status);
		}
		
		$users = $users->orderBy('id', 'desc')->paginate(10);
		
		
		return view('admin.users.index', compact('title', 'users'));
	}

	//stores fetching
	public function stores(){
		$title = array(
			'title' => 'Stores',
			'slug'  => 'Stores',
			'active' => 'stores'
		);
		$stores = User::Where('role', 'store')->latest()->paginate(10);
		return view('admin.users.stores',compact('stores'));
	}
	public function create(){
		$title = array(
			'title' => 'Users',
			'slug' => 'User Details',
			'active' => 'users'
		);
		return view('admin.users.create', compact('title'));
	}
	//store
	public function store(Request $request)
    {
		$request->validate([
			'name' => $request->type == 'store' ? 'required|max:100|unique:stores,title' : 'required|max:100|unique:users,name',
			'phone_number' => 'required|min:10|max:12|unique:users,phone_number,',
			'type' => 'required',
			'password' => 'required|min:6',
			'address' => 'required',
			'status' => 'required',
		]);
		$store = new User;
		$store->name = $request->name;
		$store->phone_number = $request->phone_number; 
		$store->password = bcrypt($request->password);
		$store->role = $request->type;
		$store->address = $request->address;
		$store->notes = $request->notes;
		$store->verified = $request->verified;
		$store->verified_at = date("Y-m-d h:i:s");
		$store->status = $request->status;
		$store->save();

		if( $request->type == 'store' )
		{
			Store::create([
				'users_id'=> $store->id,
				'title'  => $request->name,
				'slug'   => Str::slug($request->name, '-')
			]);
		}
		
		$request->session()->flash('success', "User Created Successfully");
		return redirect()->route("admin.users");		
	}
	
	//...
	public function show(Request $request, User $user)
	{
		$title = array(
			'title' => 'Users',
			'slug' => 'User Details',
			'active' => 'users'
		);
		
		return view('admin.users.show', compact('title', 'user'));
		}
	
	//...
	public function edit(Request $request, User $user)
	{
		$title = array(
			'title' => 'Users',
			'slug' => 'Edit User',
			'active' => 'users'
		);
		
		return view('admin.users.edit', compact('title', 'user'));
	}
	
	//...
	public function update(Request $request, User $user)
	{
		$request->validate([
			'name' => 'required',
			'phone_number' => 'required|unique:users,phone_number,'.$user->id,
			'address' => 'required',
			'status' => 'required',
		]);
		
		$user->name = $request->name;
		$user->phone_number = $request->phone_number;
		$user->address = $request->address;
		$user->notes = $request->notes;
		$user->verified = $request->verified;
		$user->status = $request->status;
		$user->save();

		if( $user->role == 'store' )
		{
			Store::updateOrCreate(['users_id' => $user->id],
			[
				'users_id' => $user->id,
				'title'  => $request->name,
				'slug'   => Str::slug($request->name, '-')
			]);
		}
		
		$request->session()->flash('success', "User Updated Successfully");
		return redirect()->route("admin.users");
	}

	//-----
    public function csvExport(Request $request)
    {
		$users = User::all();
		
		//csv
		$filename = auth()->user()->id . date('Y_m_d_h_i');
		
		$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=".$filename.".csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
		
		$columns = array('Name', 'Phone Number', 'City', 'State', 'Zip Code', 'Address', 'Notes', 'Status');
		
		$callback = function() use ($users, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);
			
			foreach($users as $user){
			
				$datas = array();
				

				$status = 'Active';
				if($user->status=='0'){
					$status = 'In-active';
				}
				if($user->status=='2'){
					$status = 'Blocked';
				}

				$datas['Name'] = @$user->name;
				$datas['Phone Number'] = @$user->phone_number;
				$datas['City'] = @$user->city;
				$datas['State'] = @$user->state;
				$datas['Zip Code'] = @$user->zip_code;
				$datas['Address'] = @$user->address;
				$datas['Notes'] = @$user->notes;
				$datas['Status'] = @$status;
				
				fputcsv($file, $datas);
			}
			fclose($file);
		};
		
		
		return response()->stream($callback, 200, $headers);
		
	}

	public function login(Request $request,$id){
		// return $request->all();
		$user = User::find($id);
		Auth::login($user);
		$request->session()->flash('success', "You are successfully login as ".Auth::user()->name);
		return redirect('/store');
	}
}
