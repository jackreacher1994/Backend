<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use App\Role;
use Session;
use App\Social;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required|email|max:255', 'password' => 'required|min:4|max:60',
            ], [
            $this->loginUsername().'.required' => 'Vui lòng điền địa chỉ email.',
            $this->loginUsername().'.max' => 'Địa chỉ email chỉ dài tối đa 255 kí tự.',
            $this->loginUsername().'.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng điền mật khẩu.',
            'password.min' => 'Mật khẩu phải dài tối thiểu 6 kí tự.',
            'password.max' => 'Mật khẩu chỉ dài tối đa 60 kí tự.'
            ]);

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function getFailedLoginMessage()
    {
        return "Tài khoản không có trong hệ thống hoặc bạn đã điền sai thông tin.";
    }

   /* public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
 
    public function handleProviderCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }

        $authUser = $this->findOrCreateUser($facebookUser);
 
        Auth::login($authUser, true);

        return redirect()->route('Not.HomeController.dashboard');
    }

    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('email', $facebookUser->email)->first();
 
        if ($authUser){
            return $authUser;
        }
 
        $newUser = User::create([
            'fullname' => $facebookUser->name,
            'password' => bcrypt($facebookUser->email),
            'email' => $facebookUser->email,
            'avatar' => $facebookUser->avatar
        ]);

        Social::create([
            'provider' => 'facebook',
            'social_id' => $facebookUser->id,
            'user_id' => $newUser->id
        ]);

        $defaultPassword = $newUser->email;

        $default_role_name = config('setting.default_role');
        $default_role = Role::where('name', '=', $default_role_name)->firstOrFail();
        $newUser->assignRole($default_role);

        Session::set('changePasswordMessage', 'Mật khẩu mặc định khi đăng nhập bằng tài khoản mạng xã hội của bạn là <b>'.$defaultPassword.'</b><br>Vui lòng <a href="password">đổi mật khẩu</a> để bảo mật!');

        return $newUser;
    }*/


    public function getSocialRedirect( $provider )

    {
        return Socialite::driver( $provider )->redirect();
    }

    public function getSocialHandle( $provider )
    {
        try {
            $user = Socialite::driver( $provider )->user();
        } catch (Exception $e) {
            return redirect('/social/redirect/'.$provider);
        }

       // $user = Socialite::driver( $provider )->user();

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', '=', $user->email)->first();
        if(!empty($userCheck))
        {
            $socialUser = $userCheck;
        }
        else
        {
            $sameSocialId = Social::where('social_id', '=', $user->id)->where('provider', '=', $provider )->first();

            if(empty($sameSocialId))
            {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email = $user->email;
                $newSocialUser->password =  bcrypt($user->email);
                $newSocialUser->fullname = $user->name;
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->socials()->save($socialData);

                $defaultPassword = $newSocialUser->email;
                // Add role
                $default_role_name = config('general.default_role');
                $default_role = Role::where('name', '=', $default_role_name)->firstOrFail();
                $newSocialUser->assignRole($default_role);

                Session::set('changePasswordMessage', 'Mật khẩu mặc định khi đăng nhập bằng tài khoản mạng xã hội của bạn là <b>'.$defaultPassword.'</b><br>Vui lòng <a href="password">đổi mật khẩu</a> để bảo mật!');
               $socialUser =  $newSocialUser;
            }
            else
            {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }

        }

        Auth::login($socialUser, true);

        return redirect()->route('Not.HomeController.dashboard');
    }
}
