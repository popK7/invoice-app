<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // View profile
    public function viewProfile(Request $request) {
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $role = $user->roles[0]->slug;
        return view('profile.view-profile',compact('user','role'));
    }

    // Update profile
    public function updateProfile(Request $request) {
        $authUser = Sentinel::getUser();
        $validatedData = $request->validate([
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'mobile_number' => 'required|min:9|max:12',
        ]);

        try {
            $user = User::find($authUser->id);
            if ($request->profile_image != null) {
                // remove old file
                $old_thumb_destination = 'assets/images/users/'.$user->profile_image;
                if (File::exists(public_path($old_thumb_destination))) {
                    File::delete(public_path($old_thumb_destination));
                }
                $file = $request->file('profile_image');
                $extention = $file->getClientOriginalExtension();
                $imageName = time() . '.' . $extention;
                $file->move(public_path('assets/images/users/'), $imageName);
            }
            
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile_number = $request->mobile_number;
            $user->profile_image = !empty($imageName) ? $imageName : $user->profile_image;

            if($user->save()) {
                return redirect('view-profile')->with('success', 'Profile updated successfully!!!');
            } else {
                return redirect('view-profile')->with('error', 'Failed to update!!!');
            }
        } catch (Exception $e) {
            return redirect('view-profile')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    // Update password
    public function updatePassword(Request $request) {
        $authUser = Sentinel::getUser();
        $validatedData = $request->validate(
            [
                'old_password' => 'required',
                'password' => 'required|min:8|max:16|confirmed'
            ],
            [
                'password.required' => 'Password is required.',
                'password.min' => 'Set minimum password length to at least a value of 8 and maximum 16.',
                'password.max' => 'Set minimum password length to at least a value of 8 and maximum 16.',
                'password.confirmed' => 'Password and Re-enter password does not match.'
            ]
        );

        try {
            $user = Sentinel::findById($authUser->id);
            $oldCredentials = [
                'login' => $user->email,
                'password' => $request->old_password,
            ];
            $checkOldPass = Sentinel::validateCredentials($user, $oldCredentials);
            if($checkOldPass) {
                $credentials = [
                    'password' => $request->password,
                ];
                $user = Sentinel::update($user, $credentials);
                if($user) {
                    return redirect('view-profile')->with('success', 'Password has been updated successfully.');
                } else {
                    return redirect('view-profile')->with('error', 'Something went wrong.');
                }
            } else {
                return redirect('view-profile')->with('error', 'Old password is not matched.');
            }
        } catch (Exception $e) {
            return redirect('view-profile')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }
}
