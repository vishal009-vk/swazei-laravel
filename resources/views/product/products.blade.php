@if(count($products))
<div class="row">
    @foreach ($products as $product)
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card" style="heigh: 100%;">
            <img class="card-img-top" src="{{ $product->image }}" height="300px">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $product->name }}
                </h5>
                <p class="card-text">
                    {{ Str::limit($product->description, 100) }}
                </p>
                <a href="javascript:void(0)" class="btn btn-primary">
                    ₹. {{ $product->price }}
                </a>
                
                <a href="javascript:void(0)" class="btn btn-success" onclick="orderProductNow('{{ route('order.product', $product->product_id) }}')">
                    Order now
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="row">
    <div class="col-sm-12 col-lg-12 mb-4 text-center">
        <h5>
            No products found
        </h5>
    </div>
</div>
@endif
