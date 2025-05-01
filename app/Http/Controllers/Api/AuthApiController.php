<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Google_Client; // Thêm Google_Client để xác thực token

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Sai thông tin đăng nhập'], 401);
        }

        if ($user->status == 0) {
            return response()->json(['message' => 'Tài khoản đã bị khóa'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $coins = DB::table('user_coins')
            ->where('user_id', $user->id)
            ->sum('coins_change');

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'coins' => $coins
            ],
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ', 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 1
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        DB::table('user_coins')->insert([
            'user_id' => $user->id,
            'coins_change' => 10,
            'reason' => 'Tặng người dùng mới',
            'created_at' => now()
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'coins' => 10
            ],
            'token' => $token
        ]);
    }

    public function googleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_token' => 'required|string',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ', 'errors' => $validator->errors()], 422);
        }

        $idToken = $request->input('id_token');
        $email = $request->input('email');

        // Khởi tạo Google Client để xác thực token
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]); // Lấy client_id từ .env
        $payload = $client->verifyIdToken($idToken);

        if (!$payload) {
            return response()->json(['message' => 'Token Google không hợp lệ'], 401);
        }

        // Kiểm tra email từ payload có khớp với email gửi lên không
        if ($payload['email'] !== $email) {
            return response()->json(['message' => 'Email không khớp với token'], 401);
        }

        // Tìm hoặc tạo người dùng
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Nếu người dùng chưa tồn tại, tạo mới
            $user = User::create([
                'name' => $payload['name'] ?? 'Người dùng Google',
                'email' => $email,
                'password' => bcrypt(uniqid()), // Tạo mật khẩu ngẫu nhiên vì đăng nhập Google không cần mật khẩu
                'status' => 1
            ]);

            // Tặng 10 xu cho người dùng mới
            DB::table('user_coins')->insert([
                'user_id' => $user->id,
                'coins_change' => 10,
                'reason' => 'Tặng người dùng mới (Google)',
                'created_at' => now()
            ]);
        } else {
            // Kiểm tra trạng thái tài khoản
            if ($user->status == 0) {
                return response()->json(['message' => 'Tài khoản đã bị khóa'], 403);
            }
        }

        // Tạo token cho người dùng
        $token = $user->createToken('auth_token')->plainTextToken;

        // Lấy số dư xu
        $coins = DB::table('user_coins')
            ->where('user_id', $user->id)
            ->sum('coins_change');

        return response()->json([
            'message' => 'Đăng nhập Google thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'coins' => $coins
            ],
            'token' => $token
        ]);
    }

    public function fetchUserCoins(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập'], 401);
        }

        $userId = Auth::id();
        $coins = DB::table('user_coins')
            ->where('user_id', $userId)
            ->sum('coins_change');

        return response()->json([
            'message' => 'Lấy số dư xu thành công',
            'coins' => $coins
        ]);
    }

    public function getUser(Request $request, $id)
    {
        // Kiểm tra người dùng đã đăng nhập và có quyền truy cập
        if (Auth::id() != $id) {
            return response()->json(['message' => 'Không có quyền truy cập'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], 404);
        }

        return response()->json([
            'message' => 'Lấy thông tin người dùng thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        // Kiểm tra người dùng đã đăng nhập và có quyền truy cập
        if (Auth::id() != $id) {
            return response()->json(['message' => 'Không có quyền truy cập'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], 404);
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ', 'errors' => $validator->errors()], 422);
        }

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->save();

        return response()->json([
            'message' => 'Cập nhật thông tin thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        ]);
    }
}