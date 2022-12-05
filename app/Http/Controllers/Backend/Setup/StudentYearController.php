<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentYear;

class StudentYearController extends Controller
{
    //view the year
    public function ViewYear(){
        $data['allData']  = StudentYear::all();
        return view('backend.setup.year.view_year', $data);
    }

    //add year
    public function StudentYearAdd(){
        return view('backend.setup.year.add_year');
    }

    public function StudentYearStore(Request $request){
        $validateDate = $request->validate([
                'name'=> 'required|unique:student_years,name',
        ]);
        $data = new StudentYear();
        $data-> name = $request->name;
        $data->save();

        $notification = array([
            'message'=> 'Student Year added Successfully',
            'alert-type' => 'success'
        ]);

        return redirect()->route('student.year.view')->with($notification);
    }

    public function StudentYearEdit($id){
        $editData = StudentYear::find($id);
        return view('backend.setup.year.edit_year', compact('editData'));
    }

    public function StudentYearUpdate(Request $request, $id){
        $data = StudentYear::find($id);
        $validateData = $request->validate([
            'name'=>'required|unique:student_years,name,'.$data->id
        ]);

        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message'=> 'Student Year Updated Successfully',
            'alert-type'=> 'success'
        );

        return redirect()->route('student.year.view')->with($notification);
    }

    public function StudentYearDelete($id){
        $data = StudentYear::find($id);
        $data->delete();

        $notification = array(
            'message'=> 'Student year deleted successfully',
            'alert-type'=> 'info'
        );

        return redirect()->route('student.year.view')->with($notification);
    }
}
