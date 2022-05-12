<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Developers;
use Image;
class DevelopersController extends Controller
{
     // all books
     public function index()
     {
         $books = Developers::all()->toArray();
         return array_reverse($books);
     }
 
     // add book
     public function add(Request $request)
     {
       
         $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:developers,email',
            'phone_no' => 'required',
            'address' => 'required'
        ]);
   


         $path = '';
         if($request->file()) {

            $image = request()->file('file');
        $imageName = $image->getClientOriginalName();
        $imageName = time().'_'.$imageName;
        $thumbnail = $image->getClientOriginalName();
        $thumbnail= time().'_thumbnail'.$thumbnail;

       
        $image->move(public_path('/images'), $imageName);

           $path = '/images/'.$imageName ;
        }   
         $developer = new Developers([
             'first_name' => $request->input('first_name'),
             'last_name' => $request->input('last_name'),
             'email' => $request->input('email'),
             'phone_no' => $request->input('phone_no'),
             'address' => $request->input('address'),
             'avatar'=>$path 
         ]);
         $developer->save();
 
         return response()->json('The developer successfully added');
     }
 
     // edit book
     public function edit($id)
     {
       
         $book = Developers::find($id);
         return response()->json($book);
     }
 
     // update book
     public function update($id, Request $request)
     {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
            'address' => 'required'
        ]);
   
        $path = '';
        if($request->file()) {

           $image = request()->file('file');
       $imageName = $image->getClientOriginalName();
       $imageName = time().'_'.$imageName;
       $thumbnail = $image->getClientOriginalName();
       $thumbnail= time().'_thumbnail'.$thumbnail;

      
       $image->move(public_path('/images'), $imageName);

          $path = '/images/'.$imageName ;
          $req= [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'address' => $request->input('address'),
            'avatar'=>$path 
          ];
       }else{
        $req = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'address' => $request->input('address')
        ];
       }   
        
         $book = Developers::find($id);
         $book->update($req);
 
         return response()->json('The developer successfully updated');
     }
 
     // delete book
     public function destroy($id)
     {
         $book = Developers::find($id);
         $book->delete();
 
         return response()->json('The developer successfully deleted');
     }
     public function deleteAll($id)
     {  
        $single_user_id = explode(',' , $id);
        foreach($single_user_id as $id) {
            $book = Developers::find($id);
            $book->delete();
        }
 
         return response()->json('The developer successfully deleted');
     }


     

}
