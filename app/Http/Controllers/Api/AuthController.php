<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Company;
use App\Models\Member;
use App\Models\Role;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailResetPassword;
use Redirect;
/**
 * @group Authentication
 *
 * APIs for Login and Logout
 */
class AuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function register(Request $request)
    {
      // get company
      $company = Company::where("code", "=", $request->code)->first();
      if (!isset($company)) {
        return response()->json(['error' => '会社コードがありません。','status_code'=>422], 422);
      }

      // get roles
      $role = Role::where("guard_name", "=", "user")->first();

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'roles_id' => $role->id
      ]);

      // create member
      $member = Member::create([
        'user_id' => $user->id,
        'company_id' => $company->id,
        'name' => $user->name,
        'email' => $user->email,
      ]);

      $token = auth('api')->login($user);

      return $this->respondWithToken($token);
    }

    /**
     * Login
     *
     * Get a JWT via given credentials.
     *
     * @bodyParam email string required email of user.
     * @bodyParam password string required password of user.
     *
     * @responseFile 200 responses/login.json
     * @responseFile 401 responses/login_error.json
     */
    public function login()
    {
        $email = request('email');
        if (!isset($email)) {
            return response()->json(['error' => 'メールは必須項目です。','status_code'=>422], 422);
        }
        $password = request('password');
        if (!isset($password)) {
            return response()->json(['error' => 'パスワードは必須項目です。','status_code'=>422], 422);
        }

        $credentials = request(['email', 'password']);
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'ログインできない。','status_code'=>422], 422);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'ログアウトは完了しました','status_code'=>200], 200);
    }

    public function forgotPassword(Request $request)
    {
        $email = request('email');
        if (!isset($email)) {
            return response()->json(['error' => 'メールがありません。','status_code'=>422], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => "メールアドレスが存在していません。"
            ], 404);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
            ]
        );
        if ($user && $passwordReset) {
            Mail::to($user->email)->send(new SendMailResetPassword($passwordReset->token));
        }
        return response()->json(['message' => 'あなたのメールアドレスにパスワードリセットのリンクが送信されました。','status_code'=>200], 200);

    }

    public function resetPassword(Request $request)
    {
        $token = $request->token;
        $passwordReset = PasswordReset::where('token', $request->token)->first();
        if (!$passwordReset) return view('emails/result')->with('message','このパスワードリセットトークンは無効です。');
        return view('emails/change-password')->with('token',$token);
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'password' => 'required | string | confirmed'
        ]);
        $passwordReset = PasswordReset::where('token', $request->token)->first();
        if (!$passwordReset) return view('emails/result')->with('message','このパスワードリセットトークンは無効です。');
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) return view('emails/result')->with('message','そのメールアドレスのユーザーは見つかりません。');
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        return view('emails/result')->with('message','パスワードリセットが完了しました。');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        try {
            $user = auth('api')->user();
            $current_timestamp = Carbon::now()->timestamp;
            $time_stamp= ( auth('api')->factory()->getTTL() * 60000) + $current_timestamp;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'name' => $user->name,
                'email' => $user->email,
                'expires_in' => $time_stamp
              ]);
        }catch (\Exception $exception) {
            return [
                'status_code' => 422,
                'error' => 'Login failse'
            ];
        }

    }
}
