<x-header title="Register" description="Hello World" keywords="InfoTech eCommerce Register here"/>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <span></span>
                    <h2>Create New Account</h2>
                </div>
                <div class="contact__form">
                    <form action="{{URL::to('registerUser')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-lg-6">
                                <input type="text" name="fullname" placeholder="Name" autocomplete="off" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="file" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="register" class="site-btn">Sign Up</button>
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