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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/filter.css')}}">
    <link rel="stylesheet" href="{{asset('css/all-product.css')}}">

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

            <a class="navbar-brand" href="{{route('store')}}">CNT</a>


            <div class=" navbar-collapse">
                <div class="m-auto centered">
                    <form action="{{route('store.products')}}">
                        <input value="{{request()->query('search')}}" id="search" name="search" placeholder="Search term">
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
    <!-- Categories -->
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
    <!-- product filter -->
    <div class="container mt-5 mb-5" dir="rtl">
        <div class="row g-2 text-right" style="width: 100%;">
            <div class="col-md-3" style="height: 100%;">

                <div class="">
                    <nav class="">
                        <div class="filter-menu">
                            <form @if(request()->routeIs('store.products')) action="{{route('store.products')}}" @else action="{{route('store.products.category', request()->id)}}" @endif>
                                @if(request()->query('search') !==null)
                                <input class="d-none" name="search" type="text" value="{{request()->query('search')}}">
                                @endif
                                <div class="panel panel-default">

                                    <div class="panel-body">
                                        <div class="panel-group" id="filter-menu" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <a class="panel-title  d-flex justify-content-between collapsed" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <span>
                                                            الماركات
                                                        </span>
                                                        <div>
                                                            <i class="fas fa-sort-down"></i>
                                                        </div>
                                                    </a>

                                                    <!-- /.panel-title -->
                                                </div><!-- /.panel-heading -->
                                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        @foreach($existingBrands as $ebrand)
                                                        <div class="checkbox"><label>
                                                                <input type="checkbox" name="brands_filter[]" value="{{$ebrand->id}}" @if(isset(request()->query()['brands_filter']) && in_array($ebrand->id, request()->query()['brands_filter'])) checked @endif>
                                                                <span style="color:gray">({{$ebrand->count}})</span> {{$ebrand->brand_name}}
                                                            </label></div>

                                                        @endforeach
                                                    </div><!-- /.panel-body -->
                                                </div><!-- /.panel-collapse -->
                                            </div><!-- /.panel -->
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <a class="panel-title d-flex justify-content-between collapsed" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        <span> الأصناف</span>

                                                        <div>
                                                            <i class="fas fa-sort-down"></i>
                                                        </div>
                                                    </a><!-- /.panel-title -->
                                                </div><!-- /.panel-heading -->
                                                <div id="collapseTwo" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        @foreach($existingCategories as $ecategory)
                                                        <div class="checkbox"><label>
                                                                <input type="checkbox" name="categories_filter[]" value="{{$ecategory->id}}" @if(isset(request()->query()['categories_filter']) && in_array($ecategory->id, request()->query()['categories_filter'])) checked @endif>
                                                                <span style="color:gray">({{$ecategory->count}})</span> {{$ecategory->category_name}}
                                                            </label></div>
                                                        @endforeach
                                                    </div><!-- /.panel-body -->
                                                </div><!-- /.panel-collapse -->
                                            </div><!-- /.panel -->

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingThree">
                                                    <a class="panel-title d-flex justify-content-between collapsed" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        <span>
                                                            السعر
                                                        </span>
                                                        <div>
                                                            <i class="fas fa-sort-down"></i>
                                                        </div>
                                                    </a><!-- /.panel-title -->
                                                </div><!-- /.panel-heading -->
                                                <div id="collapseThree" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="panel-body my-5">
                                                        <div class="m-auto text-center">
                                                            <div for="from">من:</div>
                                                            <input name="from" id="from" type="number" value="{{isset(request()->query()['from'])?request()->query()['from']:''}}" placeholder="From" min="0" max="120000" />
                                                            <div for="to">الي:</div>
                                                            <input name="to" id="to" type="number" value="{{isset(request()->query()['to'])?request()->query()['to']:''}}" placeholder="To" min="0" max="120000" />
                                                        </div>
                                                    </div><!-- /.panel-body -->
                                                </div><!-- /.panel-collapse -->
                                                <div class="panel-footer">
                                                    <button class="btn btn-primary text-uppercase">Filter</button>
                                                </div>

                                            </div><!-- /.panel -->
                                        </div><!-- /.panel-group -->
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->

                            </form>
                        </div>
                    </nav>
                    <!-- refinements -->
                </div>
                <!--wrapper-->
                <!--SVG definitions-->
                <svg width="0" height="0" class="screen-reader">
                    <defs>
                        <polygon id="right-arrow" points="418.999,256.001 121.001,462 121.001,50 " />
                        <polygon id="close" points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 " />
                        <polygon id="arrow-pointy" points="302.313,95.548 185.758,95.548 301.908,212.254 50,212.254 50,299.746 301.908,299.746 185.758,416.452 302.313,416.452 462,256 " />
                        <polygon id="tick" points="37.316,80.48 0,43.164 17.798,25.366 37.316,44.885 82.202,0 100,17.798 37.316,80.48 " />
                    </defs>
                </svg>
            </div>
            <div class="col-md-9">
                <div class="row g-2">
                    @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="product py-4">
                            <div class="text-center"> <a href="{{route('store.aproduct', $product->id)}}">
                                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($product->image)) }}" width="200" height="200">

                                </a>
                            </div>
                            <div class="about text-center">
                                <a href="{{route('store.aproduct', $product->id)}}">
                                    <h5>{{$product->name}}</h5>
                                </a>
                                <span>{{ number_format($product->price,2)}}</span>
                            </div>
                            <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                                <button onclick="addToCart('{{($product->id)}}')" class="btn btn-primary text-uppercase">Add to cart</button>
                                <div class="add">
                                    <span onclick="addToCompare('{{($product->id)}}', '{{($product->type)}}')" title="Compare" class="product_fav"><i class="fas fa-exchange-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/filter.js')}}"></script>
    <script src="{{asset('js/all-product.js')}}"></script>
    <script>
        $('#cart').click(function(e) {
            e.stopPropagation();
            $(".shopping-cart").toggleClass("active");
        });
        $(document).ready(function() {
            renderCart();
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
                    };
                    if (cart[product]) {
                        cartProduct.quantity = cart[product].quantity + 1;
                    } else {
                        cartProduct.quantity = 1;
                    }
                    cart[product] = cartProduct;
                    localStorage.setItem("cart", JSON.stringify(cart));
                    toastr.success('Added to Cart Successfuly');
                    renderCart();
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
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

</body>

</html>