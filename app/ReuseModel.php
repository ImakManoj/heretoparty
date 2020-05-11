<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReuseModel extends Model
{
	protected $guarded=[];
    public static function UploadImages($path,$file){
		    if(!empty($file)){
				$imageName = date('YmdHis').'.'.$file->getClientOriginalExtension();
				$file->move(public_path('/'.$path), $imageName);
					$images = $path.'/'.$imageName;
				//$com['companies_images'] = $imageName;
			}else{
					$images='';
			}
			return $images;
    }

        public static function UploadImages1($path,$file,$i){
		    if(!empty($file)){
				$imageName = date('YmdHis').$i.'.'.$file->getClientOriginalExtension();
				$file->move(public_path('/'.$path), $imageName);
					$images = $path.'/'.$imageName;
				//$com['companies_images'] = $imageName;
			}else{
					$images='';
			}
			//dd($images);
			return $images;
    }

    // Model End
}
