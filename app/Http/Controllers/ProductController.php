<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use App\Models\Brands;
use App\Models\Colors;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Notification;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Product list
    public function productList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('product.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $products = Products::with('brand', 'category', 'color', 'user')->orderByDesc('id')->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($products)
                    ->addIndexColumn()
                    ->addColumn('product_name', function ($row) {
                        $url = asset("assets/images/products/" . $row->product_image);
                        $product_name = '
                            <img src="' . $url . '" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body align-middle fw-medium">' . $row->product_name . '</a>
                        ';
                        return $product_name;
                    })
                    ->addColumn('category_name', function ($row) {
                        $category_name = $row->category->name;
                        return $category_name;
                    })
                    ->addColumn('brand_name', function ($row) {
                        $brand_name = $row->brand->name;
                        return $brand_name;
                    })
                    ->addColumn('color_name', function ($row) {
                        $color_name = $row->color->name;
                        return $color_name;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('Y-m-d H:i:s', strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('created_by', function ($row) {
                        $created_by = $row->user->first_name . ' ' . $row->user->last_name;
                        return $created_by;
                    })
                    ->addColumn('status', function ($row) {
                        $statusValue = ($row->is_deleted == 0) ? 'success' : 'danger';
                        $statusText = ($row->is_deleted == 0) ? 'Active' : 'Disabled';
                        $status = '<span class="badge badge-soft-' . $statusValue . ' p-2">' . $statusText . '</span>';
                        return $status;
                    })
                    ->addColumn('action', function ($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <button class="btn btn-soft-dark btn-sm d-inline-block" data-bs-toggle="modal" onclick="viewProductData(' . $row->id . ')" data-bs-target="#viewProductModal"><i class="las la-eye fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editTaxModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['product_name', 'category_name', 'brand_name', 'color_name', 'created_at', 'created_by', 'status', 'action'])->make(true);
            }
            // End

            return view('products.product-list', compact('user', 'role', 'products'));
        } else {
            return view('error.403');
        }
    }

    // Add product page
    public function addProductView()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('product.add')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $brands = Brands::where('is_deleted', 0)->get();
                $categories = Categories::where('is_deleted', 0)->get();
                $colors = Colors::where('is_deleted', 0)->get();
            }
            return view('products.add-product', compact('user', 'role', 'brands', 'colors', 'categories'));
        } else {
            return view('error.403');
        }
    }

    // Add product
    public function addProduct(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('product.add')) {
            $validatedData = $request->validate([
                'product_name' => 'required|max:200',
                'brand' => 'required|max:10',
                'color' => 'required|max:10',
                'category' => 'required|max:10',
                'price' => 'required|max:10',
                'product_description' => 'required',
                'product_image' => 'required|mimes:jpg,jpeg,png,gif,svg|max:10000',
                'product_sub_image' => 'required',
                'product_sub_image.*' => 'mimes:jpg,jpeg,png,gif,svg|max:10000',
            ]);

            try {
                if ($request->product_image != null) {
                    $file = $request->file('product_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/products/'), $imageName);
                }

                $product = new Products();
                $product['product_name'] = $request->product_name;
                $product['brand_id'] = $request->brand;
                $product['color_id'] = $request->color;
                $product['category_id'] = $request->category;
                $product['price'] = $request->price;
                $product['description'] = $request->product_description;
                $product['product_image'] = $imageName;
                $product['created_by'] = $authUser->id;

                if ($product->save()) {

                    // Add product sub images
                    if ($request->product_sub_image != null) {
                        foreach ($request->file('product_sub_image') as $key => $file) {
                            $extention = $file->getClientOriginalExtension();
                            $imageName = time() . rand(0, 100000) . '.' . $extention;
                            $file->move(public_path('assets/images/products/'), $imageName);

                            $productImages = new ProductImages();
                            $productImages['product_id'] = $product->id;
                            $productImages['image'] = $imageName;
                            $productImages->save();
                        }
                    }

                    // Send Notification
                    $admin_role = Sentinel::findRoleBySlug('admin');
                    $admin_id = $admin_role->users()->with('roles')->pluck('id');
                    $fromId = collect();
                    $fromId->push($admin_id);
                    $from_id =  $fromId->flatten();
                    foreach ($from_id as $item) {
                        if ($authUser->id != $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = "New Product Added";
                            $notification->data = "has added new product";
                            $notification->from_user = $authUser->id;
                            $notification->save();
                        }
                    }

                    return redirect('product-list')->with('success', 'Product added successfully!!!');
                } else {
                    return redirect('product-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('product-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Edit product page
    public function editProduct(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('product.edit')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $brands = Brands::where('is_deleted', 0)->get();
                $categories = Categories::where('is_deleted', 0)->get();
                $colors = Colors::where('is_deleted', 0)->get();
                $products = Products::with('brand', 'category', 'color', 'user', 'product_images')->where('id', $request->id)->orderByDesc('id')->first();
            }
            return view('products.edit-product', compact('user', 'role', 'brands', 'products', 'colors', 'categories'));
        } else {
            return view('error.403');
        }
    }

    // Update product
    public function updateProduct(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('product.edit')) {
            $validatedData = $request->validate([
                'product_name' => 'required|max:200',
                'brand' => 'required|max:10',
                'color' => 'required|max:10',
                'category' => 'required|max:10',
                'price' => 'required',
                'product_description' => 'required',
            ]);

            try {
                $product = Products::find($request->productId);
                if ($request->product_image != null) {
                    // remove old thumbnail file
                    $old_thumb_destination = 'assets/images/products/' . $product->product_image;
                    if (File::exists(public_path($old_thumb_destination))) {
                        File::delete(public_path($old_thumb_destination));
                    }
                    $file = $request->file('product_image');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('assets/images/products/'), $imageName);
                }
                $product->product_name = $request->product_name;
                $product->brand_id = $request->brand;
                $product->color_id = $request->color;
                $product->category_id = $request->category;
                $product->price = $request->price;
                $product->description = $request->product_description;
                $product->product_image = !empty($imageName) ? $imageName : $product->product_image;

                if ($product->save()) {
                    // Add product sub images
                    if ($request->product_sub_image != null) {
                        foreach ($request->file('product_sub_image') as $key => $file) {
                            $extention = $file->getClientOriginalExtension();
                            $imageName = time() . rand(0, 100000) . '.' . $extention;
                            $file->move(public_path('assets/images/products/'), $imageName);

                            $productImages = new ProductImages();
                            $productImages['product_id'] = $request->productId;
                            $productImages['image'] = $imageName;
                            $productImages->save();
                        }
                    }
                    // Send Notification
                    $admin_role = Sentinel::findRoleBySlug('admin');
                    $admin_id = $admin_role->users()->with('roles')->pluck('id');
                    $fromId = collect();
                    $fromId->push($admin_id);
                    $from_id =  $fromId->flatten();
                    foreach ($from_id as $item) {
                        if ($authUser->id != $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 3;
                            $notification->title = 'Product Updated';
                            $notification->data = 'has updated product';
                            $notification->from_user = $authUser->id;
                            $notification->save();
                        }
                    }
                    return redirect('product-list')->with('success', 'Product updated successfully!!!');
                } else {
                    return redirect('product-list')->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect('product-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete product
    public function deleteProduct(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('product.delete')) {
            try {
                $id = $request->id;
                $product = Products::find($id);
                ($product->is_deleted == 0) ? $is_deleted = 1 : $is_deleted = 0;
                $product->is_deleted = $is_deleted;
                if ($product->save()) {
                    return redirect('product-list')->with('success', 'Product status has been changed successfully');
                }
            } catch (Exception $e) {
                return redirect('product-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Add New Brand View 
    public function brandList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('brand.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $brands = Brands::where('is_deleted', 0)->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($brands)
                    ->addIndexColumn()
                    ->addColumn('brand_name', function ($row) {
                        $brand_name = $row->name;
                        return $brand_name;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('Y-m-d H:i:s', strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('action', function ($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button"  data-bs-toggle="modal" data-bs-target="#editBrandModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['brand_name', 'created_at', 'created_by', 'action'])->make(true);
            }
            // End

            return view('brand.brand-list', compact('user', 'role', 'brands'));
        } else {
            return view('error.403');
        }
    }

    // Add new brand
    public function addBrand(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('brand.add')) {
            $validatedData = $request->validate([
                'brand_name' => 'required|max:200',
            ]);
            try {
                $brand = new Brands();
                $brand['name'] = $request->brand_name;
                if ($brand->save()) {
                    return redirect()->back()->with('success', 'Brand added successfully!!!');
                } else {
                    return redirect()->back()->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update brand
    public function updateBrand(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('brand.edit')) {
            $validatedData = $request->validate([
                'brand_name' => 'required|max:50',
            ]);

            try {
                // update brand
                $brand = Brands::find($request->brandId);
                $brand->name = $request->brand_name;
                if ($brand->save()) {
                    return redirect('brand-list')->with('success', 'Brand updated successfully!!!');
                } else {
                    return redirect('brand-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('brand-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete brand
    public function deleteBrand(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('brand.delete')) {
            try {
                $id = $request->id;
                $brand = Brands::find($id)->delete();
                if ($brand) {
                    return redirect('brand-list')->with('success', 'Brand deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('brand-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Add New Category View 
    public function categoryList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('category.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $category = Categories::where('is_deleted', 0)->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($category)
                    ->addIndexColumn()
                    ->addColumn('category_name', function ($row) {
                        $category_name = $row->name;
                        return $category_name;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('Y-m-d H:i:s', strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('action', function ($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn" data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['category_name', 'created_at', 'created_by', 'action'])->make(true);
            }
            // End

            return view('category.category-list', compact('user', 'role', 'category'));
        } else {
            return view('error.403');
        }
    }

    // Add new category
    public function addCategory(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('category.add')) {
            $validatedData = $request->validate([
                'category_name' => 'required|max:200',
            ]);
            try {
                $category = new Categories();
                $category['name'] = $request->category_name;
                if ($category->save()) {
                    return redirect()->back()->with('success', 'Category added successfully!!!');
                } else {
                    return redirect()->back()->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update category
    public function updateCategory(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('category.edit')) {
            $validatedData = $request->validate([
                'category_name' => 'required|max:50',
            ]);

            try {
                // update category
                $category = Categories::find($request->categoryId);
                $category->name = $request->category_name;
                if ($category->save()) {
                    return redirect('category-list')->with('success', 'Category updated successfully!!!');
                } else {
                    return redirect('category-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('category-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete category
    public function deleteCategory(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('category.delete')) {
            try {
                $id = $request->id;
                $category = Categories::find($id)->delete();
                if ($category) {
                    return redirect('category-list')->with('success', 'Category deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('category-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Add New Color View 
    public function colorList(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('color.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin' || $role == 'accountant') {
                $colors = Colors::where('is_deleted', 0)->get();
            }

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($colors)
                    ->addIndexColumn()
                    ->addColumn('color_name', function ($row) {
                        $color_name = $row->name;
                        return $color_name;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('Y-m-d H:i:s', strtotime($row->created_at));
                        $created_at = $created_at;
                        return $created_at;
                    })
                    ->addColumn('action', function ($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                <button class="btn btn-soft-info btn-sm d-inline-block edit-button" data-bs-toggle="modal" data-bs-target="#editColorModal" data-edit-id="' . $row->id . '"><i class="las la-pen fs-17 align-middle"></i></button>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                <button type="button" class="btn btn-soft-danger btn-sm d-inline-block remove-btn"  data-remove-id="' . $row->id . '"><i class="las la-trash fs-17 align-middle"></i></button>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['color_name', 'created_at', 'created_by', 'action'])->make(true);
            }
            // End

            return view('color.color-list', compact('user', 'role', 'colors'));
        } else {
            return view('error.403');
        }
    }

    // Add new color
    public function addColor(Request $request)
    {
        $authUser = Sentinel::getUser();
        if ($authUser->hasAccess('color.add')) {
            $validatedData = $request->validate([
                'color_name' => 'required|max:200',
            ]);
            try {
                $color = new Colors();
                $color['name'] = $request->color_name;
                if ($color->save()) {
                    return redirect()->back()->with('success', 'Color added successfully!!!');
                } else {
                    return redirect()->back()->with('error', 'Failed to add!!!');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Update color
    public function updateColor(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($user->hasAccess('color.edit')) {
            $validatedData = $request->validate([
                'color_name' => 'required|max:50',
            ]);

            try {
                // update category
                $color = Colors::find($request->colorId);
                $color->name = $request->color_name;
                if ($color->save()) {
                    return redirect('color-list')->with('success', 'Color updated successfully!!!');
                } else {
                    return redirect('color-list')->with('error', 'Failed to update!!!');
                }
            } catch (Exception $e) {
                return redirect('color-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete color
    public function deleteColor(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('color.delete')) {
            try {
                $id = $request->id;
                $color = Colors::find($id)->delete();
                if ($color) {
                    return redirect('color-list')->with('success', 'Color deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('color-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Delete sub image
    public function deleteSubImage(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('product.delete')) {
            try {
                $id = $request->subImageId;
                $productImage = ProductImages::find($id);
                $old_image_destination = 'assets/images/products/' . $productImage->image;
                if (File::exists(public_path($old_image_destination))) {
                    File::delete(public_path($old_image_destination));
                }
                if ($productImage->delete()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Image deleted successfully!!!',
                    ]);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Something went wrong!!!',
                ]);
            }
        } else {
            return view('error.403');
        }
    }
}
