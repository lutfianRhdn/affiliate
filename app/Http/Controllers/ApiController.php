<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function ProductApi(Request $request)
    {

        $product = Product::find($request->id);
        return (new ProductResource($product));
    }

    public function RegisterApi(Request $request,$id)
    {

    // Rules
    $product = Product::find($id);
    if (!$product) {
        return response()->json([
            'status' =>'error',
            'error'=> 'application is not registered'
            ]);
    }
        $Rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'password_confirmation' => ['required_with:password', 'same:password'],
            'phone' => ['required', 'between:9,14'],
            'address' => ['required']
        ];

    // messages When Error
        $Messages= [
            'required'=>[
                'type'=> 'required',
                'message'=> 'The :attribute field is required'
            ],
            'unique'=>[
                'type'=> 'already',
                'message'=> 'The :attribute has already been taken.'
            ],
            
            'regex'=>[
                'type'=> 'inValid',
                'message'=> 'Attribute must be contain uppercase and lowercase letter, number and special character.'
            ],
            'confirmed'=>[
                'type'=> 'notMatch',
                'message'=> ':attribute not match.'
            ],
            'same'=>[
                'type'=> 'notMatch',
                'message'=> ':attribute not match.'
            ],
            'required_with'=>[
                'type'=> 'required',
                'message'=> 'The :attribute field is required'
            ],
            'numeric'=>[
                'type'=>'inValid',
                'message'=> 'The :attribute must be a number.'
            ],
            'between'=>[
                'type'=>'limited',
                'message'=> 'The :attribute value :input is not between :min - :max.'
            ],
            // 'password.min'  => [
            //     'code' => 'password_min_:min',
            //     'msg' => 'The password must be at least :min characters.',
            // ],
            // '*.max'=>[
            //     'type'=>'size',
            //     'message'=> 'The password must be at least :max characters.'
            // ],
            // '*.email'=>[
            //     'type'=>'inValid',
            //     'message'=> 'The password must be at least :max characters.'
            // ],
            
        ];

    // vallidate
        $validator = Validator::make($request->all(), $Rules,$Messages);

    // error hendling
        if ($validator->fails()) {
            $errors = $validator->messages()->getMessages();
            return new ErrorResource([ $errors]);
        }

// on success
        $request->request->add(['product_id'=>$id,'role'=> 2]);
        
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random = substr(str_shuffle($permitted_chars), 0, 6);
        $model_user = new User;
        $product = new Product;
        $regex = $product->getRegex($request->product_id);
        do {
            $ref_code = $regex->regex . '-' . $random;
            $check = $model_user->getRefCode($ref_code);
        } while ($check != null);
        if ($check == null) {
            $user = $model_user->createUser($request, $ref_code);
            return response()->json(['status'=>'success']);
        }
    }
}
