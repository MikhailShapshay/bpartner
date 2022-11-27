<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\PropertyRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function categorys()
    {
        $categories = Category::with('categories')
            ->with("categories.categories")
            ->where('parent_id', "=",0)
            ->get();

        return response()->json(['categorys' => $categories]);
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductBySlug(ProductRequest $request){
        $data = $request->validated();

        $product = Product::with('property')
            ->where('slug', "=",$data['slug'])
            ->first();
        if(!$product){
            return response("Product not find!", 404);
        }

        return response()->json(['product' => $product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request){
        $category_id = null;
        $filters = null;
        $add_sql = "products.id <> 0";
        $filter_bool = false;

        if(isset($request->category_id) && (int) $request->category_id > 0){
            $category_id = (int) $request->category_id;
            $add_sql.= " AND products.category_id = ".$category_id;
        }

        if(isset($request->cost) && (float)$request->cost > 0){
            $cost = (float) $request->cost;
            $add_sql.= " AND products.cost = ".$cost;
        }

        if(isset($request->filters) && is_array($request->filters)){
            foreach ($request->filters as $filter){
                $title = array_key_first($filter);
                $value = $filter[$title];
                if((string)$title && (string)$value){
                    if(!$filter_bool){
                        $add_sql.= " AND ( (properties.title = '".$title."' AND properties.value = '".$value."') ";
                        $filter_bool = true;
                    }
                    else{
                        $add_sql.= "OR (properties.title = '".$title."' AND properties.value = '".$value."') ";
                    }
                }
            }
            if($filter_bool) $add_sql.= ") ";
        }

        $products = DB::table('products')
            ->selectRaw('DISTINCT products.*')
            ->join('properties', 'properties.product_id', '=', 'products.id')
            ->whereRaw($add_sql)
        ->get();

        if(!$products || $products->count() < 1){
            return response("Product not find!", 404);
        }

        return response()->json(['products' => $products]);
    }

    /**
     * @param PropertyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProperty(PropertyRequest $request){
        $data = $request->validated();

        $product = Product::with('property')
            ->where('slug', "=", $data['slug'])
            ->first();

        if(!$product){
            return response("Product not find!", 404);
        }

        Property::create([
            'product_id' => $product->id,
            'title' => $data['title'],
            'value' => $data['value']
        ]);

        $product->refresh();

        return response()->json(['product' => $product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delProperty(Request $request){
        $data = $request->validate(
            [
                'property_id' => 'required|integer'
            ]
        );

        $property = Property::where('id', "=", $data['property_id'])->first();

        if(!$property){
            return response("Property not find!", 404);
        }

        $product_id = $property->product_id;

        $property->delete();

        $product = Product::with('property')
            ->where('id', "=", $product_id)
            ->first();

        return response()->json(['product' => $product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOrder(Request $request){

        if(auth()){
            $name = $request->user()->name;
            $email = $request->user()->email;
            $phone = $request->user()->phone;
            $user_id = $request->user()->id;
            $ses_id = '';
        }
        else{
            $data = $request->validate(
                [
                    'name' => 'required|string',
                    'email' => 'required|email',
                    'phone' => 'required|string',
                ]
            );
            $name = $data['name'];
            $email = $data['email'];
            $phone = $data['phone'];
            $user_id = 0;
            if ($request->session()->has('ses_id')) {
                $ses_id = $request->session()->get('ses_id');
            }
            else{
                $ses_id = Str::random(50);
                $request->getSession()->push('ses_id', $ses_id);
            }

        }

        $product = Product::where('slug', "=", $data['slug'])->first();

        if(!$product){
            return response("Product not find!", 404);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'ses_id' => $user_id,
        ]);

        $order = Order::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $data['title'],
        ]);

        return response()->json(['order' => $order]);
    }
}
