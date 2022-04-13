<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;

class ProductsController extends Controller
{
    public function store(Request $request){

        //melakukan validasi inputan
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
            'type'=>'required|in:makanan,minuman,makeup',
            'price'=>'required|numeric',
            'expired_at'=>'required|date'
        ]);
        //kondisi inputan salah
        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }

        //inputan yang sudah benar
        $validated=$validator->validated();

        //Input ketabel product
        Product::create([
            'nama'=>$validated['name'],
            'type'=>$validated['type'],
            'price'=>$validated['price'],
            'expired_at'=>$validated['expired_at']

        ]);
        return response()->json('produk berhasil disimpan')->setStatus(201);
        
    }
    public function show(){
        $products=product::all();

        return response()->json($product)->setStatusCode(200);
    }
    public function update(Request $request,$id){
         //melakukan validasi inputan
         $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
            'type'=>'required|in:makanan,minuman,makeup',
            'price'=>'required|numeric',
            'expired_at'=>'required|date'
        ]);
        //kondisi inputan salah
        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }
         //inputan yang sudah benar
         $validated=$validator->validated();

         $checkData=Product::find($id);
         // dd($checkdata);

         if($CheckData){

            Product::where('id',$id)
        ->update([
            'nama'=>$validated['name'],
            'type'=>$validated['type'],
            'price'=>$validated['price'],
            'expired_at'=>$validated['expired_at']

        ]);
        return response()->json('data berhasil disunting')->setStatus(201);
    }
    return response()->json('data produk tidak ditemukan')->setStatus(404);

    }
    public function destory($id){
        $checkData=Product::find($id);

        if($checkData){
            product::delete($id);

            return response()->json('data berhasil dihapus')->setStatus(201);
           
        }
    }
    
}
