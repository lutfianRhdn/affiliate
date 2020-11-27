<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Mail\EmailConfirmation;
use App\Mail\EmailConfirmationCompany;
use App\Models\Product;
use App\Models\Province;
use App\Models\City;
use App\Models\Company;
use App\Models\Regency;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Contracts\Service\Attribute\Required;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
private $pass ='';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); 
    }

    public function index() {
        $model_product = new Product;
        $product = $model_product->getData();
        // $model_province = new Province;
        // $provinces = $model_province->getData();
        return view("auth.register");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'],
            'password_confirmation' => ['required_with:password','same:password'],
            'company'=>['required','unique:companies,name'],
            'phone' => ['required', 'min:9', 'max:14'],
            'address' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return $validator->errors();
        }
        // dd($data);
            $company = Company::create(['name'=>$data['company']]);
        $data['company_id'] = $company->id;
        $user = new user;
        $this->pass = $data['password'];
        unset($data['company']);
        $user = $user->CreateAdmin($data);
        return $user;
    
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
    
        event(new Registered($user = $this->create($request->all())));
        Mail::to($user->email)->send(new EmailConfirmation($user->id, $this->pass));
        return redirect()->back();
    }
    public function emailConfirmation($email)
    {
        $user = new User;
        $productModel = new Product;
        $product= $user->getProductID($email);
        $user=User::where('email',$email)->get()->first();
        $user->register_status =1;
        $user->save();
        if ($product) {
            $url = $productModel->getUrl($product->product_id);
        }else{
            $company = Company::where('email',$email)->get()->first();
            $company->is_active = 1;
            $company->save();
            $url = null;
        }
        if ($url ==null) {
            return redirect(url('/thankyou.php?st=0'));
        }else{
            $url = $url->url;
        }
        if($user->emailConfirmation($email)){
            // return redirect('login')->with('regis-succ', 'Your account has been successfully activated, now you have to wait for admin approval.');
            return redirect($url);
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $region = DB::table('indoregion_regencies')->select('indoregion_regencies.id', 'indoregion_regencies.name')->where('indoregion_regencies.province_id', $request->id)->get();

        return response()->json($region);
    }

    public function getCity(Request $request)
    {   
        $term = empty($request->term['term']) ? '' : ($request->term['term']);
        $cities = new City;
        $cities = $cities->getCity($request->province, $term);
        
        $result = array();
        foreach ($cities as $key => $value) {
            array_push($result, ['id'=>$value->id, 'text'=>$value->city_name_full]);
        }
        
        return ['results' => $result];
    }
}
