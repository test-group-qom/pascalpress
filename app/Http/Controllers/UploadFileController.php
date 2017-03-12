<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class UploadFileController extends Controller {
   public function index(){
      	$path = public_path() .'\upload';
		$files = scandir($path);
		$images = array();
		$docs = array();
		$vids = array();
		foreach ($files as $file) {
			$extension = File::extension($file);
			$name = File::name($file);
			switch ($extension) {
				case 'bmp':
				case 'png':
				case 'jpeg':
				case 'jpg'://||'bmp'||'png':
					array_push($images, $name);
					break;

				case 'pdf':
				case 'doc':
				case 'docx'://'doc'||'docx'||'pdf':
					array_push($docs, $name);
					break;
				
				case 'mp4':
				case 'avi':
				case 'asf':
				case 'mov':
					array_push($vids, $name);
					break;
			}
		}
		
		echo 'images:';
		print_r($images);
		echo 'documents:';
		print_r($docs);
		echo 'videos:';
		print_r($vids);
   }

   public function showUploadFile(Request $request){
		  $file = array('file' => $request->file('file'));
		  $rules = array('file' => 'required|mimes:jpg,jpeg,bmp,png,doc,docx,pdf,mp4,avi,asf,mov'); //for max size max:10000
		  $validator = \Validator::make($file, $rules);
		  if ($validator->fails()) {
		    // send back to the page with the input data and errors
		    //return Redirect::to('uploadfile')->withInput()->withErrors($validator);
		    return response()->json($validator->errors(), 422);
		  }
		  else {
		      $destinationPath = 'upload'; // upload path
		      $extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $request->file('file')->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      // Session::flash('success', 'Upload successfully'); 
		      // return Redirect::to('upload');
		      return 'upload successfully';
		    
  		}
    }
}