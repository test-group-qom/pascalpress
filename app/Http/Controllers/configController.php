<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

class configController extends Controller
{
    protected $rule = [
        'key' => ['required','unique:configs'],
        'value' => ['required'],
    ];

    /**
        * Display a listing of the resource.
        * @return Response
        */
        public function index(Request $request)
        {
            return \App\Config::all();
        }

         /**
        * Display the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
           $conf = \App\Config::find($id);
           if(empty($news)){
                return response('',404);
            }
            return $conf;
        }
        
        /**
        * Store a newly created resource in storage.
        * @return Response
        */
        public function store(Request $request)
        {
            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);

            $configs = new Config;
            $configs->key = $request->input('key');
            $configs->value = $request->input('value');
            $configs->save();

            return response(array('configs' => $configs), 201); 
            //201 is the HTTP status code (HTTP/1.1 201 created) for created   
        }
    
        /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
        public function update(Request $request,$id)
        {
            $config = \App\Config::find($id);
            if(empty($config) ){
            	return response('',404);
            }
            
            $validator = \Validator::make($request->all(), [
                'key' => ['required','unique:configs,key,'.$id],
                'value' => ['required']
            ]);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);
            
            $config->key = $request->input('key');
            $config->value = $request->input('value');
            $config->save();

            return response(array('configs' => $config), 201);           
        }

        /**
        * Remove the specified resource from storage.
        * @param  int  $id
        * @return Response
        */
        public function delete($id)
        {
            $config = Config::find($id);
            $config->delete();
            return response('soft Deleted.', 200);
        }
    
        /**
        * Remove the specified resource from storage.
        * @param  int  $id
        * @return Response
        */
        public function destroy($id)
        {
            $config = Config::find($id);
            $config->forceDelete();
            return response('force Deleted.', 200);
        }

        public function restore($id)
        {
            Config::withTrashed()->find($id)->restore();
            return response('restore.', 200);
        }
}
