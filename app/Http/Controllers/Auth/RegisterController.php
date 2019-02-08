<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
use App\Country;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Mail\CodeVerification;
use App\Mail\RegisterNotification;
use App\Rules\AlphaName;
use App\Rules\CodeCheck;
use App\Rules\GenerationVali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

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

    /*
        User->status
        初期値が0
        メール認証済みが2
        本登録済みが1
        退会済みが9

        既存メンバーで、仮登録未完了だが登録されているユーザーには3を付与。
    
    
    
    
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:6','confirmed'],
            'code' => ['required', new CodeCheck],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_verify_token' => base64_encode($data['email']),
        ]);

        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
    }

    public function confirm(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->flashOnly('email');
        $bridge_request = $request->all();
        $bridge_request['password_mask'] = '********';
        $bridge_request['code_mask'] = '********';
        if (DB::table('codes')->where('code', $request->code)->exists()) { 
            return view('auth.register_confirm_create')->with($bridge_request);
        } else {
            $user = User::where('identification_code', $request->code)->first();
            return view('auth.register_confirm_update', compact('user'))->with($bridge_request);
        }
    }

    public function register(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));
        DB::table('codes')->where('code', $request->code)->delete();
        return view('auth.registered');
    }

    public function registerExistingUser(Request $request)
    {
        $user = User::where('identification_code', $request->code)->first();
        $user->update([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verify_token' => base64_encode($request->email),
        ]);
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
        return view('auth.registered');
    }

    public function showForm(string $email_token) {
        if(!User::where('email_verify_token', $email_token)->exists()) {
            return view('auth.error',['message' => '無効なトークンです。']);
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            if ($user->status === 1) {
                return view('auth.error',['message' => '既に登録されています。']);
            }
            $user->status = 2;
            if ($user->save()) {
                $max = User::max('generation');
                return view('auth.main.register', compact(['email_token', 'user', 'max']));
            } else {
                return view('auth.error',['message' => '途中でエラーが発生しました。']);
            }
        }
    }

    public function mainCheck(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'max:255', new AlphaName],
            'year' => ['required', 'digits:4'],
            'department' => ['required', Rule::in(['経済学部','経営学部','教育学部','都市科学部','理工学部'])],
            'major' => ['required', Rule::in(['経済学科','経営学科','教育学科','都市社会共生学科','環境リスク共生学科','建築学科','都市基盤学科','数物・電子情報系学科','化学・生命系学科','機械・材料・海洋系学科'])],
            'generation' => ['required', new GenerationVali],
            'countries' => ['nullable', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'isOB' => ['nullable', 'in:1'],
            'job' => ['nullable', 'string', 'max:255'],
        ]);

        $email_token = $request->email_token;
        $countries = $request->countries;

        $user = new User;
        $user->name = $request->name;
        $user->year = $request->year;
        $user->department = $request->department;
        $user->major = $request->major;
        $user->generation = $request->generation;
        $user->university = $request->university;
        $user->isOB = $request->input('isOB', 0);
        $user->job = $request->job;
        
        return view('auth.main.register_confirm', compact(['user', 'email_token', 'countries']));
    }

    public function mainRegister(Request $request)
    {
        $user = User::where('email_verify_token', $request->email_token)->first();

        $user->status = 1;
        $user->name = $request->name;
        $user->identification_code = null;
        $user->year = $request->year;
        $user->department = $request->department;
        $user->major = $request->major;
        $user->generation = $request->generation;
        
        if($request->university !== null)
        {
            $uni_temp = mb_convert_kana($request->university, 's');
            $unis = preg_split('/[\s,]+/', $uni_temp, -1, PREG_SPLIT_NO_EMPTY);
            $university = '';
            foreach($unis as $u)
            {
                $university .= $u.' ';
            }
            $user->university = $university;
        } else {
            $user->university = $request->university;
        }

        $user->isOB = $request->isOB;
        $user->job = $request->job;
        $user->save();
        
        if($request->countries !== null)
        {
            $country_ids = getCountryIdsFromRequest($request->countries);
            $user->Countries()->sync($country_ids);
        }

        Mail::to($user->email)->send(new RegisterNotification($user));

        return view('auth.main.registered');
    }
}