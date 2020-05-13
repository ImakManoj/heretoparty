<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use Illuminate\Http\Request;
use DB;
use Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $categories = Category::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $categories = Category::latest()->paginate($perPage);
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Category::create($requestData);

        return redirect('admin/categories')->with('flash_message', 'Category added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $category = Category::findOrFail($id);
        $category->update($requestData);

        return redirect('admin/categories')->with('flash_message', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return redirect('admin/categories')->with('flash_message', 'Category deleted!');
    }


    public function voice(Request $request){
        $records=DB::table('voice')->where('id',$request->id)->first();
        return view('admin.categories.voice_create',compact('records'));
    }

    public function voiceSave(Request $request){
        if(!empty($request->images)){
            $imageName = time().'.'.$request->images->getClientOriginalExtension();
            $request->images->move(public_path('/images'), $imageName);
            $input['image'] = $imageName;
        }

         if(!empty($request->flag)){
            $imageName = time().'.'.$request->flag->getClientOriginalExtension();
            $request->flag->move(public_path('/images/flag'), $imageName);
            $input['flag'] = $imageName;
        }

          if(!empty($request->voice)){
            $imageName = time().'.'.$request->voice->getClientOriginalExtension();
            $request->voice->move(public_path('/voice'), $imageName);
            $input['voices'] = $imageName;
        }


        $input['name']=$request->name;

        if($request->voiceid!=''){
                  DB::table('voice')->where('id',$request->voiceid)->update($input);
                   Session::flash('message', 'Your voice successfully updated!');
        }else{
                  DB::table('voice')->insert($input);
                   Session::flash('message', 'Your voice successfully created!');
        }
    return redirect()->route('voice',['key'=>$request->voiceid]);
}



public function voicelist(Request $request){
    $records=DB::table('voice')->where('status',1)->get();
    return view('admin.categories.voicelist',compact('records'));
}

public function nature(Request $request){
  return view('admin.nature.index');
}

public function addNature(Request $request){
  return view('admin.nature.addnature');
}

public function natureSave(Request $request){

           if(!empty($request->images)){
              $imageName = time().'.'.$request->images->getClientOriginalExtension();
              $request->images->move(public_path('/images/flag'), $imageName);
              $input['nature_image'] = $imageName;
          }

            if(!empty($request->voice)){
              $imageName = time().'.'.$request->voice->getClientOriginalExtension();
              $request->voice->move(public_path('/voice'), $imageName);
              $input['nature_sound'] = $imageName;
          }

                  $input['nature_name']=$request->name;

                  if($request->voiceid!=''){
                            //DB::table('nature')->where('id',$request->voiceid)->update($input);
                             Session::flash('message', 'Your voice successfully updated!');
                  }else{
                            DB::table('nature')->insert($input);
                             Session::flash('message', 'Your voice successfully created!');
                  }
              return redirect()->route('nature');
}
//  End controller
}
