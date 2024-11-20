<x-header title="Login" description="Log-In" keywords="InfoTech eCommerce,Login Page"/>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <span></span>
                    <h2>Login Here</h2>
                </div>
                <div class="contact__form">
                    @if(session()->has('success'))
                    <div class ="alert alert-success">
                        <p>{{ session()->get('success')}}</p>
                    </div>
                    @endif
                    @if(session()->has('error'))
                    <div class ="alert alert-danger">
                        <p>{{ session()->get('error')}}</p>
                    </div>
                    @endif
                    <form action="{{URL::to('loginUser')}}" method="POST" ecntype= "multipart/form-data">
                    @csrf    
                    <div class="row">
                            <div class="col-lg-12">
                                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="login" class="site-btn">Login</button>
                                <a href="{{ URL::to('googleLogin')}}">
                                    <img src="{{ URL::asset('googlelogin.jpg')}}" height="45px" alt="">
                                </a>
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