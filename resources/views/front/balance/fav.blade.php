@extends('layouts.front.balance')
@section('content')
    <div id="area" class="small_pt small_pb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider clearfix"></div>
                    <div class="table-responsive shop_cart_table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="product-thumbnail"></th>
                                <th class="product-name">محصول</th>
                                <th class="product-price">قیمت</th>
                                <th class="product-stock-status"></th>
                                <th class="product-add-to-cart"></th>
                                <th class="product-remove"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="(fav, index) in favs.data">
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#">
                                            <img :src="'/images/product/'+fav.product.image">
                                        </a>
                                    </td>
                                    <td class="product-name" data-title="Product">
                                        <a href="#" @click.prevent="detail(fav.product.slug)">
                                            @{{ fav.product.name }}
                                        </a>
                                    </td>
                                    <td class="product-price" data-title="Price">
                                        @{{ calculateDiscount(fav.product.price,fav.product.discount) }} تومان
                                    </td>
                                    <td class="product-stock-status" data-title="Stock Status">
                                        <span class="badge badge-pill badge-success" v-if="exist(fav.product.exist)">در انبار</span>
                                        <span class="badge badge-pill badge-danger" v-else>تمام شده</span>
                                    </td>
                                    <td class="product-add-to-cart">
                                        <a @click.prevent="detail(fav.product.slug)"
                                           class="btn btn-default btn-sm">خرید محصول</a>
                                    </td>
                                    <td class="product-remove" data-title="Remove">
                                        <a @click="deleteFav(fav.id)"><i class="ti-close"></i></a>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div
                                v-if="!favs.data.length"
                                class="alert alert-info" role="alert" style="text-align: center">
                            لیست علاقه مندی ها خالی است !
                        </div>
                    </div>
                    <div class="row mt-2 mr-3">
                        <pagination :data="favs" @pagination-change-page="fetchFavs"></pagination>
                    </div>
                    <div class="medium_divider clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var app = new Vue({
            el: '#area',
            data: {
                favs: [],
                cal_discount: '',
            },
            methods: {
                fetchFavs() {
                    axios.get(`/fetch/favs`).then(res => {
                        this.$data.favs = res.data;
                    });
                },
                calculateDiscount(price, discount) {
                    onePercent = price / 100;
                    difference = 100 - discount;
                    total = difference * onePercent;
                    this.cal_discount = Math.round(total);
                    return this.cal_discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
                detail(slug) {
                    window.location.href = `/detail/${slug}`;
                },
                exist(num) {
                    if (num <= 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                deleteFav(id) {
                    let obj = this;
                    swal.fire({
                        text: "آیا از پاک کردن اطمینان دارید ؟",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'بله',
                        cancelButtonText: 'لغو',
                    }).then((result) => {
                        if (result.value) {
                            axios.get(`/fav/delete/${id}`).then(res => {
                                obj.fetchFavs();
                            });
                        }
                    });
                },
            },
            mounted: function () {
                this.fetchFavs();
            }
        })
    </script>
@endsection

@section('style')

@endsection

