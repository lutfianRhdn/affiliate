<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Mail\EmailConfirmation;
use App\Models\Product;
use App\Models\Province;
use App\Models\City;
use App\Models\Regency;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function index() {
        $product = Product::all();
        $provinces = Province::orderBy('province_name')->get();
        return view("auth.register", ['products' => $product, 'provinces' => $provinces]);
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
            'phone' => ['required', 'min:9', 'max:14'],
            'product_id' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'address' => ['required'],
            'policy' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    private function generateRandomRegex($regex) {
        do {
            $randToken = strtoupper(Str::random(6));
        } while((DB::table('users')->select('regex')->where('users.regex', '=', $regex.$randToken)->get())[0]->regex);
    }

    protected function create(array $data)
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random = substr(str_shuffle($permitted_chars), 0, 6);
        $regex = DB::table('products')->select('products.regex')->where('products.id', $data['product_id'])->first();
        do{
            $ref_code = $regex->regex.$random;
            $check = User::where('ref_code', $ref_code)->first();
        }while($check != null);

        if($check == null){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'product_id' => $data['product_id'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'ref_code' => $ref_code,
                'country' => $data['country'],
                'state' => $data['state'],
                'region' => $data['city'],
                'address' => $data['address'],
            ]);
        }
        $pass = $data['password'];
        
        Mail::to($user['email'])->send(new emailConfirmation($user->id, $pass));
        return $user;
    }

    public function emailConfirmation($email, $ref_code)
    {
        User::where([
            'email' => $email,
            'ref_code' => $ref_code])
            ->update([
                'register_status' => '1']);
                
        return redirect('login')->with('regis-succ', 'Email activated!');
    }

    public function store(Request $request)
    {
        $region = DB::table('indoregion_regencies')->select('indoregion_regencies.id', 'indoregion_regencies.name')->where('indoregion_regencies.province_id', $request->id)->get();

        return response()->json($region);
    }

    public function getCity(Request $request)
    {
        $cities = new City;
        $cities = $cities->getCity($request->province);
        
        $result = array();
        foreach ($cities as $key => $value) {
            array_push($result, ['id'=>$value->id, 'text'=>$value->city_name_full]);
        }
        
        return ['results' => $result];
    }
}
