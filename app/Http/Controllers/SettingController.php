<?php

namespace App\Http\Controllers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\User;
use App\Models\Notification;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // View setting
    public function viewSiteSetting(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('setting.update')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $siteSetting = SiteSetting::first();
            return view('settings.view-site-setting',compact('user','role','siteSetting'));
        } else {
            return view('error.403');
        }
    }

    public function updateSiteSetting(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('setting.update')) {

            $validatedData = $request->validate([
                'app_title' => 'required|max:90',
                'copyright_first' => 'required|max:90',
                'copyright_last' => 'required|max:90',
                'light_logo' => 'sometimes|mimes:jpg,png,jpeg,svg|max:2048',
                'dark_logo' => 'sometimes|mimes:jpg,png,jpeg,svg|max:2048',
                'favicon' => 'sometimes|max:2048',
                'logo_sm' => 'sometimes|mimes:jpg,png,jpeg,svg|max:2048',
            ]);

            $setting = SiteSetting::first();
            
            if ($request->light_logo != NULL) {
                $light_logo = request()->file('light_logo');
                $light_logoName = $light_logo->getClientOriginalName();
                $light_logoPath = public_path('/assets/images/');
                $light_logo->move($light_logoPath, $light_logoName);
            }

            if ($request->dark_logo != NULL) {
                $dark_logo = request()->file('dark_logo');
                $dark_logoName = $dark_logo->getClientOriginalName();
                $dark_logoPath = public_path('/assets/images/');
                $dark_logo->move($dark_logoPath, $dark_logoName);
            }

            if ($request->favicon != NULL) {
                $favicon = request()->file('favicon');
                $faviconName = $favicon->getClientOriginalName();
                $faviconPath = public_path('/assets/images/');
                $favicon->move($faviconPath, $faviconName);
            }

            if ($request->logo_sm != NULL) {
                $logo_sm = request()->file('logo_sm');
                $logo_smName =$logo_sm->getClientOriginalName();
                $logo_smPath = public_path('/assets/images/');
                $logo_sm->move($logo_smPath, $logo_smName);
            }

            if($setting) {
                $setting->app_title = $request->app_title;
                if($request->light_logo != NULL){
                $setting->light_logo = $light_logoName;}
                if($request->dark_logo != NULL){
                $setting->dark_logo =  $dark_logoName;}
                if($request->favicon != NULL){
                $setting->favicon = $faviconName;}
                if($request->logo_sm != NULL){
                $setting->logo_sm = $logo_smName;}
                $setting->copyright_first = $request->copyright_first;
                $setting->copyright_last = $request->copyright_last;

                if($setting->save()) {
                    return redirect('view-site-settings')->with('success', 'Site-Setting updated successfully!!!');
                } else {
                    return redirect('view-site-settings')->with('error', 'Failed to update!!!');
                }
            }
        } else {
            return view('error.403');
        }
    }
}
