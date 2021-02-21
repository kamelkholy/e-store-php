<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset=" UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/smoothproducts.css')}}">
    <link rel="stylesheet" href="{{asset('css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/media-query.css')}}">

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
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
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">بحث</button>
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
                    <!--end shopping-cart -->
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




    <section class="banner-slider pt-3" dir="rtl">
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="col-sm-12 col-md-12 col-lg-3 background-mobile">
                    <div class="menu-container" dir="rtl">
                        <div class="menu">
                            <ul class="">
                                <!-- <li><a href="#">الرئيسية</a></li> -->
                                @foreach($parents as $parent)
                                <li><a href="{{route('store.products.category', $parent->id)}}">{{$parent->name}}</a>
                                    @if($children->contains('parent', $parent->id))
                                    <ul class="four-column sub-category">
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
                                        @if( isset ($parent->image))
                                        <li><a href="#">عرض حصرى</a>
                                            <ul>
                                                <li>
                                                    <img src="{{route('categories.show', [$parent->id])}}" alt="{{ $parent->name }}" class="img-fluid" style="height:220px;">

                                                </li>
                                            </ul>
                                        </li>
                                        @endif
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-9">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($sliders as $key => $slider)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="@if($key==0) active @endif"></li>
                            @endforeach


                        </ol>
                        <div class="carousel-inner">
                            @foreach($sliders as $key => $slider)
                            <div class="carousel-item @if($key==0) active @endif">
                                <img class="d-block w-100" src="data:image/png;base64,{{ chunk_split(base64_encode($slider->image)) }}" alt="{{$slider->title}}" title="{{$slider->title}}">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="adds pt-3 pb-3">
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="col-md-3 p-2">
                    <img src="img/adds/adds1.jpg" alt="" height="300px" class="img-fluid">
                </div>
                <div class="col-md-3 p-2">
                    <img src="img/adds/adds2.jpg" alt="" height="300px" class="img-fluid">
                </div>
                <div class="col-md-3 p-2">
                    <img src="img/adds/adds3.jpg" alt="" height="300px" class="img-fluid">
                </div>
                <div class="col-md-3 p-2">
                    <img src="img/adds/adds4.jpg" alt="" height="300px" class="img-fluid pl-0">
                </div>

            </div>
        </div>
    </section>



    <section class="deal-offer text-right mt-5" dir="rtl">
        <div class="container p-4" style="border: 1px solid #ddd;">
            <div class="box-title">
                <h3><span>العروض اليومية</span></h3>
            </div>

            <div class="row">
                <div class="col-md-6 mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="img/sepical count offer/sepical open count 1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="item-content">
                                <h4>
                                    <a href="" title="ut labore et do">ut labore et do</a>
                                </h4>
                                Price
                                <div class="item-price">
                                    <span class="item-price2 d-flex align-items-center">
                                        <h3>
                                            90.00
                                        </h3>
                                        <del>120.00</del>
                                    </span>
                                </div>
                                <div class="description">Style Code Live is a daily, live show where style enthusiasts
                                    can connect, chat, shop, and get the inside scoop on the latest fashion and beauty
                                    trends.
                                </div>
                                <div class="offer-counter-m d-flex justify-content-between align-items-center">
                                    <div class="count-left pull-left">
                                        <h2>Hurry up!</h2>
                                        <p>Offers end in:</p>
                                    </div>
                                    <div class="product-countdown pull-right">
                                        <span class="countdown-row countdown-show4 d-flex">
                                            <span class="countdown-section days ">

                                                <span class="countdown-amount d-block">458</span>

                                                <span class="countdown-period">days</span>
                                            </span>

                                            <span class="countdown-section  hours">
                                                <span class="countdown-amount d-block">08</span>
                                                <span class="countdown-period">hours</span>
                                            </span>


                                            <span class="countdown-section mins "><span class="countdown-amount d-block">10</span><span class="countdown-period">mins</span></span><span class="countdown-section secs"><span class="countdown-amount  d-block">58</span><span class="countdown-period">secs</span></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="img/sepical count offer/sepical open count 2.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="item-content">
                                <h4><a href="" title="ut labore et do">ut labore et do</a></h4>
                                Price
                                <div class="item-price">
                                    <span class="item-price2 d-flex align-items-center">
                                        <h3>
                                            90.00
                                        </h3>
                                        <del>120.00</del>
                                    </span>
                                </div>
                                <div class="description">Style Code Live is a daily, live show where style enthusiasts
                                    can connect, chat, shop, and get the inside scoop on the latest fashion and beauty
                                    trends.
                                </div>
                                <div class="offer-counter-m d-flex justify-content-between align-items-center">
                                    <div class="count-left pull-left">
                                        <h2>Hurry up!</h2>
                                        <p>Offers end in:</p>
                                    </div>
                                    <div class="product-countdown pull-right">
                                        <span class="countdown-row countdown-show4 d-flex">
                                            <span class="countdown-section days ">

                                                <span class="countdown-amount d-block">458</span>

                                                <span class="countdown-period">days</span>
                                            </span>

                                            <span class="countdown-section  hours">
                                                <span class="countdown-amount d-block">08</span>
                                                <span class="countdown-period">hours</span>
                                            </span>


                                            <span class="countdown-section mins "><span class="countdown-amount d-block">10</span><span class="countdown-period">mins</span></span><span class="countdown-section secs"><span class="countdown-amount  d-block">58</span><span class="countdown-period">secs</span></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="banner mt-4" dir="rtl">
        <div class="container p-0">
            <img src="img/adds/cus2.png" class="img-fluid" alt="">
        </div>
    </section>


    @foreach($featuredCategories as $featured)
    <section class="Accessories text-right my-4">
        <div class="container p-0">
            <div class="box-title">
                <h3><span>{{$featured->category_name}}</span></h3>
            </div>

            <div class="row no-gutters" style="border: 1px solid #ddd;">
                <div class="col-md-2 img-resize">
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($featured->featured_img)) }}" class="img-fluid " alt="">
                </div>
                <div class="col-md-8 img-resize">
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($featured->banner)) }}" class="img-fluid" alt="">
                </div>

                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <a href="{{route('store.aproduct', $featured->featured_product_id)}}">

                            <img class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($featured->featured_product_image)) }}" alt="">
                            <div class="price-product d-flex justify-content-center align-items-center">
                                @if(isset($featured->final_price))
                                <h5 style="color:#f36c1e; font-weight: 500;">{{ number_format($featured->final_price,2)}} EGP</h5>
                                <del>{{ number_format($featured->featured_product_price,2)}} EGP</del>
                                @else
                                <h5 style="color:#f36c1e; font-weight: 500;">{{ number_format($featured->featured_product_price,2)}} EGP</h5>
                                @endif
                            </div>
                            <h5>{{$featured->featured_product_name}}</h5>
                        </a>
                        <div class="overlay">
                            <i onclick="addToCart('{{($featured->featured_product_id)}}')" class="fas fa-cart-plus"></i>
                        </div>
                        @if(($featured->featured_product_enable_discount))
                        <span class="discount">-{{$featured->featured_product_discount}}%</span>
                        @endif
                    </div>
                </div>

                <div class="owl-carousel owl-theme p-3">
                    @foreach($featured->products as $f_product)
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <a href="{{route('store.aproduct', $f_product->id)}}">

                                    <img class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($f_product->image)) }}" alt="">
                                    <div class="price-product d-flex justify-content-center align-items-center">
                                        @if(isset($f_product->final_price))
                                        <h5 style="color:#f36c1e; font-weight: 500;">{{ number_format($f_product->final_price,2)}} EGP</h5>
                                        <del>{{ number_format($f_product->price,2)}} EGP</del>
                                        @else
                                        <h5 style="color:#f36c1e; font-weight: 500;">{{ number_format($featured->price,2)}} EGP</h5>
                                        @endif
                                    </div>
                                    <h5>{{$f_product->name}}</h5>
                                </a>

                                <div class="overlay">
                                    <i onclick="addToCart('{{($f_product->id)}}')" class="fas fa-cart-plus"></i>
                                </div>
                                @if(($f_product->enable_discount))
                                <span class="discount">-{{$f_product->discount}}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endforeach


    <div class="container p-0 text-right" style="border:1px solid #ddd">
        <div class="box-title" dir="rtl">
            <h3><span>الماركات</span></h3>
        </div>
        <div class="owl-carousel owl-theme p-3">
            @foreach($brands as $row)
            <div class="item">
                <img src="{{route('brands.show', [$row->id])}}" alt="{{ $row->name }}" class="img-fluid">
            </div>
            @endforeach


        </div>


    </div>
    <!--- ignore the code below-->


    <!-- <section class="sub-footer text-right">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="newsletter-footer-top d-flex align-items-center">
                        <i class="far fa-paper-plane"></i>
                        <div>
                            <h3>Signup for Newsletter</h3>
                            <p>We’ll never share your email address with a third-party</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="social-media">
                        <a href="#" ><i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"><i class="fab fa-whatsapp"></i>
                            </a>
                        <a href="#"><i class="fas fa-envelope"></i>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->



    <footer dir="rtl" class="text-right sub-footer">
        <div class="container p-0">
            <div class="row justify-content-between">
                <div class="col-md-6 col-lg-3 p-0">
                    <ul class="footer-contact p-0">
                        <h2>C.N.T</h2>
                        <li>
                            <i class="fas fa-map-marked-alt"></i>
                            <span>
                                Cairo, Egypt
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
                <div class="col-md-6 col-lg-3 pl-0 pr-0 text-align-left">
                    <ul class="p-0">
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
                <div class="col-md-6 col-lg-3 pl-0 pr-0">
                    <ul class="p-0">
                        <h6>CATEGORIES</h6>
                        <li><a href="">Product Support</a></li>
                        <li><a href="">PC Setup & Support </a></li>
                        <li><a href="">Services</a></li>
                        <li><a href="">Extended Service Plans</a></li>
                        <li><a href="">Community</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3 pl-0 pr-0 ">
                    <ul class="p-0">
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

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
    <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/singleProduct.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/smoothproducts.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/cart.js')}}"></script>

    <script type="text/javascript">
        /* wait for images to load */
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
            numbers = {
                1: "one",
                2: "two",
                3: "three",
                4: "four"
            }
            for (let i = 0; i < $('.sub-category').length; i++) {
                const element = $('.sub-category')[i];
                element.className = 'sub-category ' + numbers[element.childElementCount] + '-column';
            }
        });
        $(document).ready(function() {
            let url = "{{ route('store.refreshCart') }}";
            let imageUrl = '{{ route("store.product.image", ":id") }}';

            refreshCart(url);
            renderCart(imageUrl);
        });

        function addToCart(product) {
            // Store
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            let url = '{{ route("store.cart.product", ":id") }}';
            url = url.replace(':id', product);
            axios.get(url)
                .then(function(response) {
                    let cartProduct = {
                        name: response.data.name,
                        price: (response.data.price) ? response.data.price : 'N/A',
                        imageId: response.data.image_id,
                        final_price: response.data.final_price
                    };
                    if (cart[product]) {
                        cartProduct.quantity = cart[product].quantity + 1;
                    } else {
                        cartProduct.quantity = 1;
                    }
                    cart[product] = cartProduct;
                    localStorage.setItem("cart", JSON.stringify(cart));
                    toastr.success('Added to Cart Successfuly');
                    let imageUrl = '{{ route("store.product.image", ":id") }}';

                    renderCart(imageUrl);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    switch (error.response.status) {
                        case 404:
                            toastr.error("Not Found");
                            break;
                        default:
                            toastr.error("Error Ocurred");
                            break;
                    }

                })
        }
    </Script>
    <script src="{{asset('js/script.js')}}"></script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

</body>

</html>