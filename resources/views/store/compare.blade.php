<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>labtop</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link rel="stylesheet" href="{{asset('css/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/all-product.css')}}">
    <link rel="stylesheet" href="{{asset('css/filter.css')}}">
    <link rel="stylesheet" href="{{asset('css/smoothproducts.css')}}">
    <link rel="stylesheet" href="{{asset('css/singleProduct.css')}}">
    <link rel="stylesheet" href="{{asset('css/compare.css')}}">

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
                </ul>
            </div>
        </div>
    </section>


    <section style="padding-bottom: 50px; padding-top: 50px;">
        <div class="container">
            <div class="row" dir="rtl">
                <div class="col-md-12">
                    <div style="padding:0;">
                        <div class="content__wrapper">
                            <h2 class="text-color text-head-table">المقارنات</h2>
                            <table class="table table-striped other-des-table text-right" style="border: 1px solid #ddd">
                                <tbody id="specs-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    <script src="{{asset('js/filter.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-2.1.3.min.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/all-product.js')}}"></script>
    <script src="{{asset('js/singleProduct.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/smoothproducts.min.js')}}"></script>

    <script type="text/javascript">
        /* wait for images to load */
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
        });
        $('#cart').click(function(e) {
            e.stopPropagation();
            $(".shopping-cart").toggleClass("active");
        });
        $(document).ready(function() {
            renderCart();
            renderSpecsTable();
        });

        function renderCart() {
            let cart = localStorage.getItem('cart');
            cart = cart ? JSON.parse(cart) : {};
            $('#cart-count').html(Object.keys(cart).length)
            let itemTotal = 0;
            let cartHtml = '';
            for (let i in cart) {
                product = cart[i];
                itemTotal += (cart[i].price) ? Number(cart[i].price) : 0;
                let imageUrl = '{{ route("store.product.image", ":id") }}';
                imageUrl = imageUrl.replace(':id', product.imageId);
                cartHtml += `
                            <li class="clearfix">
                                <img src="${imageUrl}" alt="" />
                                <span class="item-name">${product.name}</span>
                                <span class="item-price">${isNaN(product.price)?product.price:product.price}</span>
                                <span class="item-quantity">Quantity: ${product.quantity}</span>
                            </li>`;
            }
            $('#cart-items-total').html(itemTotal);
            $('#cart-items').html(cartHtml);
        }

        function renderSpecsTable() {
            let compare = localStorage.getItem('compare');
            compare = compare ? JSON.parse(compare) : {};
            let url = "{{ route('store.compareProducts') }}";
            let tableHtml = '';
            console.log();
            if (compare.products.length > 0) {
                axios.post(url, {
                    products: compare.products
                }).then(function(response) {
                    let products = response.data;
                    if (products && products.length > 0) {
                        let specs = JSON.parse(products[0].type_specs);
                        tableHtml = `
                        <tr>
                            <td >الفئة</td>
                            <td class="text-center" colspan="${(products).length}">${products[0].type_name}</td>
                        </tr>
                        `;
                        tableHtml += `
                        <tr>
                        <td >المنتج</td>
                        `;
                        for (let i in products) {
                            let product = products[i];
                            tableHtml += `
                                <td>${product.name} <button onclick="removeFromCompare(${product.id})" class="btn"><i class="fa fa-times"></i></button></td>
                                `;
                        }
                        tableHtml += `
                            </tr>
                            `;
                        for (let si in specs) {
                            let spec = specs[si];
                            tableHtml += `
                            <tr>
                                <td >${spec.title}</td>
                            `;
                            for (let i in products) {
                                let product = products[i];
                                let pSpecs = JSON.parse(product.specifications);
                                tableHtml += `
                                <td>${pSpecs[si]}</td>
                                `;
                            }
                            tableHtml += `
                            </tr>
                            `;
                        }
                    }
                    $('#specs-data').html(tableHtml);

                }).catch(function(error) {

                });
            } else {

                $('#specs-data').html('');
            }


        }

        function removeFromCompare(id) {
            console.log(id);
            let compare = localStorage.getItem('compare');
            compare = compare ? JSON.parse(compare) : {};
            console.log(compare);
            compare.products = compare.products.filter(item => item != id);
            localStorage.setItem('compare', JSON.stringify(compare));
            renderSpecsTable();
        }
    </script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

</body>

</html>