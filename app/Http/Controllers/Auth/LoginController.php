<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Kiểm tra tài khoản có bị khóa không
        $credentials['status'] = 1;

        return $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Đăng xuất và chuyển hướng về trang chủ.
     */
    public function logout(Request $request)
    {
        // ✅ Xóa token trong database để ngăn tự động đăng nhập lại
        if (Auth::check()) {
            $user = Auth::user();
    
            $user->remember_token = null;
            $user->save();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->status == 0) {
            throw ValidationException::withMessages([
                'email' => __('Your account has been blocked. Please contact support.'),
            ]);
        }

        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }
}
