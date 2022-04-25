<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $title = array(
			'title' => 'Attributes',
			'slug' => 'Listing All The Attributes',
			'active' => 'attribute'
		);
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes','title')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = array(
			'title' => 'Attributes',
			'slug' => 'Add New Attribute',
			'active' => 'attribute'
		);
        return view('admin.attributes.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'attribute' => 'required|max:100|unique:attributes,attribute',
			'value' => 'required',
		]);

        $store = new Attribute;
        $store->attribute = $request->attribute;
        $store->value = implode(',',$request->value);
        $store->save();
        return redirect()->route('attributes.index')->with('success','Attribute added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        //dd($attribute);
        $title = array(
			'title' => 'Attributes',
			'active' => 'attribute'
		);
        return view('admin.attributes.edit',compact('title','attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
			'attribute' => 'required|max:100|unique:attributes,attribute,'.$attribute->id,
			'value' => 'required',
		]);

        $attribute->attribute = $request->attribute;
       
        $attribute->value = implode(',',$request->value);
        $attribute->save();
        return redirect()->route('attributes.index')->with('success','Attribute Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->back()->with('success', 'Attribute Deleted Successfully');
    }

    public function atrributeById($id){
         $attr = Attribute::find($id);
         $attrValues = explode(',',$attr->value);
         if(!$attr){
           return response()->json(['data'=>[],'message'=>'data not found'],200);
         }
        return response()->json(['data'=>$attrValues,'message'=>'data found'],200);
    }
}
