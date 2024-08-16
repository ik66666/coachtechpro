
   
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        AuthenticatesUsers;

    protected $maxAttempts  = 50;   // ログイン試行回数（回）
    protected $decayMinutes = 0;   // ログインロックタイム（分）
    protected $redirectTo   = '/admin/schedule/'; //ログイン後に表示する画面


    /**
     * 認証を無効にする画面を設定
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['index', 'login']);
    }

    /**
     * 使用する認証を設定
     *
     * @return void
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * ログインIDを指定のカラムに変更する
     * （初期値はemail）
     *
     * @return void
     */
    public function username()
    {
        return 'email';
    }

    /**
     * ログイン画面表示
     * @return view
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * 認証の条件を設定
     * ログインID、パスワード、ユーザータイプ、削除日
     *
     * @param Request $request
     * @return void
     */
    public function attemptLogin(Request $request)
    {
        return $this->guard()->attempt([
            'mail' => $request->input('email'),
            'password' => $request->input('password'),
            'type' => config('const.user.authority.administrator'),
            'status' => config('const.user.status.on'),
            'deleted_at' => null,
        ]);
    }

    /**
     * ログアウト
     * @return redirect
     */
    public function logout()
    {
        User::flushEventListeners();
        $this->guard('admin')->logout();
        return redirect()->to('/admin/login_form');
    }
}
