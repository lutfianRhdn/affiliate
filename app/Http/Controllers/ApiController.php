<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\ProductResource;
use App\Mail\EmailConfirmation;
use App\Models\Client;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class ApiController extends Controller
{

    public function ProductApi(Request $request)
    {
        $product = Product::find($request->id);
        return (new ProductResource($product));
    }

    public function RegisterApi(Request $request,$hash)
    {
        $id = Hashids::decode($hash);
        $product = Product::find($id)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'error' => 'application is not registered'
            ]);
        }
    // check origin url
    // set allowed url
        $allowedHosts = explode(',', env('ALLOWED_DOMAINS'));
        $productUrl = parse_url($product->permission_ip, PHP_URL_HOST);
        array_push($allowedHosts, $productUrl);
    // get url hit 
        $requestHost = parse_url($request->headers->get('origin'),
            PHP_URL_HOST
        );
    // if url request came from != alowed url
        if (!in_array($requestHost, $allowedHosts, False)) {
            abort(403);
        }
        
   
    // Rules
        $Rules = [
            'name-'.$hash => ['required', 'string', 'max:255'],
            'email-'.$hash => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password-'.$hash => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'password_confirmation-'.$hash => ['required_with:password', 'same:password'],
            'phone-'.$hash => ['required', 'min:9','max:12'],
            'address-'.$hash => ['required']
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
            return new ErrorResource([$errors],$hash);
        }

    // on success
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random = substr(str_shuffle($permitted_chars), 0, 6);
        $model_user = new User;
        $regex = $product->getRegex($product->id);
        
        do {
            $ref_code = $regex->regex . '-' . $random;
            $check = $model_user->getRefCode($ref_code);
        } while ($check != null);

        if ($check == null) {
            $role= Role::where('name','reseller')->get()->first();
            $request->request->add(['product_id'=>$product->id,'role'=> $role->id,'ref_code'=>$ref_code]);
            if ($product->company !== null) {
                $request->request->add(['company_id'=>$product->company->id]);
            }
            $user = $model_user->createReseller($request->all());
            $user->assignRole('reseller');
            if ($product->company !== null) {
                $user->assignRole('reseller-'.$product->company->name);
            }else{
                $user->assignRole('reseller-super');
            }
        }
        Mail::to($user->email)->send(new EmailConfirmation($user->id, $request->password));
        addToLog("Menambahkan Reseller" . $request->email, $product->company !== null ?$product->company->id :null);
            // $user->givePermissionTo($user->getPermissionsViaRoles());
            return response()->json(['status'=>'success']);
        }
        public function TransactionClient(Request $request)
        {
            
        }
        public function ClientApi(Request $request,$hash)
        {
            $id = Hashids::decode($hash);
            $product = Product::find($id)->first();    
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'application is not registered'
                ]);
            }
            $Messages=[
                'required'=>[
                    'type'=>'required',
                    'message'=>'The :attribute is required'
                ],
                'date_format'=>[
                    'type'=>'inValid',
                    'message'=> 'The :atribute does not match the format Y-m-d, ex:2020-12-04.'
                ]
            ];
            try {
                $request->validate([
                    'name'=>['required'],
                    'payment_date'=>['required','date_format:Y-m-d']
                ],$Messages);
                
            } catch (Throwable $th) {
                throw $th;
            }
            $clientModel = new Client;
            // return($product->id);
            $request->request->add(['product_id'=>$product->id,'status'=>0]);
            $clientModel->createClient($request->all());
            return response()->json(['status'=>'success','data'=>['name'=>$request->name]]);
        }
    }

