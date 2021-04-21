<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\formations;
use App\Models\machines;
use App\Models\rawMaterials;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;


class CategoryController extends Controller
{

    
    function __construct()
    {
    $this->middleware('permission:categories|crée categorie|modfier categorie|afficher categorie|effacer categorie', ['only' => ['index','show']]);
    $this->middleware('permission:crée categorie', ['only' => ['create','store']]);
    $this->middleware('permission:modfier categorie', ['only' => ['edit','update']]);
    $this->middleware('effacer categorie', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $categories=Category::all();
        $formations=formations::all();
        $machines=machines::all();
        $subcategories=subcategory::all();
        $materials=rawMaterials::all();
        return view('category.index',compact('categories','formations','subcategories','machines','materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category=new Category();
        $category->name=$request->name;
        $category->slug=str_slug($request->name);
        $latestSlug=Category::whereRaw("slug RLIKE'^{$category->slug}(-[0-9])?$'")->latest('id')->value('slug');
        if($latestSlug){
            $pieces=explode('-',$latestSlug);
            $number=intval(end($pieces));
            $category->slug .='-'.($number+1);
        }
        $category->save();

       
        
        $subcategory=new subcategory();
        $subcategory->category_id=$category->id;
        $subcategory->name='Autre';
        $subcategory->slug=str_slug('Autre');
        $latestSlug=subcategory::whereRaw("slug RLIKE'^{$subcategory->slug}(-[0-9])?$'")->latest('id')->value('slug');
        if($latestSlug){
            $pieces=explode('-',$latestSlug);
            $number=intval(end($pieces));
            $subcategory->slug .='-'.($number+1);
        }
         $subcategory->save();

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function getsubcategory($id){
        $subcategories=DB::table('subcategories')->where('category_id',$id)->pluck('name','id');
        return json_encode($subcategories);
  
    }
}
