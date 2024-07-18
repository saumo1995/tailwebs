<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
class StudentController extends Controller
{
    public function addStudentData(Request $request){
        $input = $request->all();
        if(!empty($input)){
            if($input['student_id']==''){
                $studentModel = new StudentModel();
                $studentModel['name'] = $input['name'];
                $studentModel['subject'] = $input['subject'];
                $studentModel['mark'] = $input['mark'];
                $studentModel->save();
                $inserId = $studentModel->id;
                if($inserId!=''){
                    echo "1";
                }
                else{
                    echo "0";
                }
            }
            else{
                $id = base64_decode($input['student_id']);
                $studentModel = StudentModel::find($id);
                $studentModel['name'] = $input['name'];
                $studentModel['subject'] = $input['subject'];
                $studentModel['mark'] = $input['mark'];
                $studentModel->save();
                echo "1";
            }
            
        }
    }
    public function studentListing(Request $request){
        $studentModel = new StudentModel();
        $studentData = $studentModel->get();
        return view('listing',compact('studentData'));
    }
    public function getstudentData(Request $request){
        $input = $request->all();
        $id = base64_decode($input['id']);
        $studentDetails = StudentModel::find($id);
        $response = array();
        if(!empty($studentDetails)){
            $response['id'] = $input['id'];
            $response['name'] = $studentDetails->name;
            $response['subject'] = $studentDetails->subject;
            $response['mark'] = $studentDetails->mark;
        }
        echo json_encode($response);
    }
}
