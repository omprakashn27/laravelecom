@extends('layouts.front')

@section('title')
    Checkout
@endsection

@section('content')

    <div class="py-3 mb-4 shadow-sm bg-warning border-top">
        <div class="container">
            <h6 class="mb-0">
                <a href="{{ url('/') }}">
                    Home
                </a> /
                <a href="{{ url('checkout') }}">
                    Checkout
                </a>
            </h6>
        </div>
    </div>

    <div class="container mt-3">
        <form action="{{ url('place-order') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h6>Basic Details</h6>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">First Name</label>
                                    <input type="text" required class="form-control firstname" value="{{ Auth::user()->name }}" name="fname" placeholder="Enter First Name">
                                    <span id="fname_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Last Name</label>
                                    <input type="text" required class="form-control lastname" value="{{ Auth::user()->lname }}" name="lname" placeholder="Enter Last Name">
                                    <span id="lname_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Email</label>
                                    <input type="text" required class="form-control email" value="{{ Auth::user()->email }}" name="email" placeholder="Enter Email">
                                    <span id="email_error" class="text-danger"></span>

                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Phone Number</label>
                                    <input type="text" required class="form-control phone" value="{{ Auth::user()->phone }}" name="phone" placeholder="Enter Phone Number">
                                    <span id="phone_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Address 1</label>
                                    <input type="text" required class="form-control address1" value="{{ Auth::user()->address1 }}" name="address1" placeholder="Enter Address 1">
                                    <span id="address1_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Address 2</label>
                                    <input type="text" required class="form-control address2" value="{{ Auth::user()->address2 }}" name="address2" placeholder="Enter Address 2">
                                    <span id="address2_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">City</label>
                                    <input type="text" required class="form-control city" value="{{ Auth::user()->city }}" name="city" placeholder="Enter City">
                                    <span id="city_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">State</label>
                                    <input type="text" required class="form-control state" value="{{ Auth::user()->state }}" name="state" placeholder="Enter State">
                                    <span id="state_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Country</label>
                                    <input type="text" required class="form-control country" value="{{ Auth::user()->country }}" name="country" placeholder="Enter Country">
                                    <span id="country_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Pin Code</label>
                                    <input type="text" required class="form-control pincode" value="{{ Auth::user()->pincode }}" name="pincode" placeholder="Enter Pin Code">
                                    <span id="pincode_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h6>Order Details</h6>
                            <hr>
                            @php $total = 0; @endphp
                            @if($cartitems->count() > 0)
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartitems as $item)
                                        <tr>
                                            @php $total += ($item->products->selling_price * $item->prod_qty) @endphp
                                            <td>{{ $item->products->name }}</td>
                                            <td>{{ $item->prod_qty }}</td>
                                            <td>{{ $item->products->selling_price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h6 class="px-2">Grand Total  <span class="float-end">Rs {{ $total }} </span></h6>
                                <hr>
                                <input type="hidden" name="payment_mode" value="COD">
                                <button type="submit" class="btn btn-success w-100 mb-2">Place Order | COD</button>
                                <button type="button" class="btn btn-primary w-100 mb-2 razorpay_btn">Pay with Razorpay</button>
                                <div id="paypal-button-container"></div>
                            @else
                                <h4 class="text-center">No products in cart</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id=AZs2Jlax_z6GXz7Xo8iCfBF2PwwbatjT0fG0M--HtqzLpL8UZfLx_zbIB8SupDvz_kH98zh5OwL6QV94"> </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        paypal.Buttons({
            onClick: function(data, actions) {
                // My validation...
                if($.trim($('.firstname').val()).length == 0){
                    error_fname = 'Please enter First Name';
                    $('#fname_error').text(error_fname);
                }else{
                    error_fname = '';
                    $('#fname_error').text(error_fname);
                }

                if($.trim($('.lastname').val()).length == 0){
                    error_lname = 'Please enter Last Name';
                    $('#lname_error').text(error_lname);
                }else{
                    error_lname = '';
                    $('#lname_error').text(error_lname);
                }

                if($.trim($('.email').val()).length == 0){
                    error_email = 'Enter email address';
                    $('#email_error').text(error_email);
                }else{
                    error_email = '';
                    $('#email_error').text(error_email);
                }

                if($.trim($('.phone').val()).length == 0){
                    error_phone = 'Please enter a valid phone number';
                    $('#phone_error').text(error_phone);
                }else{
                    error_phone = '';
                    $('#phone_error').text(error_phone);
                }

                if($.trim($('.address1').val()).length == 0){
                    error_address1 = 'Please enter address 1';
                    $('#address1_error').text(error_address1);
                }else{
                    error_address1 = '';
                    $('#address1_error').text(error_address1);
                }

                if($.trim($('.address2').val()).length == 0){
                    error_address2 = 'Please enter address 2';
                    $('#address2_error').text(error_address2);
                }else{
                    error_address2 = '';
                    $('#address2_error').text(error_address2);
                }

                if($.trim($('.country').val()).length == 0){
                    error_country = 'Please enter country name';
                    $('#country_error').text(error_country);
                }else{
                    error_country = '';
                    $('#country_error').text(error_country);
                }

                if($.trim($('.state').val()).length == 0){
                    error_state = 'Please enter state';
                    $('#state_error').text(error_state);
                }else{
                    error_state = '';
                    $('#state_error').text(error_state);
                }

                if($.trim($('.city').val()).length == 0){
                    error_city = 'Please enter city';
                    $('#city_error').text(error_city);
                }else{
                    error_city = '';
                    $('#city_error').text(error_city);
                }

                if($.trim($('.pincode').val()).length == 0){
                    error_zipcode = 'Please enter Pincode';
                    $('#pincode_error').text(error_zipcode);
                }else{
                    error_zipcode = '';
                    $('#pincode_error').text(error_zipcode);
                }
                if(error_fname != '' || error_lname != ''
                || error_phone != '' || error_address1 != ''
                || error_address2 != '' || error_email != ''
                || error_country != '' || error_state != ''
                || error_city != '' || error_zipcode != '')
                {
                    swal("Alert !","All fields are mandatory","warning");
                    return false;
                }
                else
                {
                    return true;
                }
            },
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                purchase_units: [{
                    amount: {
                    value: '{{ $total }}'
                    }
                }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                //   alert('Transaction completed by ' + details.payer.name.given_name);

                    var firstname = $('.firstname').val();
                    var lastname = $('.lastname').val();
                    var email = $('.email').val();
                    var phone = $('.phone').val();
                    var address1 = $('.address1').val();
                    var address2 = $('.address2').val();
                    var city = $('.city').val();
                    var state = $('.state').val();
                    var country = $('.country').val();
                    var pincode = $('.pincode').val();

                    $.ajax({
                        method: "POST",
                        url: "/place-order",
                        data: {
                            'fname':firstname,
                            'lname':lastname,
                            'email':email,
                            'phone':phone,
                            'address1':address1,
                            'address2':address2,
                            'city':city,
                            'state':state,
                            'country':country,
                            'pincode':pincode,
                            'payment_mode':"Paid by Paypal",
                            'payment_id':details.id,
                        },
                        success: function (response) {
                            swal(response.status);
                            window.location.href = "/my-orders";
                        }
                    });
                });
            }
            }).render('#paypal-button-container');
        //This function displays Smart Payment Buttons on your web page.
    </script>

@endsection
