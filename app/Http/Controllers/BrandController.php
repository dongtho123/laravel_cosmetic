<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand=Brand::orderBy('id','DESC')->paginate();
        return view('backend.brand.index')->with('brands',$brand);
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.brand.create');
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Brand::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;
        $status=Brand::create($data);
        if($status){
            request()->session()->flash('success','Brand successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('backend.brand.edit')->with('brand',$brand);
    }


    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand=Brand::find($id);
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$brand->fill($data)->save();
        if($status){
            request()->session()->flash('success','Brand successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::find($id);
        if($brand){
            $status=$brand->delete();
            if($status){
                request()->session()->flash('success','Brand successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('brand.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
