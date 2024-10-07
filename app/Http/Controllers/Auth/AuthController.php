<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            if($request->remember == 'on') {
                setcookie('rememberEmail', $request->email, time()+31556926 , "/");
                setcookie('rememberPassword', $request->password, time()+31556926 );
                setcookie('remember', '1', time()+31556926 );
            } else {
                setcookie('rememberEmail', "", time()+31556926 , "/");
                setcookie('rememberPassword', "", time()+31556926);
                setcookie('remember', '0', time()+31556926);
            }

            $user = Sentinel::authenticate($validatedData);
            if ($user) {
                if($user->status == 1 && $user->is_verified == 1) {
                    if ($user->roles[0]->slug == 'admin' || $user->roles[0]->slug == 'accountant') {
                        return redirect('dashboard');
                    } else if($user->roles[0]->slug == 'client') {
                        return redirect('client-invoice-list');
                    } else {
                        return redirect('/')->with('error', 'You dont have an access!!!');
                    }
                } else {
                    return redirect('/')->with('error', 'You account is not activate/verified yet!!!');
                }
            } else {
                return redirect('/')->with('error', 'Email or password not match with our records!!!');
            }
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    public function logout() {
        Sentinel::logout(null, true);
        session()->flush();
        return redirect('/');
    }

    public function showSignupForm() {
        return view('auth.signup');
    }

    public function signup(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required|alpha|max:30',
            'last_name' => 'required|alpha|max:30',
            'mobile_number' => 'required|numeric',
            'email' => 'required|email|unique:users|max:50',
            'username' => 'required|unique:users|max:30',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:10000',
        ]);

        try {
            if ($request->profile_image != null) {
                $file = $request->file('profile_image');
                $extention = $file->getClientOriginalExtension();
                $imageName = time() . '.' . $extention;
                $file->move(public_path('assets/images/users/'), $imageName);
            }

            $input = $request->all();
            $input['profile_image'] = $imageName;
            //Register and attach the user to the role
            $user = Sentinel::registerAndActivate($input);
            $role = Sentinel::findRoleBySlug('accountant');
            $role->users()->attach($user);
            
            if($user) {
                return redirect('/')->with('success', 'Registered successfully!!!');
            } else {
                return redirect('signup-form')->with('error', 'Failed to register!!!');
            }
        } catch (Exception $e) {
            return redirect('signup-form')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    public function resetPassword() {
        return view('auth.passwords.reset-password');
    }

    public function forgetPassword(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $checkMailIsExists = User::where(['email' => $request->email])->first();
        if(!is_null($checkMailIsExists)) {
            $app_name =  config('app.name');
            $app_url = config('app.url');
            $mailArray = [$request->email];
            Mail::send('emails.forget-password', ['email' => $request->email, 'app_url' => $app_url, 'token' => $checkMailIsExists->token], function ($message) use ($mailArray,$app_name) {
                $message->to($mailArray)->subject('Forget password - '.$app_name);
            });

            return redirect('reset-password')->with('success', 'Reset password link has been sent to your email.');
        } else {
            return redirect('reset-password')->with('error', 'Email is not exists in our records.');
        }
    }

    public function viewUpdatePassword(Request $request) {
        return view('auth.passwords.update-password');
    }

    public function updatePassword(Request $request) {
        $validatedData = $request->validate([
            'password' => 'required|min:6|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/',
            'password_confirmation' => 'required',
        ]);

        $isUserExists = User::where(['email' => $request->email, 'token' => $request->token])->first();
        if(!is_null($isUserExists)) {
            $user = Sentinel::findById($isUserExists->id);
            $credentials = [
                'password' => $request->password,
            ];
            $user = Sentinel::update($user, $credentials);
            if($user) {
                return redirect('/')->with('success', 'Password has been updated successfully.');
            } else {
                return redirect('/')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect('/')->with('error', 'User not found.');
        }
    }

    public function verifyAccount(Request $request) {
        $user = User::where(['email' => $request->email, 'token' => $request->token])->update(['is_verified' => 1]);
        if($user){
            return redirect('/')->with('success', 'Your account verify successfully.');
        } else{
            return redirect('/')->with('error', 'Account verify issue found, please contact support!');
        }
    }
}
