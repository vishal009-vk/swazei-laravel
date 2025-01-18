<x-app-layout title="Products">

    <x-slot name="heading">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
        </div>
    </x-slot>

    <div class="row loader">
        <div class="col-sm-12 col-lg-12 mb-4 text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="content">

    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                getProducts();
            })

            $("#searchProduct").click(function() {
                getProducts();
            })

            function getProducts() {
                $(".content").hide();
                let prodcutSearchInput = $("#prodcutSearchInput").val();
                let url = "{{ route('product.index') }}";

                $.ajax({
                    type: "GET"
                    , url: url
                    , data: {
                        search: prodcutSearchInput
                    }
                }).always(function() {
                    $(".loader").hide();
                    $(".content").show();
                }).done(function(res) {
                    $(".content").html(res.html);
                });
            }

            function orderProductNow(url) {
                $.ajax({
                    type: "GET", 
                    url: url
                }).done(function(res) {
                    if(res.status) {
                        Swal.fire({
                            title: "Success",
                            text: res.message,
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: res.message,
                            icon: "error"
                        });
                    }
                });
            }

        </script>
    </x-slot>
</x-app-layout>
