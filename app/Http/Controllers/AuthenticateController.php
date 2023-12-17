<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\Host;
use App\Models\HostProfile;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticateController extends Controller
{
    public function loginView(): View
    {
        return view('auth.login');
    }

    public function verificationView(): View
    {
        return view('auth.verification');
    }

    public function sendVerificationEmail(): RedirectResponse
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->id);

        if (!$user->email) {
            return redirect()->to('/verification')->withErrors(['uuid' => 'Không có email xác minh']);
        }

        if (!$user->verified) {

            if (!$user->verified_code) {
                $randomCode = rand(100000, 999999);
                $user->update([
                    'verified_code' => $randomCode
                ]);
            }

            Mail::to($user->email)->send(new VerificationEmail($user));
        }

        return redirect()->to('/')->with('success', 'Gửi email thành công');
    }

    /**
     * @throws ValidationException
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->id);

        $user->update([
            'email' => $request->get('email')
        ]);

        return redirect()->to('/')->with('success', 'Cập nhật email thành công');
    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'uuid' => 'string|required',
            'password' => 'string|required'
        ]);

        $user = User::query()->where('uuid', $request->get('uuid'))->first();
        if (!$user) {
            return redirect()->back()->withErrors(['uuid' => 'Không tìm thấy tài khoản']);
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Sai mật khẩu']);
        }

        Auth::loginUsingId($user->id);

        return redirect()->to('/');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function verify(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'verified_code' => 'required|integer'
        ]);

        /**
         * @var  User $user
         */
        $user = User::query()->where('id', Auth::user()->id)->first();

        if ($request->get('verified_code') != $user->verified_code) {
            return redirect()->back()->withErrors([
                'verified_code' => 'Mã xác thực không đúng'
            ]);
        }

        $user->update([
            'verified' => 1,
            'verified_code' => null
        ]);

        return redirect()->to('/')->with('success', 'Xác minh thành công');
    }

    public function registerView(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'email|nullable',
            'password' => 'required|confirmed|string',
            'name' => 'required',
            'uuid' => 'required|unique:users,uuid'
        ]);

        DB::transaction(function () use ($request) {
            $dataToCreateUser = $request->only([
                'email',
                'name',
                'uuid'
            ]);

            $dataToCreateUser['avatar'] = "https://i.pinimg.com/originals/a0/da/75/a0da758b14952a8631a795f9e8e9b56d.png";
            $dataToCreateUser['password'] = Hash::make($request->get('password'));
            $dataToCreateUser['role'] = User::HOST_ROLE;
            $dataToCreateUser['branch'] = Host::UNSELECT_BRANCH;
            $user = Host::query()->create($dataToCreateUser);

            HostProfile::query()->create([
                'user_id' => $user->id
            ]);
        });

        return redirect()->to('/login')->with('success', 'Đăng ký thành công');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }
}
