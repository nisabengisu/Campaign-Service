<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Campaigns;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopcartController extends Controller
{
   public function index() {
        $basketData= Basket::all();
        $campaignsData= Campaigns::all();

        $count= Basket::count();

        $totalAmount= 0;

        foreach ($basketData as $item) {
            if($item->salePrice) {
                $totalAmount+= $item['salePrice'];
            }
            else {
                $totalAmount+= $item['price'];
            }
        }

        return view('shopcart', compact('basketData', 'totalAmount', 'campaignsData', 'count'));
   }

   public function add(Request $request) { // Sepete Ürün Ekleme
        $productId=$request->product_id;
        $product=Product::find($productId);

        if(!$product) {
            return back()->withError("Ürün Bulunamadı.");
        }

        $resetCode= Basket::where('productId', '!=', $productId)->first(); // Yeni Ürün eklendiğinde uygulanan kuponu sıfırlama
        if($resetCode) {
            $resetCode->salePrice = 0; // sıfırla
            $resetCode->update();
        }

        $data= new Basket;
        $data->productId= $productId;
        $data->name= $product->name;
        $data->category_id= $request->category_id;
        $data->brand_id= $request->brand_id;
        $data->price= $request->price;
        $data->salePrice= 0;

        $data->save();

        return redirect()->back()->with('message', 'Ürün Sepetinize Eklendi!');
   }

   public function code(Request $request) { // Kupon Kodu İşlemleri
        $request->validate(['code'=>'required']);
        $basketData= Basket::all();
        $totalAmount= 0;
        foreach ($basketData as $item) {
            $totalAmount+= $item['price'];
        }

        $code= $request->get('code');  // Kupon kodu doğru mu kontrol et
        $codeControl= Campaigns::where('code', $code)->count();
        if ($codeControl== 0) {
            return redirect()->back()->with('warn', 'Kupon Kodu Bulunamadı!');
        }

        $couponData= Campaigns::where('code', $code)->first(); // Kupon Tarihi Sorgula
        if($couponData->e_date != '' and date("Y-m-d") > $couponData->e_date) {
            return redirect()->back()->with('warn', 'Bu Kupon Kodunun Tarihi Geçmiş!');
        }
        
        $salePrice=0;
        switch ($couponData->type) {
            case Campaigns::SABIT:
                foreach ($basketData as $item) {
                    $checkCategory= Basket::where('category_id', '=', $couponData->category_id)->get(); 

                    if($checkCategory) {
                        if($item->brand_id==$couponData->brand_id) { 
                            $campaignCount= count($checkCategory);
                        }
                        else {
                            $campaignCount= 0;
                        }
                    }

                    if($campaignCount != 0) {
                        $totalDiscount=($couponData->discount) / $campaignCount;
                        $salePrice= $item['price'] - $totalDiscount;
                        
                        $product= Basket::where('productId', $item['productId'])->first();
                        $product->salePrice = $salePrice;
                        $product->update();
                    }
                    //burada kaldım
                }
            break;

            case Campaigns::YUZDE:
                $campaignCount= 0;

                foreach ($basketData as $item) {
                    $resetCode= Basket::where('productId', $item['productId'])->first(); // uygulanan kuponu sıfırlama
                    if($resetCode) {
                        $resetCode->salePrice = 0; // sıfırla
                        $resetCode->update();
                    }

                    $checkCategory= Basket::where('category_id', '=', $couponData->category_id)->get(); 

                    if($checkCategory) {
                        if($item->brand_id==$couponData->brand_id) { 
                            $campaignCount= count($checkCategory);
                        }
                        else {
                            $campaignCount= 0;
                        }
                    }
                }

                if($campaignCount % 3== 0) {
                    $checkCategory= Basket::where('category_id', '=', $couponData->category_id)->first(); 

                    if($checkCategory) {
                        if($checkCategory->category_id==$couponData->category_id) {
                            if($checkCategory->brand_id==$couponData->brand_id) { 
                                $salePrice=  $checkCategory['price'] - ( $checkCategory['price'] * $couponData->discount / 100);
    
                                $product= Basket::where('productId', $checkCategory['productId'])->first();
                                $product->salePrice = $salePrice;
                                $product->update();
                            }
                        }
                    }
                }
                else {
                    $needAdd= 3 - ($campaignCount % 3);

                    return redirect()->back()->with('warn', $needAdd.' ürün eklemeniz gerekmektedir!');
                }
            break;
        }

        return redirect()->back()->with('message', 'Kupon Uygulandı!');
    }

   public function remove($id) {
        $product= Basket::get();
        if($product) {
            foreach($product as $item) {
                if($item->salePrice!=0) {
                    $item->salePrice= 0;
                    $item->update();
                }
            }
        }

        Basket::destroy($id);
        return redirect('sepet');
   }
}
