<?php

namespace App\Http\Controllers\Backend\Setup;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeCategory;

class FeeCategoryController extends Controller
{


    public  function ViewFeeCat(){
        $data['allData'] = FeeCategory::all();
        return view('backend.setup.fee_category.view_fee_cat', $data);
    }

    public function AddFeeCat(){
        return view('backend.setup.fee_category.add_fee_cat');
    }

    public function StoreFeeCat(Request $request ){
        $validateData = $request->validate([
         'name'=> 'required|unique:fee_categories,name',
        ]);

        $data = new FeeCategory();
        $data->name = $request->name;
        $data->save();

        $notification = array(
         'message' => 'Student Class Inserted Successfully',
         'alert-type'=> 'success'
        );
        return redirect()->route('fee.category.view')->with($notification);
     }
     public function EditFeeCat($id){
       $editData  = FeeCategory::find($id);
       return view('backend.setup.fee_category.edit_fee_cat', compact('editData'));
    }

    public function UpdateFeeCat(Request $request,$id){
        $data = FeeCategory::find($id);

        $validateData = $request->validate([
            'name'=> 'required|unique:fee_categories,name,'.$data->id
        ]);

        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message'=>'Fee Category Updated Successfully',
            'alert-type'=> 'success'
        );

        return redirect()->route('fee.category.view')->with($notification);
    }

    public function DeleteFeeCat($id){
        $data = FeeCategory::find($id);
        $data->delete();

        $notification = array(
            'message'=>'Fee Category Deleted Successfully',
            'alert-type'=> 'info'
        );
        return redirect()->route('fee.category.view')->with($notification);
    }
}
