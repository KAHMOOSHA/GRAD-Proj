<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\order;
use App\Models\User;
use App\Models\Category;
use DB;

class AdminController extends Controller
{
    public function product(){
        $cat = DB::table('categories')
                         ->get();
        return view('admin.product',compact('cat'));                 
    }
    public function uploadproduct(Request $request){
        try{
            $image=$request->file;
            $imagename =time().'.'.$image->getClientOriginalExtension();
            $request->file->move('productimage', $imagename);
            $product = new product([
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'image' => $imagename,
                'category_id' => $request->category_id,
            ]);
            $product->save();
            return redirect()->back();
        }catch(\EXeption $ex){
                return $ex;
        }
    }

    public function showproduct(){
        $data=product::all();
        return view('admin.showproduct',compact('data'));
    }

    public function deleteproduct($id){
        $data=product::find($id);
        $data->delete();
        return redirect()->back()->with('msg', 'Delete succeeded !');
    }
    public function updateproduct($id){
        $data=product::find($id);
        $category_name = category::find($data->category_id); 
        $cat = DB::table('categories')
                        ->where('id',"!=",$data->category_id)
                        ->get();    
        return view('admin.updateproduct',compact('data' ,'category_name' ,'cat'));
    }

    public function updateproductpost(Request $request ,$id){
        $data=product::find($id);
        $image=$request->file;
        if($image){
            $imagename =time().'.'.$image->getClientOriginalExtension();
            $request->file->move('productimage', $imagename);
            $data->image=$imagename;
        }
        $data->title=$request->title;
        $data->price=$request->price;
        $data->description=$request->description;
        $data->quantity=$request->quantity;
        $data->category_id=$request->category_id;
        $data->save();
        return redirect()->back()->with('msg', 'Update succeeded !');;
    }
    public function searchproduct(Request $request){
        if($request->has('search')){
            $search=$request['search'];
            $data=product::where('title','Like','%'.$search.'%')->get();
             return view('admin.showproduct',compact('data'));
        }
        return redirect()->back();
    }
    public function showorder(){
        $order=order::all();
        $data=product::all();
        $userInfo=user::all();
        return view('admin.showorder',compact('order','data','userInfo'));
    }
    public function confirmorder($id){
        $order=order::find($id);
        $data=product::select('quantity')->where('id', $order->product_id)->get();
       // if($data > $order->quantity){
            if($order->status == null || $order->status == 'reject'){
                $order->status='delivered';
                $order->save();
                product::where('id', $order->product_id)->decrement('quantity', $order->quantity);
                return redirect()->back()->with('msg', 'Delivered Succeeded !'); 
            }else{
                return redirect()->back()->with('msg', 'The Order Already Delivered !');
            }
        //}else{
          //  return redirect()->back()->with('msg', 'The operation cannot be completed, the order quantity is not available !');
        //}
    }
    public function rejectorder($id){
        $order=order::find($id);
        if($order->status == null){
            $order->status='reject';
            $order->save();
            return redirect()->back()->with('msg', 'Rejected Succeeded! !'); 
        }else if ($order->status == 'delivered'){
            return redirect()->back()->with('msg', 'The Order Already Delivered !');
        }else{
            return redirect()->back()->with('msg', 'The Order Already Rejected !');
        }
    }
    public function viewcustomer(){
        $users=user::where("usertype","0")->get();
        return view('admin.viewcustomer',compact('users'));
    }

    public function searchcustomer(Request $request){
        if($request->has('search')){
            $search=$request['search'];
            $users=user::where('name','Like','%'.$search.'%')->where("usertype","0")->get();
             return view('admin.viewcustomer',compact('users'));
        }
        return redirect()->back();
    }
    public function admin(){
        return view('admin.addadmin');
    }
    public function addadmin(Request $request){
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $address = $request['address'];
        $password = $request['password'];
        $usertype = 1;
        $result = DB :: table('users')->Insert(['name'=>$name ,'email'=>$email, 'phone'=>$phone , 'address'=>$address , 'password'=>$password , 'usertype'=>$usertype]);
     
        return redirect()->back()->with('msg', 'Add Admin succeeded !');
    }
    public function category(){
        return view('admin.addcategory');
    }
    public function addcategory(Request $request){
       // $name = $request['name'];
        //$cat = category::where('name',$name)->get();
        //if($cat == null){
            $category = new category([
                'name' => $request->name,       
            ]);
            $category->save();
       // }
        return redirect()->back()->with('msg', 'Add Category succeeded !');
    }
}
