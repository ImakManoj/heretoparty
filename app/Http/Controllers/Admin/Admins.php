<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use Hash;
use Mail;
use App\User;
use App\Banners;
use App\Iwanttoplans;
use App\Vendorbooks;
use App\Howitworks;
use App\Abouts;
use App\Todolists;
use DB;
use App\Degination;
use App\Ourteam;
use App\Career;
use App\categoryModel as Category;
use App\ReuseModel;
use App\Tag;
use App\subCategoryModel as SubCategory;
use App\countryModel as Country;
use App\cityModel as City;

class Admins extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->username, 'password' => $request->password, 'status' => '1','role'=>'Admin'])) {
            return redirect()->route('admndashboard');
        }  else {
            return back()->with('success','Email Id & password not valid');
        }
    }

    public function dashboard (Request $request){
        return view('Admin.index');
    }

     public function banner(Request $request){
        $response=Banners::get();
        return view('Admin.HomePage',compact('response'));
    }
  public function adminProfile(Request $request){
        $response=DB::table('users')->select('users.*','countries.*','cities.*')->join('countries','countries.id','users.country_id')->join('cities','cities.id','users.city_id')->where('users.id',Auth::User()->id)->where('users.status',1)->first();
            $Country=Country::get();
            $city=City::get();
        return view('Admin.adminProfile',compact('response','Country','city'));
    }

    public function editBanner(Request $request){
          $response=Banners::where('id',$request->id)->first();
          return json_encode($response);
    }
    public function editdegination(Request $request){
          $response=Degination::where('id',$request->id)->first();
          return json_encode($response);
    }
     public function editiwantmyplan(Request $request){
          $response=Iwanttoplans::where('id',$request->id)->first();
          return json_encode($response);
    }


 public function editvendors(Request $request){
          $response=Vendorbooks::where('id',$request->id)->first();
          return json_encode($response);
    }

    public function editaboutus(Request $request){
        $response['about']=Abouts::where('id',$request->id)->first();
        $response['Todolists']=Todolists::where('list_id',$request->id)->get();
        return json_encode($response);
    }
     
 public function edithowitworks(Request $request){
          $response=Howitworks::where('id',$request->id)->first();
          return json_encode($response);
    }

     public function iWantToPlan(Request $request){
        $response=Iwanttoplans::get();
        return view('Admin.iwantoplan',compact('response'));
    }

     public function vendorsRecentlyBooked(Request $request){
        $response=DB::table('Vendorbooks')->select('Vendorbooks.*','countries.*','Vendorbooks.id as vid')->join('countries','countries.id','Vendorbooks.vendorbook_country')->where('Vendorbooks.id','!=',1)->get();
        $heading=Vendorbooks::where('id',1)->first();
        $country=Country::get();
        return view('Admin.venderBooked',compact('response','heading','country'));
    }

     public function howItWorks (Request $request){
        $response=Howitworks::where('id','!=',1)->get();
        $heading=Howitworks::where('id',1)->first();
        return view('Admin.howItWorks',compact('response','heading'));
    }

     public function aboutUs (Request $request){
        $response=Abouts::get();
        return view('Admin.aboutus',compact('response'));
    }

    public function saveBanner(Request $request){
        if(!empty($request->bannerImages)){
                    $imageName = date('YmdHis').'.'.$request->bannerImages->getClientOriginalExtension();
                    $request->bannerImages->move(public_path('/images'), $imageName);
                    $input['banner_images'] = $imageName;
                }
                $input['banner_title']=$request->bannerTitile;
                $input['banner_subtitle']=$request->bannersubTitile;
                if(Banners::where('baner_type',$request->bannertype)->count('id')>0){
                Banners::where('baner_type',$request->bannertype)->update($input);
                }else{
                    $input['baner_type']=$request->bannertype;
                    Banners::create($input);
                }
                return redirect()->back();

    }

    public function saveiwanttoplan(Request $request){
        if(!empty($request->icon)){
                    $imageName = date('YmdHis').'.'.$request->icon->getClientOriginalExtension();
                    $request->icon->move(public_path('/images'), $imageName);
                    $input['iwanttoplan_icon'] = $imageName;
                }

                $input['iwanttoplan_title']=$request->iwantname;
                $input['iwanttoplan_message']=$request->statement;
                if($request->iwantmyplanid==''){
                Iwanttoplans::create($input);
                }else{
                Iwanttoplans::where('id',$request->iwantmyplanid)->update($input);
                }
                return redirect()->back();

    }


    public function saveHeadingTitle(Request $request){
        $input['vendorbook_title']="Heading";
        $input['vendorbook_name']=$request->title;
        Vendorbooks::where('id',1)->update($input);

    }
   public function saveHowitworkedHeadingTitle(Request $request){
        $input['howitwork_title']="Heading";
        $input['howitwork_statement']=$request->title;
        Howitworks::where('id',1)->update($input);
    }

    public function saveVendorBooked(Request $request){
        $input['vendorbook_name']=$request->iwantname;
        $input['vendorbook_country']=$request->country;
        $input['vendorbook_rating']=$request->Rank;
          if(!empty($request->images)){
                    $imageName = date('YmdHis').'.'.$request->images->getClientOriginalExtension();
                    $request->images->move(public_path('/images'), $imageName);
                    $input['vendorbook_images'] = $imageName;
        }
        if($request->vendorid==''){
            Vendorbooks::create($input);
        }else{
            Vendorbooks::where('id',$request->vendorid)->update($input);
        }
        
        return redirect()->back();
    }


    public function savehowitworks(Request $request){
        $input['howitwork_name']=$request->iwantname;
        $input['howitwork_statement']=$request->content;
          if(!empty($request->images)){
                    $imageName = date('YmdHis').'.'.$request->images->getClientOriginalExtension();
                    $request->images->move(public_path('/images'), $imageName);
                    $input['howitwork_icon'] = $imageName;
        }
        if($request->howitworkid==''){
        Howitworks::create($input);
        }else{
        Howitworks::where('id',$request->howitworkid)->update($input);
        }
        return redirect()->back();
    }

    public function saveaboutus(Request $request){
        $input['about_statement']=$request->content;
        $input['about_title']=$request->title;
        $input['page_type']=$request->pagetype;
       if(!empty($request->images)){
                    $imageName = date('YmdHis').'.'.$request->images->getClientOriginalExtension();
                    $request->images->move(public_path('/images'), $imageName);
                    $input['about_image'] = $imageName;
        }
       $aboutUs=Abouts::create($input);

       if(!empty($request->todolist)){
        if(sizeof($request->todolist)>0){
            for($i=0;$i<sizeof($request->todolist);$i++){
                $data['todolist_title']=$request->todolist[$i];
                $data['todolist_yes']=1;
                $data['list_id']=$aboutUs->id;
               Todolists::create($data);
            }
        }
    }
        return redirect()->back();
    }

    public function degination(Request $request){
        $response=Degination::where('status',1)->get();
        return view('Admin.degination',compact('response'));
    }

    public function savedegination(Request $request){
        $input['deginatin_name']=$request->degination;
        if($request->deginationid!=''){
            Degination::where('id',$request->deginationid)->update($input);
        }else{
            Degination::create($input);
        }
        return redirect()->back();
    }

    public function ourteam(Request $request){
        $response=Degination::where('status',1)->get();
        $outTeam=ourTeam::with('RelationDetination')->get();
        return view('Admin.ourteam',compact('response','outTeam'));
    }

    public function savedOurTeam(Request $request){
         $input['team_name']=$request->name;
        $input['degination_id']=$request->degination;
       if(!empty($request->images)){
                    $imageName = date('YmdHis').'.'.$request->images->getClientOriginalExtension();
                    $request->images->move(public_path('/images'), $imageName);
                    $input['images'] = $imageName;
        }
         Ourteam::create($input);
        return redirect()->back();

    }

