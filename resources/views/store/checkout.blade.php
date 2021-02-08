<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>labtop</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/css/intlTelInput.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">



    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/all-product.css')}}">
    <link rel="stylesheet" href="{{asset('css/filter.css')}}">
    <link rel="stylesheet" href="{{asset('css/smoothproducts.css')}}">
    <link rel="stylesheet" href="{{asset('css/singleProduct.css')}}">
    <link rel="stylesheet" href="{{asset('css/checkout.css')}}">
    <link rel="stylesheet" href="{{asset('css/shoppingcart.css')}}">


    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" dir="rtl">
        <div class="container">
            <a class="navbar-brand" href="#">العربية</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">مهمتنا <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">رؤيتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">اتصل بنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">طلب التقسيط</a>
                    </li>


                </ul>
            </div>
        </div>
    </nav>


    <nav class="navbar navbar-expand-lg navbar-light bg-light header content" dir="rtl">
        <div class="container " style="display: flex;
        flex-flow: row;">

            <a class="navbar-brand" href="{{route('store')}}">C<span>N</span>T</a>




            <div class="form-inline my-2">

            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="py-3 text-center">checkout </h2>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <div class="checkout-price">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                    </h4>
                    <ul class="list-group mb-3">
                        @foreach($products as $product)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{$product->name}}</h6>
                                <small class="text-muted">Qty: <span>{{$product->bought_qty}}</span></small>

                            </div>
                            @if(isset($product->final_price))
                            <span class="text-muted">{{$product->final_price}}</span>
                            @else
                            <span class="text-muted">{{$product->price}}</span>
                            @endif
                        </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Sub Total</span>
                            <strong>{{$total}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-dark">
                            <div class="text-info">
                                <h6 class="my-0 text-white">Shipping</h6>
                                @if($isCustomShipping)
                                <div>
                                    <small class="text-muted"> + City: <span id="city-shipping"></span></small>
                                </div>
                                @endif
                                <div>
                                    <small class="text-muted"> + Item Shipping: <span>{{$shipping_fees}}</span></small>
                                </div>
                            </div>
                            <span class="text-info">+<span id="total-shipping"> {{$shipping_fees}}</span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total</span>
                            <strong id="total-amount">{{$shipping_fees + $total}}</strong>
                        </li>
                    </ul>
                    <!-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> -->
                </div>
            </div>
            <div class="col-md-8 order-md-1">
                <div class="checkout-forms">
                    <h4 class="mb-3">Billing address</h4>
                    <form onsubmit="clearCart()" method="POST" class="needs-validation" action="{{route('store.placeOrder')}}" novalidate="" autocomplete="off">
                        @csrf
                        @foreach($products as $product)
                        <input name="products[{{$product->id}}][id]" value="{{$product->id}}" class="d-none" type="text" readonly>
                        <input name="products[{{$product->id}}][quantity]" value="{{$product->bought_qty}}" class="d-none" type="text" readonly>
                        @endforeach
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input name="first_name" type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input name="last_name" type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                                <div class="invalid-feedback"> Valid last name is required. </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12 col-sm-6 col-md-12">
                                <label>Phone number</label>
                                <input name="phone" id="phone" type="tel" class="form-control" pattern="^(01)([0-9]{9})$" required="">
                            </div>
                        </div>


                        <div class="mb-3">
                            <!-- <span class="text-muted">(Optional)</span> -->
                            <label for="email">Email </label>
                            <input name="email" type="email" class="form-control" id="email" required="" placeholder="you@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
                            <div class="invalid-feedback"> Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input name="address" type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                            <div class="invalid-feedback"> Please enter your shipping address. </div>
                        </div>
                        <div class="mb-3">
                            <label for="city">City</label>
                            <small class="text-muted"> Fees Apply on Custom Shipped Items Only </small>
                            <select onchange="setCityShipping(this.value)" name="city" class="form-control" id="city" required="">
                                <option value=""></option>
                                @foreach($cityShippings as $ship)
                                <option value="{{ $ship->id }}"> {{$ship->name. " ------- (Fees:".$ship->shipping_fees.")"}}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback"> Please provide a valid city. </div>
                        </div>
                        <div class="mb-3">
                            <label for="message">Shipping Message</label>
                            <input name="message" type="text" class="form-control" id="message" placeholder="Message">
                        </div>

                        <div class="summary-delivery">
                            <label for="message">Payment</label>

                            <select name="payment" name="delivery-collection" class="summary-delivery-selection" required>
                                <option value="" selected="selected">Select Payment Method</option>
                                <!-- <option value="collection">VISA</option> -->
                                <option value="cash">CASH ON DELIVERY</option>
                            </select>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block mb-4" style="background: #f36c1e; border: 1px solid #f36c1e;" type="submit">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <footer dir="rtl" class="text-right sub-footer">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <ul class="footer-contact">
                        <h2>C.N.T</h2>
                        <li>
                            <i class="fas fa-map-marked-alt"></i>
                            <span>
                                San Luis Potosí, Centro Historico, 78000 San Luis Potosí, SPL, Mexico
                            </span>
                        </li>
                        <li>
                            <i class="fas fa-headphones-alt"></i>
                            <span>(+0214)0 315 215 - </span>
                            <span>(+0214)0 315 215 </span>
                        </li>
                        <li>
                            <i class="fas fa-envelope-open-text"></i>
                            <a href="tel:Contact@Wpthemego.Com">Contact@Wpthemego.Com</a>
                        </li>
                        <li>
                            <i class="far fa-clock"></i>
                            <span>Open Time: 8:00AM - 6:00PM</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 pl-0 pr-0 text-align-left">
                    <ul>
                        <h6>CUSTOMER CARE</h6>
                        <li>
                            <a href="">Contact Us</a>
                        </li>
                        <li><a href="">About Us</a></li>
                        <li><a href="">F.A.Q</a></li>
                        <li><a href="">Help Center</a></li>
                        <li><a href="">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-md-3 pl-0 pr-0">
                    <ul>
                        <h6>CATEGORIES</h6>
                        <li><a href="">Product Support</a></li>
                        <li><a href="">PC Setup & Support </a></li>
                        <li><a href="">Services</a></li>
                        <li><a href="">Extended Service Plans</a></li>
                        <li><a href="">Community</a></li>
                    </ul>
                </div>
                <div class="col-md-3 pl-0 pr-0 ">
                    <ul>
                        <h6>CATEGORIES</h6>
                        <li><a href="">Shipping Guid</a></li>
                        <li><a href="">Store Location</a></li>
                        <li><a href="">Afiliates</a></li>
                        <li><a href="">Cutsomer Point Policy</a></li>
                        <li><a href="">Cutsomer Point Policy</a></li>
                    </ul>
                </div>

                <div class="col-md-12">
                    <div class="menu-footer1">

                    </div>
                </div>
                <div class="col-md-12 text-center pb-3">
                    <img src="https://demo.wpthemego.com/themes/sw_emarket/wp-content/uploads/2020/02/payment.png" alt="" class="img-fluid" style="width:451px; height:26px">
                </div>


            </div>
        </div>


    </footer>
    <div class="copyright-text">
        <p>جميع الحقوق النشر محفوظة</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/intlTelInput.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/filter.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/all-product.js')}}"></script>
    <script src="{{asset('js/singleProduct.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/smoothproducts.min.js')}}"></script>
    <script src="{{asset('js/checkout.js')}}"></script>
    <script type="text/javascript">
        /* wait for images to load */
        $('#cart').click(function(e) {
            e.stopPropagation();
            $(".shopping-cart").toggleClass("active");
        });
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
        });
        $(document).ready(function() {});

        function clearCart() {}

        function setCityShipping(id) {
            let isCustomShipping = "{{$isCustomShipping}}";
            if (isCustomShipping) {
                let cityShippings = @json($cityShippings);
                let obj = cityShippings.find(o => o.id == id);
                let value = obj.shipping_fees;
                $('#city-shipping').html(value);
                let total = "{{ $total }}";
                let shippingFees = "{{ $shipping_fees }}";
                let totalShipping = Number(shippingFees) + Number(value);
                let totalAmount = Number(total) + totalShipping;
                $('#total-shipping').html(totalShipping);
                $('#total-amount').html(totalAmount);
            }
        }
    </script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>

</html>