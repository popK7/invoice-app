<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use App\Models\Tax;
use App\Models\Discount;
use App\Models\ShippingCharge;
use App\Models\Notification;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    // Tax list
    public function taxList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $taxes = Tax::orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($taxes)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $name = $row->name;
                        return $name;
                    })
                    ->addColumn('country', function ($row) {
                        $country = $row->country;
                        return $country;
                    })
                    ->addColumn('rate', function ($row) {
                        $rate = $row->rate;
                        return $rate;
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
                                <li class="list-inline-item edit"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editTaxModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="' . route('change-status', $row->id) . '" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                            
                        ';
                        return $action;
                    })
                    ->rawColumns(['name', 'country', 'rate', 'created_at', 'status', 'action'])->make(true);
            }
            // End

            return view('tax.tax-list', compact('user', 'role', 'taxes'));
        } else {
            return view('error.403');
        }
    }

    // Add new tax
    public function addTax(Request $request)
    {
        $authUser = Sentinel::getUser();
        $role = $authUser->roles[0]->slug;
        if ($authUser->hasAccess('tax.add')) {
            $validatedData = $request->validate([
                'taxName' => 'required|max:50',
                'country' => 'required',
                'taxRate' => 'required',
            ]);

            try {
                $tax = new Tax();
                $tax['name'] = $request->taxName;
                $tax['country'] = $request->country;
                $tax['rate'] = $request->taxRate;
                if ($tax->save()) {
                    if ($role == 'accountant') {
                        // Send Notification To Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($authUser->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 4;
                                $notification->title = 'New Tax Added';
                                $notification->data = 'has added new tax';
                                $notification->from_user = $authUser->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('tax-list')->with('success', 'Tax added successfully!!!');
                } else {
                    return redirect('tax-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('tax-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update tax
    public function updateTax(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('tax.edit')) {
            $validatedData = $request->validate([
                'taxName' => 'required|max:50',
                'country' => 'required',
                'taxRate' => 'required',
            ]);

            try {
                // update tax
                $tax = Tax::find($request->taxId);
                $tax->name = $request->taxName;
                $tax->country = $request->country;
                $tax->rate = $request->taxRate;
                if ($tax->save()) {
                    if ($role == 'accountant') {
                        // Send Notification To Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($user->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 7;
                                $notification->title = 'Tax Is Updated';
                                $notification->data = 'has updated tax';
                                $notification->from_user = $user->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('tax-list')->with('success', 'Tax updated successfully!!!');
                } else {
                    return redirect('tax-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('tax-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete tax
    public function deleteTax(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.delete')) {
            try {
                $id = $request->id;
                $tax = Tax::find($id)->delete();
                if ($tax) {
                    return redirect('tax-list')->with('success', 'Tax deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('tax-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Status change
    public function changeTaxStatus(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.edit')) {
            try {
                $id = $request->id;
                $tax = Tax::find($id);
                ($tax->status == 0) ? $status = 1 : $status = 0;
                $tax->status = $status;
                if ($tax->save()) {
                    return redirect('tax-list')->with('success', 'Tax status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('tax-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    ######################################
    // Discount list
    public function discountList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $discount = Discount::orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($discount)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $name = $row->name;
                        return $name;
                    })
                    ->addColumn('rate', function ($row) {
                        $rate = $row->rate;
                        return $rate;
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
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editTaxModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="' . route('change-discount-status', $row->id) . '" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['name', 'rate', 'created_at', 'status', 'action'])->make(true);
            }
            // End

            return view('discount.discount-list', compact('user', 'role', 'discount'));
        } else {
            return view('error.403');
        }
    }

    // Add new discount
    public function addDiscount(Request $request)
    {
        $authUser = Sentinel::getUser();
        $role = $authUser->roles[0]->slug;
        if ($authUser->hasAccess('tax.add')) {
            $validatedData = $request->validate([
                'discountName' => 'required|max:50',
                'discountRate' => 'required',
            ]);

            try {
                $discount = new Discount();
                $discount['name'] = $request->discountName;
                $discount['rate'] = $request->discountRate;
                if ($discount->save()) {
                    if ($role == 'accountant') {
                        // Send Notification Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($authUser->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 5;
                                $notification->title = 'New Discount Added';
                                $notification->data = 'has added new discount';
                                $notification->from_user = $authUser->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('discount-list')->with('success', 'Discount added successfully!!!');
                } else {
                    return redirect('discount-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('discount-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update discount
    public function updateDiscount(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('tax.edit')) {
            $validatedData = $request->validate([
                'discountName' => 'required|max:50',
                'discountRate' => 'required',
            ]);

            try {
                // update tax
                $discount = Discount::find($request->discountId);
                $discount->name = $request->discountName;
                $discount->rate = $request->discountRate;
                if ($discount->save()) {
                    if ($role == 'accountant') {
                        // Send Notification To Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($user->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 8;
                                $notification->title = 'Discount Is Updated';
                                $notification->data = 'has updated discount';
                                $notification->from_user = $user->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('discount-list')->with('success', 'Discount updated successfully!!!');
                } else {
                    return redirect('discount-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('discount-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete discount
    public function deleteDiscount(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.edit')) {
            try {
                $id = $request->id;
                $discount = Discount::find($id)->delete();
                if ($discount) {
                    return redirect('discount-list')->with('success', 'Discount deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('discount-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Discount status change
    public function changeDiscountStatus(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.edit')) {
            try {
                $id = $request->id;
                $discount = Discount::find($id);
                ($discount->status == 0) ? $status = 1 : $status = 0;
                $discount->status = $status;
                if ($discount->save()) {
                    return redirect('discount-list')->with('success', 'Discount status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('discount-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    ######################################
    // Shipping charge list
    public function shippingChargeList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $taxes = ShippingCharge::orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($taxes)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $name = $row->name;
                        return $name;
                    })
                    ->addColumn('country', function ($row) {
                        $country = $row->country;
                        return $country;
                    })
                    ->addColumn('rate', function ($row) {
                        $rate = $row->rate;
                        return $rate;
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
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editTaxModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Status">
                                    <a href="' . route('change-shipping-charge-status', $row->id) . '" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-sync fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['name', 'country', 'rate', 'created_at', 'status', 'action'])->make(true);
            }
            // End

            return view('shipping-charge.shipping-charge-list', compact('user', 'role', 'taxes'));
        } else {
            return view('error.403');
        }
    }

    // Add new shipping charge
    public function addShippingCharge(Request $request)
    {
        $authUser = Sentinel::getUser();
        $role = $authUser->roles[0]->slug;
        if ($authUser->hasAccess('tax.add')) {
            $validatedData = $request->validate([
                'taxName' => 'required|max:50',
                'country' => 'required',
                'taxRate' => 'required',
            ]);

            try {
                $tax = new ShippingCharge();
                $tax['name'] = $request->taxName;
                $tax['country'] = $request->country;
                $tax['rate'] = $request->taxRate;
                if ($tax->save()) {
                    if ($role == 'accountant') {
                        // Send Notification Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($authUser->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 4;
                                $notification->title = 'New Tax Added';
                                $notification->data = 'has added new tax';
                                $notification->from_user = $authUser->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('shipping-charge-list')->with('success', 'Shipping charge added successfully!!!');
                } else {
                    return redirect('shipping-charge-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('shipping-charge-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update shipping charge
    public function updateShippingCharge(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('tax.edit')) {
            $validatedData = $request->validate([
                'taxName' => 'required|max:50',
                'country' => 'required',
                'taxRate' => 'required',
            ]);

            try {
                // update tax
                $tax = ShippingCharge::find($request->taxId);
                $tax->name = $request->taxName;
                $tax->country = $request->country;
                $tax->rate = $request->taxRate;
                if ($tax->save()) {
                    if ($role == 'accountant') {
                        // Send Notification To Admin
                        $admin_role = Sentinel::findRoleBySlug('admin');
                        $admin_id = $admin_role->users()->with('roles')->pluck('id');
                        $fromId = collect();
                        $fromId->push($admin_id);
                        $from_id =  $fromId->flatten();
                        foreach ($from_id as $item) {
                            if ($user->id != $item) {
                                $notification = new Notification();
                                $notification->to_user = $item;
                                $notification->notification_type_id = 9;
                                $notification->title = 'Shipping Charge Is Updated';
                                $notification->data = 'has updated shipping charge';
                                $notification->from_user = $user->id;
                                $notification->save();
                            }
                        }
                    }
                    return redirect('shipping-charge-list')->with('success', 'Shipping charge updated successfully!!!');
                } else {
                    return redirect('shipping-charge-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('shipping-charge-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete shipping charge
    public function deleteShippingCharge(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.edit')) {
            try {
                $id = $request->id;
                $charge = ShippingCharge::find($id)->delete();
                if ($charge) {
                    return redirect('shipping-charge-list')->with('success', 'Shipping charge deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('shipping-charge-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Shipping charge status change
    public function changeShippingChargeStatus(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('tax.edit')) {
            try {
                $id = $request->id;
                $tax = ShippingCharge::find($id);
                ($tax->status == 0) ? $status = 1 : $status = 0;
                $tax->status = $status;
                if ($tax->save()) {
                    return redirect('shipping-charge-list')->with('success', 'Shipping charge status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('shipping-charge-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
}
