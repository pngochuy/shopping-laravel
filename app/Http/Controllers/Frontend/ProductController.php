<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddProductRequest;
use App\Http\Requests\Frontend\EditProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $userID = Auth::id();
            $productList = Product::join('categories', 'categories.id', '=', 'products.category_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.user_id', $userID)
                // tránh bi trùng tên cột `id`, `name`,... với các table khác trong cùng database khi join
                ->select(
                    'products.*',
                    'categories.name as category_name',
                    'brands.name as brand_name',
                )
                ->get();
            // `productList`: một collection chứa các bản ghi từ bảng products
            // dd($productList[0]["image"]);

            return view("frontend.my-product.my-product", compact('productList'));
        } else {
            return redirect("/frontend/login");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $categoryList = Category::all();
            $brandList = Brand::all();

            return view("frontend.my-product.add-product", compact('categoryList', 'brandList'));
        } else {
            return redirect("/frontend/login");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductRequest $request)
    {
        $product = $request->all();

        // dd($request->all());
        if ($request->hasfile('image')) {
            // dd($request->file('image'));
            foreach ($request->file('image') as $image) {

                $data[] = $this->saveImage($image);
            }
        }

        // $product = new Product();
        // $product->image = json_encode($data);
        // $product->save(); // Cách này không yêu cầu cấu hình $fillable hoặc $guarded và linh hoạt hơn trong việc kiểm soát quá trình lưu.

        $product["image"] = json_encode($data);
        $product["user_id"] = Auth::id();

        // nếu muốn kiểm tra xem giá trị có tồn tại hay không, bạn có thể sử dụng isset hoặc empty. is_null chỉ kiểm tra xem giá trị có phải là null hay không.
        if (is_null($product["sale_price"])) {
            $product["sale_price"] = "0";
        }
        // dd($product);

        if (Product::create($product)) {
            // sử dụng tính năng "mass assignment" (gán tập trung) trong Laravel. Trong mô hình, bạn cần xác định những trường có thể được gán thông qua thuộc tính $fillable hoặc $guarded.

            // dd($product);
            return redirect()->back()->with('success', 'Your product has been created!');
        } else {
            return redirect()->back()->with('failed', 'Your product could not be created!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * TODO: làm tiếp trang product-details
         * ! : product-details còn chưa lấy ra xong category, brand, ...
         * TODO: làm tiếp trang ADD TO CART (có hướng dẫn trên mess)
         */
        $currentProduct = Product::join('categories', 'categories.id', 'product.category_id');

        return view('frontend.my-product.details');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            if (Auth::check()) {
                $categoryList = Category::all();
                $brandList = Brand::all();

                $currentProduct = Product::findOrFail($id);

                return view("frontend.my-product.edit", compact('categoryList', 'brandList', 'currentProduct'));
            } else {
                return redirect("/frontend/login");
            }
        } catch (ModelNotFoundException $e) {
            // Xử lý khi không tìm thấy bản ghi
            return redirect()->back()->with('failed', 'Product not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProductRequest $request, string $id)
    {
        // dd($request->all());
        // dd($request->selected_images);

        $selectedImages = $request->selected_images;
        $product = $request->all();
        $currentProduct = Product::findOrFail($id);

        $currentImages = json_decode($currentProduct->image);

        // $dataCurrentImages = [] => khởi tạo array rỗng
        // $dataCurrentImages[] = "huy" => thêm giá trị vào array
        $dataCurrentImages = [];

        // khi nào upload ảnh thì xử lí update
        if ($request->hasfile('image') != null) {
            // dd($request->file('image'));

            foreach ($request->file('image') as $image) {
                if (!in_array($image->getClientOriginalName(), $currentImages)) {

                    $data[] = $image->getClientOriginalName();

                    if (count($data) + count($currentImages) > 3) {
                        foreach ($dataCurrentImages as $imageName) {
                            $this->deleteImage($imageName);
                        }

                        return redirect()->back()->with('upload-failed', 'Total images cannot exceed 3 after update!');
                    }

                    $dataCurrentImages = $data;
                    $this->saveImage($image);
                }
            }

            if (!empty($dataCurrentImages)) {
                $currentImages = array_merge($currentImages, $dataCurrentImages);
                // dd($dataCurrentImages);
            }
        }

        if ($selectedImages) {

            // Unset các hình ảnh được chọn
            foreach ($selectedImages as $selectedImage) {
                // kiểm tra xem giá trị của $selectedImage có tồn tại trong mảng $currentImages hay không.
                if (in_array($selectedImage, $currentImages)) {
                    // trả về index (hoặc key) của item đầu tiên đc tìm thấy
                    $index = array_search($selectedImage, $currentImages);
                    // sau đó xóa item có `index` (hoặc key) đó ra khỏi array `$selectedImage`
                    unset($currentImages[$index]);
                }
            }

            // Hàm này tạo ra một mảng mới chứa tất cả các giá trị của mảng $array, nhưng các key được reset lại bắt đầu từ 0 và tăng dần. Điều này giúp làm cho mảng có key liên tục mà không còn các khoảng trống.
            // Reset key của mảng để key về lại theo thứ tự
            $currentImages = array_values($currentImages);

            foreach ($selectedImages as $selectedImage) {
                $this->deleteImage($selectedImage);
            }
        }

        $product["image"] = json_encode($currentImages);

        if (is_null($product["sale_price"])) {
            $product["sale_price"] = "0";
        }

        if ($currentProduct->update($product)) {
            return redirect()->back()->with('success', 'Your product has been updated!');
        } else {
            return redirect()->back()->with('failed', 'Your product has not been updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    function saveImage($image)
    {
        $name = $image->getClientOriginalName();
        $name_2 = "2_" . $image->getClientOriginalName();
        $name_3 = "3_" . $image->getClientOriginalName();

        //$image->move('upload/product/', $name);
        $directory = "upload/product/" . Auth::id();
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = public_path($directory . '/' . $name);
        $path2 = public_path($directory . '/' . $name_2);
        $path3 = public_path($directory . '/' . $name_3);


        // copy thành 3 ảnh và resize thành từng ảnh để tránh TH sử dụng 1 ảnh mà user muốn phóng to hay thu nhỏ sẽ bị vỡ hình
        if (!file_exists($path)) {
            Image::make($image->getRealPath())->save($path);
        }
        if (!file_exists($path2)) {
            Image::make($image->getRealPath())->resize(85, 84)->save($path2);
        }
        if (!file_exists($path3)) {
            Image::make($image->getRealPath())->resize(392, 380)->save($path3);
        }

        // $data[] = $name;

        return $name;
    }

    function deleteImage($imageName)
    {
        $directory = "upload/product/" . Auth::id();

        $name = $imageName;
        $name_2 = "2_" . $imageName;
        $name_3 = "3_" . $imageName;

        $path = public_path($directory . '/' . $name);
        $path2 = public_path($directory . '/' . $name_2);
        $path3 = public_path($directory . '/' . $name_3);

        File::delete($path, $path2, $path3);
    }
}
