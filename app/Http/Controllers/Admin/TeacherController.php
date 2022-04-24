<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teachers;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $data['teachers'] = Teachers::get();
        return view('teacher.index',$data);
    }
    //Add and Edit in single function
    public function add_teacher(Request $request)
    {
        try{
            $rules = [
                'name'  => 'required|max:50',
            ];
            $messages = [
                'name.required'  => 'Name is required',
            ];
            $validation = Validator::make($request->all(),$rules,$messages);
            if($validation->fails()){
                return response()->json(['status' => 0,'response' => $validation->errors()->all()]);
            }
            if($request->teacher_id){
                $student = Teachers::find($request->teacher_id);
                $msg = "Successfully updated Teacher";
            }else{
                $student = new Teachers();
                $msg = "Successfully added Teacher";
            }
            $student->name  =  $request->name;
            $student->save();
            return response()->json(['status'=> 1,'response'=> $msg]);
        }catch(\Exception $e){
            return response()->json(['status' => 0,'response' => [$e->getMessage()]]);
        }
    }
    //Edit function
    public function edit_teacher(Request $request)
    {
        if ($request->id) {
            $teacher = Teachers::where('id',$request->id)->first();
            return response()->json(['status' => true, 'response' => $teacher]);
        } else {
            return response()->json(['status' => true, 'response' => 'Something went wrong']);
        }
    }
    //Delete function
    public function delete_teacher(Request $request){
        if($request->id){
            $teacher = Teachers::find($request->id);
            $teacher->delete();
            return response()->json(['status'=>true,'response'=>"Successfully deleted teacher"]);
        }else{
            return response()->json(['status'=>false,'response'=>'Something went wrong']);
        }
    }
}
