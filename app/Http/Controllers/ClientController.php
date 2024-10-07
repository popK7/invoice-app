<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClientDetails;
use App\Models\Notification;


class ClientController extends Controller
{
    // Client list 
    public function clientList(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('client.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $client_role = Sentinel::findRoleBySlug('client');
            if ($role == 'admin' || $role == 'accountant') {
                $clients = $client_role->users()->with(['roles'])->orderByDesc('id')->get()->toArray();
                $clientDetails = [];
                foreach ($clients as $key => $value) {
                    $clientData = ClientDetails::where('user_id', $value['id'])->first()->toArray();
                    // dd($clientData);
                    $clients[$key]['clientDetails'] = $clientData;
                    array_push($clientDetails ,$clientData);
                }
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($clients)
                    ->addIndexColumn()
                    ->addColumn('client_name', function($row){
                        $url=asset("assets/images/users/".$row['profile_image']);
                        $client_name = '
                            <img src="'.$url.'" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body align-middle fw-medium">'.$row['first_name']." ".$row['last_name'].'</a>
                        ';
                        return $client_name;
                    })
                    ->addColumn('company_name', function($row){
                        $company_name = $row['clientDetails']['company_name'];
                        return $company_name;
                    })
                    ->addColumn('created_at', function($row){
                        $created_at = date('Y-m-d H:i:s',strtotime($row['created_at']));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('status', function($row){
                        $statusValue = ($row['status'] == 1) ? 'success' : 'danger';
                        $statusText = ($row['status'] == 1) ? 'Active' : 'Disabled';
                        $status = '<span class="badge badge-soft-'.$statusValue.' p-2">'.$statusText.'</span>';
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <button class="btn btn-soft-dark btn-sm d-inline-block" data-bs-toggle="modal" onclick="viewClientData('. $row->id .')" data-bs-target="#viewClientModal"><i class="las la-eye fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editClientModal" data-edit-id="'.$row->id.'"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="'.route('change-client-status', $row['id']).'" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <button type="button" onclick="callConfirmationModal('.$row['id'].')"class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Make Invoice">
                                    <a href="'.url('make-invoice', $row['id']).'" class="btn btn-soft-secondary btn-sm d-inline-block"><i class="las la-file-invoice"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client_name','company_name','created_at','status','action'])->make(true);
            }
            // End
            
            return view('clients.client-list',compact('user','role','clients','clientDetails'));
        } else {
            return view('error.403');
        }
    }

    // Add new client
    public function addClient(Request $request) {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('client.add')) {
            $validatedData = $request->validate([
                'first_name' => 'required|max:30',
                'last_name' => 'required|max:30',
                'mobile_number' => 'required|max:15',
                'email' => 'required|email|unique:users|max:50',
                'username' => 'required|unique:users|max:30',
                'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:10000',
                'country' => 'required',
                'company_name' => 'required|max:100',
                'gst_number' => 'required|max:50',
                'company_code' => 'required|max:50',
                'company_address' => 'required',
            ]);

            try {
                if ($request->profile_image != null) {
                    $file = $request->file('profile_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/users/'), $imageName);
                }

                $token = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 64 );
                $randomPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
                $input = $request->all();
                $input['username'] = $request->username;
                $input['password'] = $randomPassword;
                $input['profile_image'] = $imageName;
                $input['created_by'] = $authUser->id;
                $input['token'] = $token;

                //Register and attach the user to the role
                $user = Sentinel::registerAndActivate($input);
                $role = Sentinel::findRoleBySlug('client');
                $role->users()->attach($user);
                
                if($user) {
                    // add client company details
                    $companyDetails = new ClientDetails();
                    $companyDetails->user_id = $user->id;
                    $companyDetails->company_name = $request->company_name;
                    $companyDetails->gst_number = $request->gst_number;
                    $companyDetails->company_code = $request->company_code;
                    $companyDetails->address = $request->company_address;

                    $app_name =  config('app.name');
                    $mailArray = [$request->email];
                    if($companyDetails->save()) {
                        $app_name =  config('app.name');
                        $app_url = config('app.url');
                        $mailArray = [$request->email];
                        Mail::send('emails.verify-account', ['email' => $request->email, 'password' => $randomPassword, 'token' => $token, 'app_url' => $app_url, 'role' => $role->slug], function ($message) use ($mailArray,$app_name) {
                            $message->to($mailArray)->subject('Account verification - '.$app_name);
                        });

                        // Send Notification
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if($authUser->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 1;
                                $notification->title = 'New Client Added';
                                $notification->data = 'has added new client';
                                $notification->from_user = $authUser->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('client-list')->with('success', 'Client registered successfully!!!');
                } else {
                    return redirect('client-list')->with('error', 'Failed to register!!!');
                }
            } catch (Exception $e) {
                return redirect('client-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update client
    public function updateClient(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('client.edit')) {
            $validatedData = $request->validate([
                'first_name' => 'required|max:30',
                'last_name' => 'required|max:30',
                'mobile_number' => 'required|max:15',
                'country' => 'required',
                // 'email' => 'required|max:50|email|unique:users,email,'.$request->clientId,
                // 'username' => 'required|unique:users|max:30,'.$request->clientId,
                'profile_image' => 'image|mimes:jpg,jpeg,png|max:10000',
                'company_name' => 'required|max:100',
                'gst_number' => 'required|max:50',
                'company_code' => 'required|max:50',
                'address' => 'required',
            ]);

            try {
                $client = User::find($request->clientId);
                if ($request->profile_image != null) {
                    $isAvailable = 'assets/images/users/.' . $client->profile_image;
                    if (File::exists($isAvailable)) {
                        File::delete($isAvailable);
                    }
                    $file = $request->file('profile_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/users/'), $imageName);
                }

                // edit client details
                $client->first_name = $request->first_name;
                $client->last_name = $request->last_name;
                $client->mobile_number = $request->mobile_number;
                $client->email = $request->email;
                $client->username = $request->username;
                $client->country = $request->country;
                $client->profile_image = !empty($imageName) ? $imageName : $client->profile_image;
                $client->save();

                // edit client company details
                $clientDetails = clientDetails::where('user_id',$request->clientId)->update([
                    'company_name' => $request->company_name,
                    'gst_number' => $request->gst_number,
                    'company_code' => $request->company_code,
                    'address' => $request->address,
                ]);
                if($clientDetails) {
                    return redirect('client-list')->with('success', 'Client updated successfully!!!');
                } else {
                    return redirect('client-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('client-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Change client status
    public function changeClientStatus(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('client.delete')) {
            try {
                $id = $request->id;
                $client = User::find($id);
                ($client->status == 0) ? $status = 1 : $status = 0;
                $client->status = $status;
                if($client->save()) {
                    return redirect('client-list')->with('success','Client status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('client-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete client
    public function deleteClient(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('client.delete')) {
            try {
                $id = $request->id;
                $clientDetails = ClientDetails::where('user_id', $id)->first()->delete();
                $client = User::find($id)->delete();
                if($client) {
                    return redirect('client-list')->with('success','Client deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('client-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
}
