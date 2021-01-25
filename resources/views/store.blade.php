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
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

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
                <a href="#">
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
                                <li><a href="#">اجهزه اللاب توب</a>
                                    <ul class="four-column">
                                        <li><a href="#">لابات</a>
                                            <ul>
                                                <li><a href="#">Dell </a></li>
                                                <li><a href="#">Hp</a></li>
                                                <li><a href="#">Lenovo</a></li>
                                                <li><a href="#">ASUS</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">وحدات تخزين</a>
                                            <ul>
                                                <li><a href="#">SSD</a></li>
                                                <li><a href="#">HDD</a></li>
                                                <li><a href="#">Ram</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">اكسوارات</a>
                                            <ul>
                                                <li><a href="#">شنطه</a></li>
                                                <li><a href="#">ماوس</a></li>
                                                <li><a href="#">لوحة مفاتيح</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">عرض حصرى</a>
                                            <ul>
                                                <li><img src="img/s2.jpg" class="img-fluid" style="height:220px;"></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">اجهزة الكمبيوتر</a>
                                    <ul class="three-column">
                                        <li><a href="#">اجهزة</a>
                                            <ul class="">
                                                <li><a href="#">DEll</a></li>
                                                <li><a href="#">HP</a></li>

                                            </ul>
                                        </li>
                                        <li><a href="#">قطع واجزاء</a>
                                            <ul>
                                                <li><a href="#">رامات</a></li>
                                                <li><a href="#">هارد</a></li>
                                                <li><a href="#">كارت الشاشة</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">اكسسوار Gaming </a>
                                    <ul class="four-column-adds">
                                        <li><a href="#">قطع واجزاء</a>
                                            <ul>
                                                <li><a href="#">Ram Patriot</a></li>
                                                <li><a href="#">أجهزه تبريد</a></li>
                                                <li><a href="#">كروت شاشة</a></li>
                                                <li><a href="#">Tour Case</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">عروض</a>
                                            <ul>
                                                <li><img src="img/menu-offer/apc-new-all.png" class="img-fluid"></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">اكسسوار</a>
                                    <ul class="one-column">
                                        <li><a href="#">اكسسوار اضافية</a>
                                            <ul>
                                                <li><a href="#">فلاشة</a></li>
                                                <li><a href="#">كرت ميمرى</a></li>
                                                <li><a href="#">سماعات</a></li>
                                                <li><a href="#">شنط</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">اجهزة شبكات</a>
                                    <ul class="two-column">
                                        <li><a href="#">اجهزة</a>
                                            <ul class="">
                                                <li><a href="#">روتر</a></li>
                                                <li><a href="#">كابلات</a></li>
                                                <li><a href="#">اجزاء</a></li>

                                                <li><a href="#">سويتش</a></li>


                                            </ul>
                                        </li>
                                        <li><a href="#">عروض</a>
                                            <ul>
                                                <li><img src="img/menu-offer/s2.jpg" class="img-fluid"></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-9">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="img/first slider/micosoft_63ve-wk.png" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/first slider/apc-new-all.png" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/first slider/website3.png" alt="Third slide">
                            </div>
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

    <section class="text-right labtop" style="position: relative; margin-top: 30px">


        <div class="container p-0">
            <div class="">
                <div class="box-title">
                    <h3><span>اللابات</span></h3>
                </div>


                <div class="tabs-wrapper mb-3">

                    <input type="radio" name="tab" id="tab1" class="tab-head1" checked="checked" />
                    <label for="tab1">One</label>
                    <input type="radio" name="tab" id="tab2" class="tab-head2" />
                    <label for="tab2">Two</label>
                    <input type="radio" name="tab" id="tab3" class="tab-head3" />
                    <label for="tab3">Three</label>

                    <div class="tab-body-wrapper text-right" style="margin-top:20px ;">
                        <div id="tab-body-1" class="tab-body">
                            <div class="row no-gutters" style="border: 1px solid #ddd;">
                                <div class="col-md-2 img-resize">
                                    <img src="img/s2.jpg" class="img-fluid " alt="">
                                </div>
                                <div class="col-md-8 img-resize">
                                    <img src="img/cisco_2560x900_vpy9-6b.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/2.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/3.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/4.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/5.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/6.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab one/1.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-eye"></i></a>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>

                                <!-- Button trigger modal -->
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    Launch demo modal
                                </button> -->

                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle" style="color: #353745 ;">LENOVO THINKPAD E15 I7-10510U 8GB
                                                    DDR4 1TB HDD AMD RADEON RX 640
                                                    2GB GRAPHICS 15.6″ FHD</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row text-right">
                                                    <div class="col-md-12 ">
                                                        <!-- <h3 >LENOVO THINKPAD E15 I7-10510U 8GB
                                                            DDR4 1TB HDD AMD RADEON RX 640
                                                            2GB GRAPHICS 15.6″ FHD
                                                        </h3>
                                                        <hr> -->
                                                    </div>

                                                    <div class="col-md-6 ">
                                                        <div class="sp-loading"><img src="images/sp-loading.gif" alt=""><br>LOADING IMAGES</div>
                                                        <div class="sp-wrap">
                                                            <a href="images/edit1.png"><img src="images/edit1.png" width="90px" alt=""></a>
                                                            <a href="images/edit2.png"><img src="images/edit2.png" width="90px" alt=""></a>
                                                            <a href="images/edit3.png"><img src="images/edit3.png" width="90px" alt=""></a>
                                                            <a href="images/edit4.png"><img src="images/edit4.png" width="90px" alt=""></a>
                                                            <a href="images/edit5.png"><img src="images/edit5.png" width="90px" alt=""></a>
                                                            <!-- <a href="images/edit6.png"><img src="images/edit6.png" alt=""></a> -->
                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="inner-box-desc">
                                                            <div class="product-label form-group">
                                                                <div class="product_page_price price" style="padding: 16px;" itemprop="offerDetails" itemscope="" itemtype="">
                                                                    <span style="font-size:40px; font-weight: 700; color: #f36c1e;" class="price-new">10000 EGP
                                                                    </span>


                                                                </div>

                                                                <div class="product-box-desc">
                                                                    <div class="inner-box-desc">
                                                                        <div class="d-flex  justify-content-between" style="border-bottom: 1px solid #ddd;">
                                                                            <div class="brands pr-4 pl-4">
                                                                                <h3 class="modtitle" style="font-size: 20px;"><span>
                                                                                        الماركة :</span>
                                                                                    <a href="brand?id=9" style="color:#f36c1e ;">
                                                                                        LENOVO</a>
                                                                                    <!-- <a href="brand?id=9">
                                                                                    <img src="img/brand/2.png" class="img-fluid" width="200px"
                                                                                        height="100px" alt="brand">
                                                                                </a> -->
                                                                                </h3>
                                                                            </div>
                                                                            <div class="model">
                                                                                <h3 class="modtitle" style="font-size: 20px;">

                                                                                    <span>الكود : </span>
                                                                                    <a href="#" style="color:#f36c1e ;">s145AMDA6</a>

                                                                                </h3>
                                                                            </div>
                                                                        </div>

                                                                        <h3 class="modtitle">
                                                                            <ul class="pt-3 list-unstyled" style="font-size: 20px; font-weight: 500;">
                                                                                <li>Lenovo Ideapad S145 Laptop</li>
                                                                                <li>AMD A6-9225</li>
                                                                                <li>4GB RAM Memory</li>

                                                                            </ul>
                                                                        </h3>
                                                                        <div class="col-md-12">
                                                                            <div class="cart-button mt-3 px-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-5" dir="ltr">

                                                                                        <span class="input-number-decrement">–</span><input class="input-number" type="text" value="1" min="1" max="10"><span class="input-number-increment">+</span>
                                                                                    </div>
                                                                                    <div class="col-md-7 btn-cart">
                                                                                        <a href="#" class="btn btn-primary text-uppercase" style="width: 100%;">
                                                                                            <i class="fab fa-opencart"></i>
                                                                                            اضافة الى السلة
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="row pt-4 icons-carts">

                                                                                            <div class="col-md-6">
                                                                                                <a href="#" class="btn btn-primary">
                                                                                                    <i class="fas fa-heart"></i>
                                                                                                    قائمة
                                                                                                    الامنيات
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <a href="#" class="btn btn-primary" style="width:100%">

                                                                                                    <i class="fas fa-exchange-alt">

                                                                                                    </i>
                                                                                                    المقارنة
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <!-- <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-2">
                                    <div class="category-wrap-cat">
                                        <div class="title-imageslider  sp-cat-title-parent">
                                            <a title="Smartphone" href="#" target="_self">
                                                Smartphone
                                            </a>
                                        </div>

                                        <div id="cat_slider_1449311671605025938" class="slider">
                                            <div class="cat_slider_inner so_category_type_default">

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Knage unget" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Knage unget" target="_self">
                                                                <i class="fa fa-caret-left"></i> Knage unget
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                                <i class="fa fa-caret-left"></i> Hanet magente
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Verture agoent" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Verture agoent" target="_self">
                                                                <i class="fa fa-caret-left"></i> Verture agoent
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Bltong kielb" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Bltong kielb" target="_self">
                                                                <i class="fa fa-caret-left"></i> Bltong kielb
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Latenge mange" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Latenge mange" target="_self">
                                                                <i class="fa fa-caret-left"></i> Latenge mange
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Tange manue" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Tange manue" target="_self">
                                                                <i class="fa fa-caret-left"></i> Tange manue
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-body-2" class="tab-body">
                            <div class="row no-gutters" style="border: 1px solid #ddd;">
                                <div class="col-md-2 img-resize">
                                    <img src="img/s2.jpg" class="img-fluid " alt="">
                                </div>
                                <div class="col-md-8 img-resize">
                                    <img src="img/cisco_2560x900_vpy9-6b.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/7.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/8.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/9.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/10.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/11.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab two/12.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="category-wrap-cat">
                                        <div class="title-imageslider  sp-cat-title-parent">
                                            <a title="Smartphone" href="#" target="_self">
                                                Smartphone
                                            </a>
                                        </div>

                                        <div id="cat_slider_1449311671605025938" class="slider">
                                            <div class="cat_slider_inner so_category_type_default">

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Knage unget" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Knage unget" target="_self">
                                                                <i class="fa fa-caret-left"></i> Knage unget
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                                <i class="fa fa-caret-left"></i> Hanet magente
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Verture agoent" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Verture agoent" target="_self">
                                                                <i class="fa fa-caret-left"></i> Verture agoent
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Bltong kielb" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Bltong kielb" target="_self">
                                                                <i class="fa fa-caret-left"></i> Bltong kielb
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Latenge mange" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Latenge mange" target="_self">
                                                                <i class="fa fa-caret-left"></i> Latenge mange
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Tange manue" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Tange manue" target="_self">
                                                                <i class="fa fa-caret-left"></i> Tange manue
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-body-3" class="tab-body">
                            <div class="row no-gutters" style="border: 1px solid #ddd;">
                                <div class="col-md-2 img-resize">
                                    <img src="img/s2.jpg" class="img-fluid " alt="">
                                </div>
                                <div class="col-md-8 img-resize">
                                    <img src="img/cisco_2560x900_vpy9-6b.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/13.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/14.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/15.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/16.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/17.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2" style="border: 1px solid #ddd;">
                                    <div class="cart-product text-center p-2">
                                        <img class="img-fluid" src="img/labtop section/tab three/18.png" alt="">
                                        <div class="price-product d-flex justify-content-center align-items-center">
                                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                            <del>100,00 EGP</del>
                                        </div>
                                        <h5>Lenovo Elctronic</h5>

                                        <div class="overlay">
                                            <i class="fas fa-cart-plus"></i>
                                            <i class="far fa-eye"></i>
                                            <i class="fas fa-heart"></i>
                                        </div>

                                        <span class="discount">-20%</span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="category-wrap-cat">
                                        <div class="title-imageslider  sp-cat-title-parent">
                                            <a title="Smartphone" href="#" target="_self">
                                                Smartphone
                                            </a>
                                        </div>

                                        <div id="cat_slider_1449311671605025938" class="slider">
                                            <div class="cat_slider_inner so_category_type_default">

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Knage unget" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Knage unget" target="_self">
                                                                <i class="fa fa-caret-left"></i> Knage unget
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Hanet magente" target="_self">
                                                                <i class="fa fa-caret-left"></i> Hanet magente
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Verture agoent" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Verture agoent" target="_self">
                                                                <i class="fa fa-caret-left"></i> Verture agoent
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Bltong kielb" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Bltong kielb" target="_self">
                                                                <i class="fa fa-caret-left"></i> Bltong kielb
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title="Latenge mange" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title="Latenge mange" target="_self">
                                                                <i class="fa fa-caret-left"></i> Latenge mange
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item">
                                                    <div class="item-inner">
                                                        <div class="cat_slider_image">
                                                            <a href="#" title=" Tange manue" target="_self">

                                                            </a>
                                                        </div>

                                                        <div class="cat_slider_title">
                                                            <a href="#" title=" Tange manue" target="_self">
                                                                <i class="fa fa-caret-left"></i> Tange manue
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="Accessories text-right mb-4">
        <div class="container p-0">
            <div class="box-title">
                <h3><span>الاكسسوارات</span></h3>
            </div>

            <div class="row no-gutters" style="border: 1px solid #ddd;">
                <div class="col-md-2 img-resize">
                    <img src="img/s2.jpg" class="img-fluid " alt="">
                </div>
                <div class="col-md-8 img-resize">
                    <img src="img/cisco_2560x900_vpy9-6b.jpg" class="img-fluid" alt="">
                </div>

                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/accessories/right-side.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>

                <div class="owl-carousel owl-theme p-3">
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider1.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider2.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider3.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider4.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider5.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="" style="border: 1px solid #ddd;">
                            <div class="cart-product text-center p-2">
                                <img class="img-fluid" src="img/accessories/slider accessories/slider6.png" alt="">
                                <div class="price-product d-flex justify-content-center align-items-center">
                                    <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                                    <del>100,00 EGP</del>
                                </div>
                                <h5>Lenovo Elctronic</h5>

                                <div class="overlay">
                                    <i class="fas fa-cart-plus"></i>
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-heart"></i>
                                </div>

                                <span class="discount">-20%</span>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid"
                            src="https://www.egyptlaptop.com/images/watermarked/1/thumbnails/270/270/detailed/22/Acer-Nitro-5_AN515-44_Red-KB_gallery_01_n0vm-wn.png.png"
                            alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>



                <div class="col-md-2">
                    <div class="category-wrap-cat">
                        <div class="title-imageslider  sp-cat-title-parent">
                            <a title="Smartphone" href="#" target="_self">
                                Smartphone
                            </a>
                        </div>

                        <div id="cat_slider_1449311671605025938" class="slider">
                            <div class="cat_slider_inner so_category_type_default">

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Knage unget" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Knage unget" target="_self">
                                                <i class="fa fa-caret-left"></i> Knage unget
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Hanet magente" target="_self">
                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Hanet magente" target="_self">
                                                <i class="fa fa-caret-left"></i> Hanet magente
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title=" Verture agoent" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title=" Verture agoent" target="_self">
                                                <i class="fa fa-caret-left"></i> Verture agoent
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Bltong kielb" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Bltong kielb" target="_self">
                                                <i class="fa fa-caret-left"></i> Bltong kielb
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Latenge mange" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Latenge mange" target="_self">
                                                <i class="fa fa-caret-left"></i> Latenge mange
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="" title=" Tange manue" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="" title=" Tange manue" target="_self">
                                                <i class="fa fa-caret-left"></i> Tange manue
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <section class="screen text-right mb-4" dir="rtl">
        <div class="container p-0">
            <div class="box-title">
                <h3><span>Gaming</span></h3>
            </div>

            <div class="row no-gutters" style="border: 1px solid #ddd;">


                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/rightside.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>120,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-8 img-resize">
                    <img src="img/cisco_2560x900_vpy9-6b.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/leftside.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/2.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/3.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/4.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
                <div class="col-md-2" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/gaming/6.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>

                <div class="col-md-2 img-resize">
                    <img src="img/s2.jpg" class="img-fluid " alt="">
                </div>
                <div class="col-md-2">
                    <div class="category-wrap-cat">
                        <div class="title-imageslider  sp-cat-title-parent">
                            <a title="Smartphone" href="" target="_self">
                                Smartphone
                            </a>
                        </div>

                        <div id="cat_slider_1449311671605025938" class="slider">
                            <div class="cat_slider_inner so_category_type_default">

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Knage unget" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Knage unget" target="_self">
                                                <i class="fa fa-caret-left"></i> Knage unget
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Hanet magente" target="_self">
                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Hanet magente" target="_self">
                                                <i class="fa fa-caret-left"></i> Hanet magente
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title=" Verture agoent" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title=" Verture agoent" target="_self">
                                                <i class="fa fa-caret-left"></i> Verture agoent
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="#" title="Bltong kielb" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="#" title="Bltong kielb" target="_self">
                                                <i class="fa fa-caret-left"></i> Bltong kielb
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="" title="Latenge mange" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="" title="Latenge mange" target="_self">
                                                <i class="fa fa-caret-left"></i> Latenge mange
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="item-inner">
                                        <div class="cat_slider_image">
                                            <a href="" title=" Tange manue" target="_self">

                                            </a>
                                        </div>

                                        <div class="cat_slider_title">
                                            <a href="" title=" Tange manue" target="_self">
                                                <i class="fa fa-caret-left"></i> Tange manue
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="container p-0">
        <div id="owl-example" class="owl-carousel">
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/1.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/2.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/3.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/5.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/6.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
            <div>
                <div class="" style="border: 1px solid #ddd;">
                    <div class="cart-product text-center p-2">
                        <img class="img-fluid" src="img/collection-slider/7.png" alt="">
                        <div class="price-product d-flex justify-content-center align-items-center">
                            <h5 style="color:#f36c1e; font-weight: 500;">70,00 EGP</h5>
                            <del>100,00 EGP</del>
                        </div>
                        <h5>Lenovo Elctronic</h5>

                        <div class="overlay">
                            <i class="fas fa-cart-plus"></i>
                            <i class="far fa-eye"></i>
                            <i class="fas fa-heart"></i>
                        </div>

                        <span class="discount">-20%</span>

                    </div>
                </div>
            </div>
        </div>
    </div>

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
            renderCart();
        });

        function renderCart() {
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            $('#cart-count').html(Object.keys(cart).length)
            let itemTotal = 0;
            let cartHtml = '';
            for (let i in cart) {
                product = cart[i];
                itemTotal += (cart[i].price) ? cart[i].price : 0;
                let imageUrl = '{{ route("store.product.image", ":id") }}';
                imageUrl = imageUrl.replace(':id', product.imageId);
                cartHtml += `
                            <li class="clearfix">
                                <img src="${imageUrl}" alt="" />
                                <span class="item-name">${product.name}</span>
                                <span class="item-price">${isNaN(product.price)?product.price:product.price.toFixed(2)}</span>
                                <span class="item-quantity">Quantity: ${product.quantity}</span>
                            </li>`;
            }
            $('#cart-items-total').html(itemTotal);
            $('#cart-items').html(cartHtml);
        }
    </Script>
    <script src="{{asset('js/script.js')}}"></script>
</body>

</html>