<x-header title="Account Details" description="Hello World" keywords="InfoTech eCommerce"/>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <span></span>
                    <h2>My Account</h2>
                </div>
                <div class="contact__form">
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        <p>{{ session()->get('success')}}</p>
                    </div>
                    @endif
                    <img src="{{ URL::asset('uploads/profiles/'.$user->picture) }}" class="mx-auto d-block mb-2"
                        width="75" alt="">
                    <form action="{{URL::to('updateUser')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="fullname" placeholder="Name" value="{{$user->fullname}}">
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Email" value="{{$user->email}}">
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="file">
                            </div>
                            <div class="col-lg-12">
                                <input type="password" name="password" value="{{$user->password}}"
                                    placeholder="Password">
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="register" class="site-btn">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<x-footer />