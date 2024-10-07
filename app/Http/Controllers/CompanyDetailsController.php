<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyDetails;
use App\Models\Notification;

class CompanyDetailsController extends Controller
{
    // Company list 
    public function companyList(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('company.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $companies = CompanyDetails::orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($companies)
                    ->addIndexColumn()
                    ->addColumn('company_name', function($row){
                        $url=asset("assets/images/logo/$row->logo");
                        $company_name = '
                            <img src="'.$url.'" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body align-middle fw-medium">'.$row->company_name.'</a>
                        ';
                        return $company_name;
                    })
                    ->addColumn('created_at', function($row){
                        $created_at = date('Y-m-d H:i:s',strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('status', function($row){
                        $statusValue = ($row->status == 1) ? 'success' : 'danger';
                        $statusText = ($row->status == 1) ? 'Active' : 'Disabled';
                        $status = '<span class="badge badge-soft-'.$statusValue.' p-2">'.$statusText.'</span>';
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editCompanyModal" data-edit-id="'.$row->id.'"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="'.route('change-company-status', $row->id).'" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['company_name','created_at','status','action'])->make(true);
            }
            // End

            return view('company.company-list',compact('user','role','companies'));
        } else {
            return view('error.403');
        }
    }

    // Add new company
    public function addCompany(Request $request) {
        $authUser = Sentinel::getUser();
        $role = $authUser->roles[0]->slug;
        if ($authUser->hasAccess('company.add')) {
            $validatedData = $request->validate([
                'company_name' => 'required|max:80',
                'website' => 'required|url|max:50',
                'email' => 'required|email|max:50',
                'mobile_number' => 'required|max:12',
                'postalcode' => 'required|max:8',
                'address' => 'required',
                'invoice_slug' => 'required|max:20',
                'logo' => 'required|image|mimes:jpg,jpeg,png|max:10000',
            ]);

            try {
                // logo upload
                if ($request->logo != null) {
                    $file = $request->file('logo');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/logo/'), $imageName);
                }
                // company details add
                $company = new CompanyDetails();
                $company['company_name'] = $request->company_name;
                $company['website'] = $request->website;
                $company['email'] = $request->email;
                $company['mobile_number'] = $request->mobile_number;
                $company['postalcode'] = $request->postalcode;
                $company['address'] = $request->address;
                $company['invoice_slug'] = $request->invoice_slug;
                $company['logo'] = $imageName;
                $company['status'] = 0;
                if($company->save()) {
                    if($role == 'accountant') {
                        // Send Notification To Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if($authUser->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 6;
                                $notification->title = "New Company Added";
                                $notification->data = "has add new company";
                                $notification->from_user = $authUser->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('company-list')->with('success', 'Company added successfully!!!');
                } else {
                    return redirect('company-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('company-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update company
    public function updateCompany(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('company.edit')) {
            $validatedData = $request->validate([
                'company_name' => 'required|max:80',
                'website' => 'required|url|max:50',
                'email' => 'required|email|max:50',
                'mobile_number' => 'required|max:12',
                'postalcode' => 'required|max:8',
                'address' => 'required',
                'invoice_slug' => 'required|max:20',
                // 'logo' => 'required|image|mimes:jpg,jpeg,png|max:10000',
            ]);

            try {
                $company = CompanyDetails::find($request->companyId);
                if ($request->logo != null) {
                    $isAvailable = 'assets/images/logo/.' . $company->logo;
                    if (File::exists($isAvailable)) {
                        File::delete($isAvailable);
                    }
                    $file = $request->file('logo');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/logo/'), $imageName);
                }

                // edit company details
                $company->company_name = $request->company_name;
                $company->website = $request->website;
                $company->email = $request->email;
                $company->mobile_number = $request->mobile_number;
                $company->postalcode = $request->postalcode;
                $company->address = $request->address;
                $company->invoice_slug = $request->invoice_slug;
                $company->logo = !empty($imageName) ? $imageName : $company->logo;
                if($company->save()) {
                    return redirect('company-list')->with('success', 'Company updated successfully!!!');
                } else {
                    return redirect('company-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('company-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Change company status
    public function changeCompanyStatus(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('company.delete')) {
            try {
                $id = $request->id;
                $company = CompanyDetails::find($id);
                ($company->status == 0) ? $status = 1 : $status = 0;
                $company->status = $status;
                if($company->save()) {
                    $otherCompaines = CompanyDetails::where('id', '!=' ,$id)->get();
                    foreach ($otherCompaines as $key => $value) {
                        CompanyDetails::where('id', $value['id'])->update(['status' => 0]);
                    }
                    return redirect('company-list')->with('success','Company status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('company-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete company
    public function deleteCompany(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('company.delete')) {
            try {
                $id = $request->id;
                $company = CompanyDetails::find($id)->delete();
                if($company) {
                    return redirect('company-list')->with('success','Company deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('company-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
}
