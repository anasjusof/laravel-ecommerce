@extends('layout')

@section('title', 'Checkout')

@section('extra-css')

@endsection

@section('content')

    <div class="container">

        @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section">
            <div>
                <form action="{{ route('checkout.store') }}" id="payment-form" method="POST">
                    {{ csrf_field() }}
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <h2>Payment Details</h2>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    {{-- <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="expiry">Expiry</label>
                            <input type="text" class="form-control" id="expiry" name="expiry" placeholder="MM/DD">
                        </div>
                        <div class="form-group">
                            <label for="cvc">CVC Code</label>
                            <input type="text" class="form-control" id="cvc" name="cvc" value="">
                        </div>
                    </div> <!-- end half-form --> --}}
                    
                    <div class="form-group">
                        <label for="card-element">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          <!-- A Stripe Element will be inserted here. -->
                        </div>

                        
                    
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                      </div>

                    <div class="spacer"></div>

                    <input id="complete-order" type="submit" class="button-primary full-width" value="Complete Order">

                </form>

                <script src="https://js.stripe.com/v3/"></script>

                    <script>

                        (function() {
                            // Create a Stripe client.
                            var stripe = Stripe('pk_test_51HYnklEcIbh9mBZlIejWLFL8fjpVXqSGMeCvIqEG2K3cBLaPvzfUSXZs7xe1s7b9eXnXUjjuswKXdHEX3ZNkTFrs00b8dOo0qo');
                    
                            // Create an instance of Elements.
                            var elements = stripe.elements();
                    
                            // Custom styling can be passed to options when creating an Element.
                            // (Note that this demo uses a wider set of styles than the guide below.)
                            var style = {
                            base: {
                                color: '#32325d',
                                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                fontSmoothing: 'antialiased',
                                fontSize: '16px',
                                '::placeholder': {
                                color: '#aab7c4'
                                }
                            },
                            invalid: {
                                color: '#fa755a',
                                iconColor: '#fa755a'
                            }
                            };
                    
                            // Create an instance of the card Element.
                            var card = elements.create('card', {style: style, hidePostalCode: true});
                    
                            // Add an instance of the card Element into the `card-element` <div>.
                            card.mount('#card-element');
                            // Handle real-time validation errors from the card Element.
                            card.on('change', function(event) {
                            var displayError = document.getElementById('card-errors');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                            });
                    
                            // Handle form submission.
                            var form = document.getElementById('payment-form');
                            form.addEventListener('submit', function(event) {
                            event.preventDefault();

                            //Disabled the submit button
                            document.getElementById('complete-order').disabled = true;

                            var options = {
                                name: document.getElementById('name').value,
                                address_line1: document.getElementById('address').value,
                                address_city: document.getElementById('city').value,
                                address_state: document.getElementById('province').value,
                                address_zip: document.getElementById('postalcode').value,
                            }
                    
                            stripe.createToken(card, options).then(function(result) {
                                if (result.error) {
                                // Inform the user if there was an error.
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = result.error.message;
                                document.getElementById('complete-order').disabled = false;
                                } else {
                                // Send the token to your server.
                                stripeTokenHandler(result.token);
                                }
                            });
                            });
                    
                            // Submit the form with the token ID.
                            function stripeTokenHandler(token) {
                                // Insert the token ID into the form so it gets submitted to the server
                                var form = document.getElementById('payment-form');
                                var hiddenInput = document.createElement('input');
                                hiddenInput.setAttribute('type', 'hidden');
                                hiddenInput.setAttribute('name', 'stripeToken');
                                hiddenInput.setAttribute('value', token.id);
                                form.appendChild(hiddenInput);
                        
                                // Submit the form
                                form.submit();
                            }
                        })();
                        
                    </script>
            </div>



            <div class="checkout-table-container">
                <h2>Your Order</h2>

                <div class="checkout-table">
                    @foreach(Cart::content() as $item)
                    <div class="checkout-table-row">
                        <div class="checkout-table-row-left">
                            <img src="/img/macbook-pro.png" alt="item" class="checkout-table-img">
                            <div class="checkout-item-details">
                                <div class="checkout-table-item">{{ $item->model->name }}</div>
                                <div class="checkout-table-description">{{ $item->model->details }}</div>
                                <div class="checkout-table-price">{{ $item->model->presentPrice() }}</div>
                            </div>
                        </div> <!-- end checkout-table -->

                        <div class="checkout-table-row-right">
                            <div class="checkout-table-quantity">{{ $item->qty }}</div>
                        </div>
                    </div> <!-- end checkout-table-row -->
                    @endforeach

                </div> <!-- end checkout-table -->

                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        Subtotal <br>
                        {{-- Discount (10OFF - 10%) <br> --}}
                        Tax <br>
                        <span class="checkout-totals-total">Total</span>

                    </div>

                    <div class="checkout-totals-right">
                        {{ presentPrice(Cart::subtotal()) }} <br>
                        {{-- -$750.00 <br> --}}
                        {{ presentPrice(Cart::tax()) }} <br>
                        <span class="checkout-totals-total">{{ presentPrice(Cart::total()) }}</span>

                    </div>
                </div> <!-- end checkout-totals -->

                <a href="#" class="have-code">Have a Code?</a>

                <div class="have-code-container">
                    <form action="#">
                        <input type="text">
                        <input type="submit" class="button" value="Apply">
                    </form>
                </div>
            </div>

        </div> <!-- end checkout-section -->
    </div>

@endsection

@section('extra-js')

