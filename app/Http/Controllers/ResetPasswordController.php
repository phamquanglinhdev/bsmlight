<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordEmail;
use App\Models\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function forgotPasswordView(): View
    {
        return view("auth.forgot-password");
    }

    /**
     * @throws ValidationException
     */
    public function sendPasswordConfirmation(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'uuid' => 'required',
            'email' => 'required|email'
        ]);
        /**
         * @var User $user
         */
        $user = User::query()->where('uuid', $request->get('uuid'))->first();

        if (!$user) {
            return redirect()->back()->withErrors(['uuid' => 'Không tìm thấy tài khoản trên hệ thống']);
        }

        if ($user->email !== $request->get('email')) {
            return redirect()->back()->withErrors(['email' => 'Email không chính xác']);
        }
        $token = Str::random();

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'uuid' => $user->uuid,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $resetLink = env('APP_URL') . "/reset-password?token=$token";

        Mail::to($user->email)->send(new ForgetPasswordEmail($user, $resetLink));

        return redirect()->back()->with('success', 'Đã gửi link lấy lại mật khẩu về email của bạn.');
    }

    public function resetPasswordView(Request $request): View
    {
        $token = $request->get('token');

        if (!$token) {
            abort(404);
        }

        $userUuid = DB::table('password_resets')->where('token', $token)->first()?->uuid;

        if (!$userUuid) {
            abort(404);
        }

        $crudBag = new CrudBag();

        $crudBag->setParam("token", $token);

        return \view("auth.reset-password", ['crudBag' => $crudBag]);
    }

    /**
     * @throws ValidationException
     */
    public function updatePasswordWithToken(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
            'token' => 'string|required'
        ]);

        $token = $request->get('token');

        if (!$token) {
            abort(419);
        }

        $userUuid = DB::table('password_resets')->where('token', $token)->first()?->uuid;
        if (!$userUuid) {
            abort(419);
        }
        $user = User::query()->where('uuid', $userUuid)->first();

        if (!$user) {
            abort(404);
        }

        $user->update([
            'password' => Hash::make($request->get('password'))
        ]);

        DB::table('password_resets')->where('token', $token)->delete();

        Auth::loginUsingId($user->id);

        return redirect()->to('/')->with('success', 'Đổi mật khẩu thành công');
    }
}
