<x-adminheader title="Orders"  />
<!-- partial -->
<style>
.bttn{
    background-color:#be5683;
}
.btnn{
    background-color:coral;
}
.action{
    margin-left:10px;
}
</style>
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Our Orders</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <!-- <th>Email</th>
                                        <th>Customer Status</th> -->
                                        <th>Bill</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Order Status</th>
                                        <th>Order Date</th>
                                        <th>Products</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=0;
                                    @endphp
                                    @foreach($orders as $item)
                                    @php
                                    $i++;
                                    @endphp
                                    <tr>
                                        <td>{{$item->fullname}}</td>
                                        <!-- <td>{{$item->email}}</td>
                                        <td class="text-info">{{$item->userStatus}}</td> -->
                                        <td class="font-weight-bold">{{$item->bill}} ₹.</td>
                                        <td>{{$item->phone}}</td>
                                        <td>{{$item->address}}</td>
                                        <td class="font-weight-medium">
                                            <div class="badge badge-success">{{$item->status}}</div>
                                        </td>
                                        <td class="font-weight-medium">
                                            <div class="badge badge-info">{{$item->created_at}}</div>
                                        </td>
                                        <td class="font-weight-medium">
                                            <a type="button" class="btn bttn text-white" data-toggle="modal"
                                                data-target="#updateModel{{$i}}">Products</a>
                                            
                                            <div class="modal" id="updateModel{{$i}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Order Products</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <table class="table table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        Product
                                                                    </th>
                                                                    <th>
                                                                        Picture
                                                                    </th>
                                                                    <th>
                                                                        Price/Item
                                                                    </th>
                                                                    <th>
                                                                        Quantity
                                                                    </th>
                                                                    <th>
                                                                        Sub Total
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($orderItems as $oItem)
                                                                @if($oItem->orderId == $item->id)
                                                                <tr>
                                                                    <td>
                                                                        {{ $oItem->title }}
                                                                    </td>
                                                                    <td>
                                                                        <img src="{{URL::asset('uploads/products/'.$oItem->picture)}}" width="100px" alt="">
                                                                    </td>
                                                                    <td>
                                                                        {{ $oItem->price }} ₹.
                                                                    </td>
                                                                    <td>
                                                                        {{ $oItem->quantity }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $oItem->quantity * $oItem->price}} ₹.
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                            </tbody>
                                                           </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                       
                                        <td>
                                            @if($item->status=='Paid')
                                            <a href="{{ URL::to('changeOrderStatus/Accepted/'.$item->id) }}" class="btn btn-warning">Accept</a>
                                            <a href="{{ URL::to('changeOrderStatus/Rejected/'.$item->id) }}" class="btn btn-danger">Reject</a>
                                            @elseif($item->status=='Accepted')
                                            <a href="{{ URL::to('changeOrderStatus/Delivered/'.$item->id) }}" class="btn btn-success">Completed</a>
                                            @elseif($item->status=='Delivered')
                                            Already Completed
                                            @else
                                            <a href="" class="btn btn-danger">Reject</a>
                                            <a href="{{ URL::to('changeOrderStatus/Accepted/'.$item->id) }}" class="btn btn-success">Accepted</a>
                                            <span class="responsive" style="font-size:10px;">(Order is Rejected, Want to Accept then Click On Accepted.)</span>
                                            @endif
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-adminfooter />