public function careers(Request $request){
     $response=Career::get();
    return view('Admin.careers',compact('response'));
}

    public function savedCareers(Request $request){
        $input['career_title']=$request->heading;
        $input['career_title1']=$request->heading2;
        $input['career_statement']=$request->content;
       if(!empty($request->images)){
                    $imageName = date('YmdHis').'.'.$request->images->getClientOriginalExtension();
                    $request->images->move(public_path('/images'), $imageName);
                    $input['career_images'] = $imageName;
        }
        Career::create($input);
        return redirect()->back();
    }


    public function adminCategory(Request $request){
      $records =Category::where('categories_status','1')->get();
      return view('Admin.Category',compact('records'));
    }

    public function addcategories(Request $request){
        $array=array(
          'category_name'=>$request->category,
          'user_id'=>Auth::user()->id
        );
        if($request->category_id!=''){
          Category::where('id',$request->category_id)->update($array);
        }else{
          Category::create($array);
        }
        return redirect()->back();
    }

    public function GetCatById(Request $request){
      $category= Category::where('id',$request->id)->first();
      return json_encode($category);
    }


    public function addtags(Request $request){
        $array=array(
          'tag_name'=>$request->category,
          'user_id'=>Auth::user()->id
        );
        if($request->category_id!=''){
          Tag::where('id',$request->category_id)->update($array);
        }else{
          Tag::insert($array);
        }
        return redirect()->back();
    }





    public function tags(Request $request){
      $records=Tag::get();
      return view('Admin.tags',compact('records'));
    }



    public function adminService(Request $request){
      $categories=Category::where('categories_status',1)->get();
      return view('Admin.vendorServices',compact('categories'));
    }


    public function addServicesByadmin(Request $request){
      $array=array(
                    'name'=>$request->service,
                    'user_id'=>Auth::User()->id,
                    'category_id'=>$request->CategoryName
                  );
        SubCategory::create($array);
        return redirect()->back();
    }


    public static function getServices($id){
      return SubCategory::where('category_id',$id)->where('subcategorie_status',1)->get();
    }


public function adminUpdateProfile(Request $request){

    $array=array(
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'mobile'=>$request->mobile,
            'country_id'=>$request->country_name,
            'city_id'=>$request->city_name,
            'images'=>ReuseModel::UploadImages('profiles',$request->imageUpload)
        );
   
    User::where('id',Auth::User()->id)->update($array);

    return redirect()->back();

}

/* End  Controller */

}
