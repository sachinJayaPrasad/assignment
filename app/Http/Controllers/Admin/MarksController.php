<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Students;
use App\Models\Marklist;

class MarksController extends Controller
{
    public function index(Request $request)
    {
        $data['marklists'] = Marklist::select('students.*','marklists.*','students.name as student_name')
                                        ->leftjoin('students','marklists.student_id','=','students.id')
                                        ->get();
        $data['students'] = Students::get();
        return view('marks.index',$data);
    }
     //Add function
    public function add_marks(Request $request)
    {
        try{
            $rules = [
                'student_id'    => 'required',
                'term'          => 'required',
                'marks_maths'   => 'required',
                'marks_science' => 'required',
                'marks_history' => 'required',
            ];
            $messages = [
                'student_id.required'  => 'Select a student',
                'marks.required'       => 'Mark is required',
            ];
            $validation = Validator::make($request->all(),$rules,$messages);
            if($validation->fails()){
                return response()->json(['status'=>0,'response'=>$validation->errors()->all()]);
            }
            if($request->mark_id){
                $mark = Marklist::where('id',$request->mark_id)->first();
                $msg = "Successfully updated Marklist";
            }else{
                $mark = new Marklist();
                $msg = "Successfully added Marklist";
            }
            $mark->student_id    = $request->student_id;
            $mark->term          = $request->term;
            $mark->marks_maths   = $request->marks_maths;
            $mark->marks_history = $request->marks_history;
            $mark->marks_science = $request->marks_science;
            $mark->save();
            return response()->json(['status'=>1,'response'=>$msg]);
        }catch(\Exception $e){
            return response()->json(['status'=>0,'response'=>[$e->getMessage()]]);
        }
    }
    //Edit function
    public function edit_marks(Request $request)
    {
        if ($request->id) {
            $mark = Marklist::where('id',$request->id)->first();
            return response()->json(['status' => true, 'response' => $mark]);
        } else {
            return response()->json(['status' => true, 'response' => 'Something went wrong']);
        }
    }
    //Delete function
    public function delete_marks(Request $request){
        if($request->id){
            $mark = Marklist::find($request->id);
            $mark->delete();
            return response()->json(['status'=>true,'response'=>"Successfully deleted marks"]);
        }else{
            return response()->json(['status'=>false,'response'=>'Something went wrong']);
        }
    }
}
