<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;

class AccountantController extends Controller
{
    // Accountant list 
    public function accountantList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('accountant.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $accountant_role = Sentinel::findRoleBySlug('accountant');
            if ($role == 'admin') {
                $accountants = $accountant_role->users()->with(['roles'])->orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($accountants)
                    ->addIndexColumn()
                    ->addColumn('accountant_name', function ($row) {
                        $url = asset("assets/images/users/$row->profile_image");
                        $accountant_name = '
                            <img src="' . $url . '" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body align-middle fw-medium">' . $row->first_name . " " . $row->last_name . '</a>
                        ';
                        return $accountant_name;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('Y-m-d H:i:s', strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('status', function ($row) {
                        $statusValue = ($row->status == 1) ? 'success' : 'danger';
                        $statusText = ($row->status == 1) ? 'Active' : 'Disabled';
                        $status = '<span class="badge badge-soft-' . $statusValue . ' p-2">' . $statusText . '</span>';
                        return $status;
                    })
                   
                    ->addColumn('action', function ($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <button class="btn btn-soft-info btn-sm d-inline-block view-button" data-bs-toggle="modal" data-bs-target="#viewAccountantModal" data-view-id="'.$row->id.'"> <i class="las la-eye fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editAccountantModal" data-edit-id="'.$row->id.'"><i class="las la-pen fs-17 align-middle"></i></button>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="' . route('change-accountant-status', $row->id) . '" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['accountant_name', 'created_at', 'status', 'action'])->make(true);
            }
            // End

            return view('accountants.accountant-list', compact('user', 'role', 'accountants'));
        } else {
            return view('error.403');
        }
    }

    // Add new accountant
    public function addAccountant(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('accountant.add')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha|max:30',
                'last_name' => 'required|alpha|max:30',
                'mobile_number' => 'required|max:15',
                'email' => 'required|email|unique:users|max:50',
                'country' => 'required',
                'username' => 'required|unique:users|max:30',
                'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:10000',
            ]);

            try {
                if ($request->profile_image != null) {
                    $file = $request->file('profile_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/users/'), $imageName);
                }

                $token = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 64);
                $randomPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                $input = $request->all();
                $input['password'] = $randomPassword;
                $input['profile_image'] = $imageName;
                $input['token'] = $token;
                $input['created_by'] = $authUser->id;

                //Register and attach the user to the role
                $user = Sentinel::registerAndActivate($input);
                $role = Sentinel::findRoleBySlug('accountant');
                $role->users()->attach($user);

                if ($user) {
                    $app_name =  config('app.name');
                    $app_url = config('app.url');
                    $mailArray = [$request->email];
                    Mail::send('emails.verify-account', ['email' => $request->email, 'password' => $randomPassword, 'token' => $token, 'app_url' => $app_url, 'role' => $role->slug], function ($message) use ($mailArray, $app_name) {
                        $message->to($mailArray)->subject('Account verification - Invoika');
                    });
                    return redirect('accountant-list')->with('success', 'Accountant registered successfully!!!');
                } else {
                    return redirect('accountant-list')->with('error', 'Failed to register!!!');
                }
            } catch (Exception $e) {
                return redirect('accountant-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update accountant
    public function updateAccountant(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('accountant.edit')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha|max:30',
                'last_name' => 'required|alpha|max:30',
                'mobile_number' => 'required|max:15',
                'country' => 'required',
                // 'email' => 'required|max:50|email|unique:users,email,'.$request->clientId,
                // 'username' => 'required|unique:users|max:30,'.$request->clientId,
                'profile_image' => 'image|mimes:jpg,jpeg,png|max:10000',
            ]);

            try {
                $accountant = User::find($request->accountantId);
                if ($request->profile_image != null) {
                    $isAvailable = 'assets/images/users/.' . $accountant->profile_image;
                    if (File::exists($isAvailable)) {
                        File::delete($isAvailable);
                    }
                    $file = $request->file('profile_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/users/'), $imageName);
                }

                // edit accountant details
                $accountant->first_name = $request->first_name;
                $accountant->last_name = $request->last_name;
                $accountant->mobile_number = $request->mobile_number;
                $accountant->email = $request->email;
                $accountant->username = $request->username;
                $accountant->country = $request->country;
                $accountant->profile_image = !empty($imageName) ? $imageName : $accountant->profile_image;
                $accountant->save();

                if ($accountant) {
                    return redirect('accountant-list')->with('success', 'Accountant updated successfully!!!');
                } else {
                    return redirect('accountant-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('accountant-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Change accountant status
    public function changeAccountantStatus(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('accountant.delete')) {
            try {
                $id = $request->id;
                $accountant = User::find($id);
                ($accountant->status == 0) ? $status = 1 : $status = 0;
                $accountant->status = $status;
                if ($accountant->save()) {
                    return redirect('accountant-list')->with('success', 'Accountant status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('accountant-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete accountant
    public function deleteAccountant(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('accountant.delete')) {
            try {
                $id = $request->id;
                $accountant = User::find($id)->delete();
                if ($accountant) {
                    return redirect('accountant-list')->with('success', 'Accountant deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('accountant-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
}
