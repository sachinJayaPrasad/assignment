<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\Marklist;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $data['students'] = Students::select('students.*','teachers.name as teacher_name')
                                        ->join('teachers','students.teacher_id','=','teachers.id')
                                        ->get();
        $data['teachers'] = Teachers::get();
        return view('student.index',$data);
    }
    //Add and Edit in single function
    public function add_student(Request $request)
    {
        try{
            $rules = [
                'name'        => 'required|max:50',
                'age'         => 'required|numeric',
                'gender'      => 'required',
            ];
            $messages = [
                'name.required'        => 'Name is required',
                'age.required'         => 'Age is required',
                'gender.required'      => 'Gender is required',
            ];
            $validation = Validator::make($request->all(),$rules,$messages);
            if($validation->fails()){
                return response()->json(['status' => 0,'response' => $validation->errors()->all()]);
            }
            if($request->student_id){
                $student = Students::find($request->student_id);
                $msg = "Successfully updated Student";
            }else{
                $student = new Students();
                $msg = "Successfully added Student";
            }
            $student->name          = $request->name;
            $student->age           = $request->age;
            $student->gender        = $request->gender;
            $student->teacher_id    = $request->teacher;
            $student->save();
            return response()->json(['status'=> 1,'response'=> $msg]);
        }catch(\Exception $e){
            return response()->json(['status' => 0,'response' => [$e->getMessage()]]);
        }
    }
    //Edit function
    public function edit_student(Request $request)
    {
        if ($request->id) {
            $student = Students::where('id',$request->id)->first();
            return response()->json(['status' => true, 'response' => $student]);
        } else {
            return response()->json(['status' => true, 'response' => 'Something went wrong']);
        }
    }
    //Delete function
    public function delete_student(Request $request){
        if($request->id){
            $student_marklist = Marklist::where('student_id',$request->id)->delete();
            $student = Students::find($request->id);
            $student->delete();
            return response()->json(['status'=>true,'response'=>"Successfully deleted student"]);
        }else{
            return response()->json(['status'=>false,'response'=>'Something went wrong']);
        }
    }
}
