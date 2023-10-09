@extends('component')
@section('title')
    <?php $title= "Campaign Service" ?>
    {{ $title }}
@endsection
@section('content')
    <section class="basket">
    <?php //echo $brands; die;?>
        @if ($basketData AND count($basketData) AND count($basketData) > 0)
        <?php $basket_count=count($basketData); ?>
            <h1>Sepet<span>({{ $basket_count }})</span></h1>
            <ul class="reset">
               @foreach ($basketData as $item)
                    <li> <!--Her bir li ürün listemede kullanılacak -->
                        <ol>
                            <li>
                                <i class="fa-solid fa-shirt"></i>    
                            </li><li><!--Her bir li sepetteki ürünün içeriğini listelemede kullanılacak -->
                                <h3>{{ $item['name'] ?? ''}}</h3>
                            </li><li>
                                <?php $line=""; if($item['salePrice'] > 0) { $line="line"; } ?>
                                <p class="{{ $line }}">₺{{ $item['price'] }}</p>
                                @if ($item['salePrice']!=0)
                                    <p>İndirimli Fiyatı: ₺{{ $item['salePrice'] }}</p>
                                @endif
                            </li><li>
                                <a href="/sepet/remove/{{ $item['id'] }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                        </ol>
                    </li>
               @endforeach
            </ul>
            <p class="total">Toplam Tutar:<span>₺{{ $totalAmount }}</span></p>
            @if ($campaignsData)
                <ul class="reset campaigns">
                    <?php $discountText=""; ?>
                    @foreach ($campaignsData as $campaign)
                        @if ($campaign->type==0)
                            <?php $discountText=$campaign->discount."TL" ?>
                            @else
                            <?php $discountText=$campaign->discount."%" ?>
                        @endif
                        <li><p class="campaign">Modanisa Apparel Kategorisinde {{ $discountText }} İndirim! Kampanya Kodu:<span>{{ $campaign->code }}</span></p></li>
                    @endforeach
                </ul>

                @if (Session::has('message'))
                    <script>
                        swal("Başarılı", "{{ Session::get('message') }}", 'success', {
                            button: true, 
                            button: "OK",
                            timer: 3000, 
                            dangerMode: true,
                        });
                    </script>
                    @elseif(Session::has('warn'))
                    <script>
                        swal("Hatalı", "{{ Session::get('warn') }}", 'warning', {
                            button: true, 
                            button: "NO",
                            timer: 3000, 
                            dangerMode: true,
                        });
                    </script>   
                @endif
                <form action="{{ route('basket.code') }}" method="POST">
                    @csrf
                    <input type="text" name="code" placeholder="Kampanya Kodu" autocomplete="off">
                    <button type="submit">Uygula</button>
                </form>
            @endif
        @else
         <p>Sepetinizde ürün bulunmamaktadır.</p>
         <button type="button" onclick="window.location='{{ route('home') }}'">Hemen Alışverişe Başla</button>
        @endif
    </section>
@endsection
