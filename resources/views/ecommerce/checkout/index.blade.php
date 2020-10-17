@extends('layouts.app')

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.product')}}</li>
    
@endsection

@section('content')
<div class="container">
    <div class="mb-5">
        <h1 class="text-center">Checkout</h1>
    </div>
    <!-- Accordion -->
    <div id="shopCartAccordion" class="accordion rounded mb-5">
        <!-- Card -->
        <div class="card border-0">
            <div id="shopCartHeadingOne" class="alert alert-primary mb-0" role="alert">
                Returning customer? <a href="#" class="alert-link" data-toggle="collapse" data-target="#shopCartOne" aria-expanded="false" aria-controls="shopCartOne">Click here to login</a>
            </div>
            <div id="shopCartOne" class="collapse border border-top-0" aria-labelledby="shopCartHeadingOne" data-parent="#shopCartAccordion" style="">
                <!-- Form -->
                <form class="js-validate p-5">
                    <!-- Title -->
                    <div class="mb-5">
                        <p class="text-gray-90 mb-2">Welcome back! Sign in to your account.</p>
                        <p class="text-gray-90">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                    </div>
                    <!-- End Title -->

                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Form Group -->
                            <div class="js-form-message form-group">
                                <label class="form-label" for="signinSrEmailExample3">Email address</label>
                                <input type="email" class="form-control" name="email" id="signinSrEmailExample3" placeholder="Email address" aria-label="Email address" required
                                data-msg="Please enter a valid email address."
                                data-error-class="u-has-error"
                                data-success-class="u-has-success">
                            </div>
                            <!-- End Form Group -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Form Group -->
                            <div class="js-form-message form-group">
                                <label class="form-label" for="signinSrPasswordExample2">Password</label>
                                <input type="password" class="form-control" name="password" id="signinSrPasswordExample2" placeholder="********" aria-label="********" required
                                data-msg="Your password is invalid. Please try again."
                                data-error-class="u-has-error"
                                data-success-class="u-has-success">
                            </div>
                            <!-- End Form Group -->
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div class="js-form-message mb-3">
                        <div class="custom-control custom-checkbox d-flex align-items-center">
                            <input type="checkbox" class="custom-control-input" id="rememberCheckbox" name="rememberCheckbox" required
                            data-error-class="u-has-error"
                            data-success-class="u-has-success">
                            <label class="custom-control-label form-label" for="rememberCheckbox">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <!-- End Checkbox -->

                    <!-- Button -->
                    <div class="mb-1">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary-dark-w px-5">Login</button>
                        </div>
                        <div class="mb-2">
                            <a class="text-blue" href="#">Lost your password?</a>
                        </div>
                    </div>
                    <!-- End Button -->
                </form>
                <!-- End Form -->
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Accordion -->

    <!-- Accordion -->
    <div id="shopCartAccordion1" class="accordion rounded mb-6">
        <!-- Card -->
        <div class="card border-0">
            <div id="shopCartHeadingTwo" class="alert alert-primary mb-0" role="alert">
                Have a coupon? <a href="#" class="alert-link" data-toggle="collapse" data-target="#shopCartTwo" aria-expanded="false" aria-controls="shopCartTwo">Click here to enter your code</a>
            </div>
            <div id="shopCartTwo" class="collapse border border-top-0" aria-labelledby="shopCartHeadingTwo" data-parent="#shopCartAccordion1" style="">
                <form class="js-validate p-5" novalidate="novalidate">
                    <p class="w-100 text-gray-90">If you have a coupon code, please apply it below.</p>
                    <div class="input-group input-group-pill max-width-660-xl">
                        <input type="text" class="form-control" name="name" placeholder="Coupon code" aria-label="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-block btn-dark font-weight-normal btn-pill px-4">
                                <i class="fas fa-tags d-md-none"></i>
                                <span class="d-none d-md-inline">Apply coupon</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Accordion -->
    <form class="js-validate" novalidate="novalidate">
        <div class="row">
            <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                <div class="pl-lg-3 ">
                    <div class="bg-gray-1 rounded-lg">
                        <!-- Order Summary -->
                        <div class="p-4 mb-4 checkout-table">
                            <!-- Title -->
                            <div class="border-bottom border-color-1 mb-5">
                                <h3 class="section-title mb-0 pb-2 font-size-25">Your order</h3>
                            </div>
                            <!-- End Title -->

                            <!-- Product Content -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cart_item">
                                        <td>Ultra Wireless S50 Headphones S50 with Bluetooth&nbsp;<strong class="product-quantity">× 1</strong></td>
                                        <td>$1,100.00</td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td>Widescreen NX Mini F1 SMART NX&nbsp;<strong class="product-quantity">× 1</strong></td>
                                        <td>$685.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>$1,785.00</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td>Flat rate $300.00</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td><strong>$2,085.00</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- End Product Content -->
                            <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                                <!-- Basics Accordion -->
                                <div id="basicsAccordion1">
                                    <!-- Card -->
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingOne">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="stylishRadio1" name="stylishRadio" checked>
                                                <label class="custom-control-label form-label" for="stylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseOnee"
                                                    aria-expanded="true"
                                                    aria-controls="basicsCollapseOnee">
                                                    Direct bank transfer
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseOnee" class="collapse show border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingOne"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingTwo">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="secondStylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="secondStylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseTwo"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseTwo">
                                                    Check payments
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseTwo" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingTwo"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingThree">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="thirdstylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="thirdstylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseThree"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseThree">
                                                    Cash on delivery
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseThree" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingThree"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Pay with cash upon delivery.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingFour">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="FourstylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="FourstylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseFour"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseFour">
                                                    PayPal <a href="#" class="text-blue">What is PayPal?</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseFour" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingFour"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card -->
                                </div>
                                <!-- End Basics Accordion -->
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck10" required
                                        data-msg="Please agree terms and conditions."
                                        data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <label class="form-check-label form-label" for="defaultCheck10">
                                        I have read and agree to the website <a href="#" class="text-blue">terms and conditions </a>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-3 py-3">Place order</button>
                        </div>
                        <!-- End Order Summary -->
                    </div>
                </div>
            </div>

            <div class="col-lg-7 order-lg-1">
                <div class="pb-7 mb-7">
                    <!-- Title -->
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title mb-0 pb-2 font-size-25">Billing details</h3>
                    </div>
                    <!-- End Title -->

                    <!-- Billing Form -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    First name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="firstName" placeholder="Jack" aria-label="Jack" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Last name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="lastName" placeholder="Wayley" aria-label="Wayley" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="w-100"></div>

                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Company name (optional)
                                </label>
                                <input type="text" class="form-control" name="companyName" placeholder="Company Name" aria-label="Company Name" data-msg="Please enter a company name." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Country
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control js-select selectpicker dropdown-select" required="" data-msg="Please select country." data-error-class="u-has-error" data-success-class="u-has-success"
                                    data-live-search="true"
                                    data-style="form-control border-color-1 font-weight-normal">
                                    <option value="">Select country</option>
                                    <option value="AF">Afghanistan</option>
                                   
                                </select>
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-8">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Street address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="streetAddress" placeholder="470 Lucy Forks" aria-label="470 Lucy Forks" required="" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-4">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Apt, suite, etc.
                                </label>
                                <input type="text" class="form-control" placeholder="YC7B 3UT" aria-label="YC7B 3UT" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    City
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="cityAddress" placeholder="London" aria-label="London" required="" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Postcode/Zip
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="postcode" placeholder="99999" aria-label="99999" required="" data-msg="Please enter a postcode or zip code." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="w-100"></div>

                        <div class="col-md-12">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    State
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control js-select selectpicker dropdown-select" required="" data-msg="Please select state." data-error-class="u-has-error" data-success-class="u-has-success"
                                    data-live-search="true"
                                    data-style="form-control border-color-1 font-weight-normal">
                                    <option value="">Select state</option>
                                    
                                </select>
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Email address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" name="emailAddress" placeholder="jackwayley@gmail.com" aria-label="jackwayley@gmail.com" required="" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-md-6">
                            <!-- Input -->
                            <div class="js-form-message mb-6">
                                <label class="form-label">
                                    Phone
                                </label>
                                <input type="text" class="form-control" placeholder="+1 (062) 109-9222" aria-label="+1 (062) 109-9222" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="w-100"></div>
                    </div>
                    <!-- End Billing Form -->

                    <!-- Accordion -->
                    <div id="shopCartAccordion2" class="accordion rounded mb-6">
                        <!-- Card -->
                        <div class="card border-0">
                            <div id="shopCartHeadingThree" class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" id="createAnaccount" name="createAnaccount" >
                                <label class="custom-control-label form-label" for="createAnaccount" data-toggle="collapse" data-target="#shopCartThree" aria-expanded="false" aria-controls="shopCartThree">
                                    Create an account?
                                </label>
                            </div>
                            <div id="shopCartThree" class="collapse" aria-labelledby="shopCartHeadingThree" data-parent="#shopCartAccordion2" style="">
                                <!-- Form Group -->
                                <div class="js-form-message form-group py-5">
                                    <label class="form-label" for="signinSrPasswordExample1">
                                        Create account password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" name="password" id="signinSrPasswordExample1" placeholder="********" aria-label="********" required
                                    data-msg="Enter password."
                                    data-error-class="u-has-error"
                                    data-success-class="u-has-success">
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Accordion -->
                    <!-- Title -->
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title mb-0 pb-2 font-size-25">Shipping Details details</h3>
                    </div>
                    <!-- End Title -->
                    <!-- Accordion -->
                    <div id="shopCartAccordion3" class="accordion rounded mb-5">
                        <!-- Card -->
                        <div class="card border-0">
                            <div id="shopCartHeadingFour" class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" id="shippingdiffrentAddress" name="shippingdiffrentAddress" >
                                <label class="custom-control-label form-label" for="shippingdiffrentAddress" data-toggle="collapse" data-target="#shopCartfour" aria-expanded="false" aria-controls="shopCartfour">
                                    Ship to a different address?
                                </label>
                            </div>
                            <div id="shopCartfour" class="collapse mt-5" aria-labelledby="shopCartHeadingFour" data-parent="#shopCartAccordion3" style="">
                                <!-- Shipping Form -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                First name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="firstName" placeholder="Jack" aria-label="Jack" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Last name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="lastName" placeholder="Wayley" aria-label="Wayley" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>

                                    <div class="col-md-12">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Company name (optional)
                                            </label>
                                            <input type="text" class="form-control" name="companyName" placeholder="Company Name" aria-label="Company Name" data-msg="Please enter a company name." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-12">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Country
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control js-select selectpicker dropdown-select" required="" data-msg="Please select country." data-error-class="u-has-error" data-success-class="u-has-success"
                                                data-live-search="true"
                                                data-style="form-control border-color-1 font-weight-normal">
                                                <option value="">Select country</option>
                                                <option value="AF">Afghanistan</option>
                                                
                                            </select>
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-8">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Street address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="streetAddress" placeholder="470 Lucy Forks" aria-label="470 Lucy Forks" required="" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Apt, suite, etc.
                                            </label>
                                            <input type="text" class="form-control" placeholder="YC7B 3UT" aria-label="YC7B 3UT" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                City
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="cityAddress" placeholder="London" aria-label="London" required="" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Postcode/Zip
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="postcode" placeholder="99999" aria-label="99999" required="" data-msg="Please enter a postcode or zip code." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>

                                    <div class="col-md-12">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                State
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control js-select selectpicker dropdown-select" required="" data-msg="Please select state." data-error-class="u-has-error" data-success-class="u-has-success"
                                                data-live-search="true"
                                                data-style="form-control border-color-1 font-weight-normal">
                                                <option value="">Select state</option>
                                                <option value="AF">Afghanistan</option>
                                                
                                            </select>
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Email address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" name="emailAddress" placeholder="jackwayley@gmail.com" aria-label="jackwayley@gmail.com" required="" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Phone
                                            </label>
                                            <input type="text" class="form-control" placeholder="+1 (062) 109-9222" aria-label="+1 (062) 109-9222" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>
                                </div>
                                <!-- End Shipping Form -->
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Accordion -->
                    <!-- Input -->
                    <div class="js-form-message mb-6">
                        <label class="form-label">
                            Order notes (optional)
                        </label>

                        <div class="input-group">
                            <textarea class="form-control p-5" rows="4" name="text" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        </div>
                    </div>
                    <!-- End Input -->
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')

@endsection