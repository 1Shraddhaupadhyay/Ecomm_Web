<x-header title="Orders" description="Hello World" keywords="InfoTech eCommerce"/>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 mx-auto">
                <div class="section-title">
                    <span></span>
                    <h2>My Order History</h2>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Total Bill</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>View Products</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=0;
                        @endphp
                        @foreach($orderhistory as $item)
                        @php
                        $i++;
                        @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->bill}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->fullname}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal{{ $i }}">
                                    Products
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">All Products</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                               <table>
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quality</th>
                                                        <th>Price</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($items as $product)
                                                    @if($item->id == $product->orderId)
                                                    <tr>
                                                        <td>
                                                            <img src="{{URL::asset('uploads/products/'.$product->picture)}}" alt="" width="100px">
                                                            {{$product->title}}
                                                        </td>
                                                        <td>
                                                            {{$product->quantity}}
                                                        </td>
                                                        <td>
                                                            {{$product->price}}
                                                        </td>
                                                        <td>
                                                            {{$product->price * $product->quantity}}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                               </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<x-footer />