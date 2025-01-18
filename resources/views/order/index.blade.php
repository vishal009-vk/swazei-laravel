<x-app-layout title="Orders">

    <x-slot name="heading">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Orders</h1>
        </div>
    </x-slot>

    @if(count($orders) > 0)
    <div class="row">
        @foreach ($orders as $order)
        <div class="col-lg-12 col-md-12 mb-1" style="border-bottom: 1px solid; padding-bottom: 10px;" id="order-{{ $order->unique_id }}">
            <div class="row">
                <div class="col-lg-3 col-md-3" style="margin-top: 2%;">
                    <img src="{{ $order->product->image }}" height="100px" width="100px" />
                </div>
                <div class="col-lg-3 col-md-3" style="margin-top: 2%;">
                    <b>
                        {{ $order->order_no }}
                    </b>
                </div>
                <div class="col-lg-3 col-md-3" style="margin-top: 2%;">
                    {{ $order->order_date }}
                </div>
                <div class="col-lg-3 col-md-3" style="margin-top: 2%;">
                    <a href="javascript:void(0)" class="btn btn-danger" onclick="cancelOrder('{{ route('cancel.order', $order->unique_id) }}', '{{ $order->unique_id }}')">
                        Cancel order
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <h5>
                No orders found
            </h5>
        </div>
    </div>
    @endif

    <x-slot name="scripts">
        <script>
            function cancelOrder(url, orderId) {
                Swal.fire({
                    title: 'Are you sure', 
                    text: "You want to delete this ?", 
                    icon: 'warning', 
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                        type: "GET", 
                        url: url
                    }).done(function(res) {
                        if (res.status) {
                            Swal.fire({
                                title: "Success", 
                                text: res.message, 
                                icon: "success"
                            });

                            $("#order-"+orderId).remove()
                        } else {
                            Swal.fire({
                                title: "Error", 
                                text: res.message, 
                                icon: "error"
                            });
                        }
                    });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
