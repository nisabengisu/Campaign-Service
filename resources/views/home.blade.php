@extends('component')
@section('title')
    <?php $title= "Campaign Service" ?>
    {{ $title }}
@endsection
@section('content')
    <section class="product-gallery">
    <?php //echo $brands; die;?>
        @if ($categories)
            @foreach ($categories as $category)
                <h2>{{ $category->name }}</h2>
                <ul class="reset">
                    @if ($products)
                        @foreach($products as $product)
                           @if ($brands)
                                @foreach ($brands as $brand)
                                    @if ($product->category_id==$category->id)
                                        @if ($brand->id==$product->brand_id)
                                            <?php $brand_name= $brand->name ?>
                                            @else 
                                            <?php $brand_name= "Other Brand" ?>
                                        @endif
                                        <li>
                                            <i class="fa-solid fa-shirt"></i>
                                            <h4><span>{{ $brand_name }}</span>{{ $product->name }}</h4>
                                            <p class="price">₺{{ $product->price }}</p>
                                            <form action="{{ route('basket.add') }}" method="POST">
                                                @csrf
                                                <button type="submit" id="add-to-cart">Sepete Ekle</button>
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                                <input type="hidden" name="brand_id" value="{{ $product->brand_id }}">
                                            </form>
                                            @if (Session::has('message'))
                                                <script>
                                                    swal("Başarılı", "{{ Session::get('message') }}", 'success', {
                                                        button: true, 
                                                        button: "OK",
                                                        timer: 3000, 
                                                        dangerMode: true,
                                                    });
                                                </script>
                                                
                                            @endif
                                        </li>                                                 
                                    @endif
                                @endforeach
                           @endif
                        @endforeach
                    @endif
                </ul>
            @endforeach
            
        @endif
    </section>
@endsection

