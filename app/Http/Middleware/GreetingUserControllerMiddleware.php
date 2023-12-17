<?php

namespace App\Http\Middleware;

use App\Mail\VerificationEmail;
use App\Models\Student;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GreetingUserControllerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->id)->first();

        if ($user->verified == 0) {

            if ($user->email) {
                if (!$user->verified_code) {
                    $randomCode = rand(100000, 999999);
                    $user->update([
                        'verified_code' => $randomCode
                    ]);
                    $user->verified_code = $randomCode;
                }

                Mail::to($user->email)->send(new VerificationEmail($user));
            }
            return redirect()->to('/verification');
        }

        return $next($request);
    }
}
