<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>labtop</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link rel="stylesheet" href="{{asset('css/style2.css')}}">

    <link rel="stylesheet" href="{{asset('css/all-product.css')}}">
    <link rel="stylesheet" href="{{asset('css/filter.css')}}">
    <link rel="stylesheet" href="{{asset('css/smoothproducts.css')}}">
    <link rel="stylesheet" href="{{asset('css/singleProduct.css')}}">

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
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">بحث</button>
                    </form>
                </div>
            </div>

            <div class="align-middle form-inline my-2">
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
                    <!-- <a href="#" id="cart" style="color: #fff;">
                        <i class="fa fa-shopping-cart " style="color:#fff"></i>
                         Cart <span class="badge">16</span>
                        
                        </a> -->


                    <div class="shopping-cart">
                        <div class="shopping-cart-header">
                            <i class="fa fa-shopping-cart cart-icon"></i>
                            <div class="shopping-cart-total">
                                <span class="lighter-text">Total:</span>
                                <span id="cart-items-total" class="main-color-text total">$461.15</span>
                            </div>
                        </div>
                        <!--end shopping-cart-header -->

                        <ul id="cart-items" class="shopping-cart-items">

                        </ul>

                        <a href="{{route('store.cart')}}" class="button"> عرض الكل</a>
                    </div>
                    <!--end shopping-cart -->
                </div>
            </div>
        </div>
    </nav>


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
                    <li><a href="#">اجهزه اللاب توب</a>
                        <ul>
                            <li><a href="#">School</a>
                                <ul>
                                    <li><a href="#">Lidership</a></li>
                                    <li><a href="#">History</a></li>
                                    <li><a href="#">Locations</a></li>
                                    <li><a href="#">Careers</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Study</a>
                                <ul>
                                    <li><a href="#">Undergraduate</a></li>
                                    <li><a href="#">Masters</a></li>
                                    <li><a href="#">International</a></li>
                                    <li><a href="#">Online</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Research</a>
                                <ul>
                                    <li><a href="#">Undergraduate research</a></li>
                                    <li><a href="#">Masters research</a></li>
                                    <li><a href="#">Funding</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Something</a>
                                <ul>
                                    <li><a href="#">Sub something</a></li>
                                    <li><a href="#">Sub something</a></li>
                                    <li><a href="#">Sub something</a></li>
                                    <li><a href="#">Sub something</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>


    <section dir="rtl" class="my-5">
        <div class="container">
            <div class="page">
                <div class="row text-right">
                    <div class="col-md-12 ">
                        <h3 style="color: #353745 ;">{{$product->name}}</h3>
                        <hr>
                    </div>

                    <div class="col-md-4 ">
                        <div class="sp-loading"><img src="{{asset('images/sp-loading.gif')}}" alt=""><br>LOADING IMAGES</div>
                        <div class="sp-wrap">

                            @foreach($images as $image)
                            <a href="{{route('store.product.image', [$image->id])}}">
                                <img id="img-{{$image->id}}" src="{{route('store.product.image', [$image->id])}}" alt="">
                            </a>
                            @endforeach
                            <!-- <a href="images/edit6.png"><img src="images/edit6.png" alt=""></a> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="inner-box-desc">
                            <div class="product-label form-group">
                                @if(($product->enable_discount))
                                <div>
                                    <span class="off bg-success" style="position: relative !important;">{{$product->discount}}% OFF</span>
                                </div>
                                @endif
                                <div class="product_page_price price" style="padding: 16px;" itemprop="offerDetails" itemscope="" itemtype="">
                                    @if(isset($product->final_price))
                                    @if(($product->enable_discount))
                                    <del style="font-size:30px; font-weight: 700;">{{ number_format($product->price,2)}}</del>
                                    @endif
                                    <div>
                                        <span style="font-size:40px; font-weight: 700; color: #f36c1e;" class="price-new">
                                            {{ number_format($product->final_price,2)}} EGP
                                        </span>
                                    </div>
                                    @else
                                    <span style="font-size:40px; font-weight: 700; color: #f36c1e;" class="price-new">
                                        {{number_format($product->price, 2)}} EGP
                                    </span>
                                    @endif

                                </div>

                                <div class="product-box-desc">
                                    <div class="inner-box-desc">
                                        <div class="d-flex  justify-content-between" style="border-bottom: 1px solid #ddd;">
                                            <div class="brands pr-4 pl-4">
                                                <h3 class="modtitle" style="font-size: 20px;"><span> الماركة :</span>
                                                    <a href="brand?id=9" style="color:#f36c1e ;"> @if($product->brandObj){{$product->brandObj->name}} @else N/A @endif</a>
                                                    <!-- <a href="brand?id=9">
                                                    <img src="img/brand/2.png" class="img-fluid" width="200px"
                                                        height="100px" alt="brand">
                                                </a> -->
                                                </h3>
                                            </div>

                                        </div>

                                        <div class="p-3" style="font-size: 20px; font-weight: 500;" class="modtitle">
                                            {!!$product->description!!}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="cart-button mt-3 px-2">
                                                <div class="row">
                                                    <div class="col-md-4" dir="ltr">
                                                        <span class="input-number-decrement">–</span><input class="input-number" type="text" value="1" min="1" max="10"><span class="input-number-increment">+</span>
                                                    </div>
                                                    <div class="col-md-8 btn-cart">
                                                        <a onclick="addToCart('{{$product->id}}')" class="btn btn-primary text-uppercase" style="width: 100%;">
                                                            <i class="fab fa-opencart"></i>
                                                            اضافة الى السلة
                                                        </a>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row pt-4 icons-carts">

                                                            <div class="col-md-6">
                                                                <a onclick="addToCompare('{{($product->id)}}', '{{($product->type)}}')" class="btn btn-primary" style="width:100%">

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
        </div>


    </section>




    <section style="padding-bottom: 50px; padding-top: 50px;">
        <div class="container">
            <div class="row" dir="rtl">
                <div class="col-md-12">
                    <div style="padding:0;">
                        <ul class="tabs">
                            <li class="active">المواصفات</li>
                            <li>استفسار عن المنتج</li>
                        </ul>

                        <ul class="tab__content">
                            <li class="active">
                                <div class="content__wrapper">
                                    <h2 class="text-color text-head-table">المواصفات الفنية</h2>
                                    <table class="table table-striped text-right" style="border: 1px solid #ddd">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            @foreach($typeSepcs as $key=>$spec)
                                            <tr>
                                                <!-- <th scope="row"></th> -->
                                                <!-- <td>Mark</td> -->
                                                <td>{{$spec->title}}</td>
                                                <td>
                                                    @if(isset($product->specifications[$key]))
                                                    {{ $product->specifications[$key] }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                </div>
                            </li>
                            <li>
                                <div class="content__wrapper text-right ">
                                    <h2 class="text-color text-head-table">تواصل معنا</h2>

                                    <form>
                                        <div class="form-group ">
                                            <label for="exampleInputEmail1">الاسم</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ادخل اسمك">

                                        </div>
                                        <div class="form-group text-right">
                                            <label for="exampleInputEmail1">البريد الالكترونى</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="البريد الالكترونى">

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">الاستفسار</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="ادخلك استفسارك"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-forms">ارسال</button>
                                    </form>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="related-prduct pt-4 pb-5">
        <div class="container">

            <div class="box-title text-right">
                <h3><span>المنتجات المشابهه</span></h3>
            </div>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-3">
                    <div class="product py-4">
                        @if(($relatedProduct->enable_discount))
                        <span class="off bg-success">{{$relatedProduct->discount}}% OFF</span>
                        @endif
                        <div class="text-center">
                            <a href="{{route('store.aproduct', $relatedProduct->id)}}">
                                <img src="data:image/png;base64,{{ chunk_split(base64_encode($relatedProduct->image)) }}" width="200" height="200">
                            </a>
                        </div>
                        <div class="about text-center">

                            <a href="{{route('store.aproduct', $relatedProduct->id)}}">
                                <h5>{{$relatedProduct->name}}</h5>
                            </a>
                            @if(isset($relatedProduct->final_price))
                            <del>{{ number_format($relatedProduct->price,2)}}</del>
                            <div>
                                <span>{{ number_format($relatedProduct->final_price,2)}}</span>
                            </div>
                            @else
                            <span>{{ number_format($relatedProduct->price,2)}}</span>
                            @endif
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button onclick="addToCart('{{($relatedProduct->id)}}')" class="btn btn-primary text-uppercase">Add to cart</button>
                            <div class="add">
                                <span onclick="addToCompare('{{($relatedProduct->id)}}', '{{($relatedProduct->type)}}')" title="Compare" class="product_fav"><i class="fas fa-exchange-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>





    <div class="container p-0">
        <div class="box-title text-right">
            <h3><span>العروض اليومية</span></h3>
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

    <!--container end.//-->
    <!-- end product filter -->


    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
    <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script> -->
    <!-- <script src="js/script.js"></script> -->
    <!-- <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/filter.js')}}"></script>
    <!-- <script src="js/magiczoomplus.js"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/all-product.js')}}"></script>
    <script src="{{asset('js/singleProduct.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/smoothproducts.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/cart.js')}}"></script>

    <script type="text/javascript">
        /* wait for images to load */
        $('#cart').click(function(e) {
            e.stopPropagation();
            $(".shopping-cart").toggleClass("active");
        });
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
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

        function addToCompare(product, type) {
            let compare = localStorage.getItem('compare');
            compare = compare ? JSON.parse(compare) : {
                type: '',
                products: []
            };
            if (compare.type && compare.products.length > 0) {
                if (type != compare.type) {
                    toastr.error("Compare List Must Have The Same Type");
                } else if (compare.products.length === 3) {
                    toastr.error("Compare List Must Have The Same Type");
                } else {
                    if (compare.products.indexOf(product) < 0) {
                        compare.products.push(product);
                        toastr.success('Added to Compare Successfuly');
                    }
                }
            } else {
                compare.type = type;
                if (compare.products.length === 3) {
                    toastr.error("Compare List Must Have The Same Type");
                } else {
                    if (compare.products.indexOf(product) < 0) {
                        compare.products.push(product)
                        toastr.success('Added to Compare Successfuly');
                    }
                }
            }
            localStorage.setItem('compare', JSON.stringify(compare));
        }
    </script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>

</html>