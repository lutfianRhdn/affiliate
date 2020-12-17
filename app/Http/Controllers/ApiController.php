<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientsResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TransactionResource;
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

    // register
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
                return response(['status'=>'Forbiden','error'=>403],403);
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
                
            ];

            // vallidate
            $validator = Validator::make($request->all(), $Rules,$Messages);

            // error hendling
            if ($validator->fails()) {
                $errors = $validator->messages()->getMessages();
                return response(new ErrorResource([$errors],$hash),400);
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
    // end
        public function TransactionClientApi(Request $request,$hash)
        {
            $id = Hashids::decode($hash);
            $product = Product::find($id)->first();    
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'application is not registered'
                ]);
            }
            $rules=[
                'total_payment'=>['required','numeric'],
                'unic_code'=>['required'],
                'ref_code'=>['required'],
                'payment_date'=>['required','date_format:Y-m-d'],
            ];
            $messages=[
                'required'=>[
                    'type'=>'required',
                    'message' =>'The :attribute is required'
                ],
                'numeric'=>[
                    'type'=>'inValid',
                    'message'=>'The :attribute not valid value,must numeric'
                ],
                'date_format'=>[
                    'type'=>'inValid',
                    'message'=>'the :attribute format not valid,format must Y-m-d Ex:2020-12-30'
                ]
            ];
                $this->validate($request,$rules,$messages);
                
                try {
                    $user=User::where('ref_code',$request->ref_code)->firstOrFail();
                } catch (\Throwable $excaption ) {
                    return response([
                    'status'=>'error',
                    'error'=>[
                        'status'=>500,
                        'message'=>$excaption->getMessage()
                    ]
                ],500);
                }
            $client = $user->product->find($id)->first()->clients->where('unic_code',$request->unic_code)->first();
            $client->transactions()->create([
                'total_payment'=>$request->total_payment,
                'payment_date'=> $request->payment_date,
                'status'=>1
            ]);

            return ['status'=>'success','data'=>(new TransactionResource($client))];
        }
        public function RegisterClientApi(Request $request,$hash)
        {
            $id = Hashids::decode($hash);
            $product = Product::find($id)->first();    
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'application is not registered'
                ]);
            }
            $rules=[
                'refCode'=>['required'],
                'unic_code'=>['required'],
                'name'=>['required'],
            ];
            $messages=[
                'required'=>[
                    'type'=>'required',
                    'message' =>'The :attribute is required'
                ]
            ];
                $this->validate($request,$rules,$messages);
            $reseller = User::where('ref_code',$request->refCode)->get();
            if ($reseller->count() ==0) {
                return response([
                    'status'=>'error',
                    'error'=>'your reseller isnt registered'
                ],400);
            }
            $request->request->add(['user_id'=>$reseller->first()->id,'product_id'=>$product->id]);
            $clientsModel = new Client;
            $client = $clientsModel->createClient($request->all());
            return ['status'=>'success','data'=>(new ClientsResource($client))];
        }
    }

