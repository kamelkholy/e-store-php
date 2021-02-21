<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/all-product.css')}}">
    <link rel="stylesheet" href="{{asset('css/filter.css')}}">
    <link rel="stylesheet" href="{{asset('css/smoothproducts.css')}}">
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


            <div class=" navbar-collapse">
                <div class="m-auto centered">
                    <form action="{{route('store.products')}}">
                        <input id="search" name="search" placeholder="Search term">
                        <button style="top: -1px;" class="btn btn-outline-success my-2 my-sm-0" type="submit">بحث</button>
                    </form>
                </div>
            </div>

            <div class="form-inline my-2">
                <a style="width: 20px; margin-left: 25px;" href="{{route('store.compare')}}">
                    <i style="color: white;" class="fas fa-exchange-alt"></i>
                </a>
                <a href="#" id="cart">
                    <img src="{{asset('img/shopping-cart.png')}}" style="width: 20px; margin-left: 25px;" alt="">
                    <span id="cart-count" class="badge">0</span>
                </a>
                <a href="#" id="customer">
                    <img src="{{asset('img/support.png')}}" style="width: 25px;" alt="">
                </a>
                <div class="navbar-right">
                    <div class="shopping-cart">
                        <div class="shopping-cart-header">
                            <i class="fa fa-shopping-cart cart-icon"></i>
                            <div class="shopping-cart-total">
                                <span class="lighter-text">Total:</span>
                                <span id="cart-items-total" class="main-color-text total">$461.15</span>
                            </div>
                        </div>
                        <ul id="cart-items" class="shopping-cart-items">
                        </ul>
                        <a href="{{route('store.cart')}}" class="button"> عرض الكل</a>
                    </div>
                    <div class="customer-list" style="padding: 0;">
                        <ul class="list-group" style="padding: 0;">
                            <a href="{{route('builds.index')}}" class="list-group-item list-group-item-action">
                                My Builds
                            </a>
                            <a href="{{route('store.pcBuild')}}" class="list-group-item list-group-item-action">
                                Build A PC
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <form method="POST" action="{{route('store.checkout')}}">
        @csrf
        <section class="menu-section" dir="rtl">
            <div class="menu-container">
                <div class="menu text-right">
                    <ul>
                        <li><a href="{{route('store')}}">الرئيسية</a></li>
                        @foreach($parents as $parent)
                        <li><a href="{{route('store.products.category', $parent->id)}}">{{$parent->name}}</a>
                            @if($children->contains('parent', $parent->id))
                            <ul>
                                @foreach($children as $lv1)
                                @if($lv1->parent == $parent->id && $lv1->level == 1)
                                <li><a href="{{route('store.products.category', $lv1->id)}}">{{$lv1->name}}</a>
                                    <ul>
                                        @foreach($children as $lv2)
                                        @if($lv2->parent == $lv1->id && $lv2->level == 2)
                                        <li><a href="{{route('store.products.category', $lv2->id)}}">{{$lv2->name}} </a></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <div class="basket" style="margin-top: 50px; margin-bottom: 50px;">
            <div class="container">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <h2 style="text-align: center; font-weight: 800; font-size: 30px; margin-top: 30px;">Shopping cart</h2>
                <div class="row">
                    <div class="col-md-8">
                        <div class="basket-labels">
                            <div class="col-md-12" style="background: #e9ecef;">
                                <div class="row">
                                    <div class="col-md-6 col-6 py-3">
                                        <span class="item item-heading">المنتج</span>
                                    </div>

                                    <div class="col-md-3 col-3 py-3">
                                        <span class="quantity">الكمية</span>
                                    </div>
                                    <div class="col-md-3 col-3 py-3">
                                        <span class="price">السعر</span>
                                    </div>
                                </div>
                            </div>

                            <div id="cart-list" class="basket-product">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <aside>
                            <div class="summary">
                                <input placeholder="PROMOCODE" type="text" class="form-control" name="promo_code">
                                <div class="summary-total">
                                    <div class="total-title">Total</div>
                                    <div class="total-value final-value" id="basket-total"></div>
                                </div>
                                <div class="summary-checkout">
                                    <button class="checkout-cta">Go to Secure Checkout</button>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </form>






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

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <!-- <script src="js/script.js"></script> -->
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script> -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/all-product.js')}}"></script>
    <script src="{{asset('js/shoppingcart.js')}}"></script>
    <script src="{{asset('js/cart.js')}}"></script>

    <script>
        $('#cart').click(function(e) {
            e.stopPropagation();
            $(".shopping-cart").toggleClass("active");
        });
        $('#customer').click(function(e) {
            e.stopPropagation();
            $(".customer-list").toggleClass("active");
        });
        $(document).ready(function() {
            let url = "{{ route('store.refreshCart') }}";
            let imageUrl = '{{ route("store.product.image", ":id") }}';

            refreshCart(url);
            renderCart(imageUrl);
            renderCartList();
        });



        function renderCartList() {
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            let cartHtml = '';
            let itemTotalCount = 0;
            let itemTotal = 0;
            for (let i in cart) {
                product = cart[i];
                itemTotalCount += cart[i].quantity;
                if (cart[i].final_price) {
                    itemTotal += (cart[i].final_price) ? Number(cart[i].final_price) * cart[i].quantity : 0;
                } else {
                    itemTotal += (cart[i].price) ? Number(cart[i].price) * cart[i].quantity : 0;
                }
                let imageUrl = '{{ route("store.product.image", ":id") }}';
                imageUrl = imageUrl.replace(':id', product.imageId);
                let price = (cart[i].final_price) ? cart[i].final_price : cart[i].price;
                cartHtml += `                            
                        <div class="col-md-12 py-3" style="border-bottom: 1px solid #eee;">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="item d-flex">
                                        <div class="product-image">
                                            <img src="${imageUrl}" alt="Placholder Image 2" class="product-frame">
                                        </div>
                                        <div class="product-details">
                                            <h1>${product.name}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3">
                                    <div class="quantity">
                                        <input onchange="changeTotal(event, ${i})" name="products[${i}][quantity]" type="number" value="${product.quantity}" min="1" class="quantity-field">
                                        <input class="d-none" type="text" value="${i}" name="products[${i}][id]" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 col-3">
                                    <div class="price">${price}</div>
                                </div>
                                <div class="remove">
                                    <button onclick="removeFromCart(${i})" class="btn btn-danger"> <i class="far fa-trash-alt" style="color:#fff;"></i>
                                        حذف</button>
                                </div>
                            </div>
                        </div>`;
            }
            $('#basket-total').html(itemTotal);
            $('#cart-list').html(cartHtml);
        }

        function removeFromCart(id) {
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            delete cart[id];
            localStorage.setItem("cart", JSON.stringify(cart));
            let imageUrl = '{{ route("store.product.image", ":id") }}';

            renderCart(imageUrl);
            renderCartList();
        }

        function changeTotal(e, id) {
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            cart[id].quantity = e.target.value;
            let itemTotal = 0;
            for (let i in cart) {
                product = cart[i];
                if (cart[i].final_price) {
                    itemTotal += (cart[i].final_price) ? Number(cart[i].final_price) * cart[i].quantity : 0;
                } else {
                    itemTotal += (cart[i].price) ? Number(cart[i].price) * cart[i].quantity : 0;
                }
            }
            $('#basket-total').html(itemTotal);
        }
    </script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

</body>

</html>