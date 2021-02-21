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
            <div class="row">
                <div class="col-md-12">
                    <div style="padding:0;">
                        <div class="content__wrapper">
                            <h2 class="text-color text-head-table">Build Your PC</h2>
                            <form method="POST" action="{{route('builds.store')}}">
                                @csrf
                                <table class="table table-bordered table-striped" style="border: 1px solid #ddd">
                                    <tbody id="specs-data">
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Processor</td>
                                            <td id="add-processor">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['processor']] as $component)
                                                                <option onclick="selectComponent('processor', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Motherboard</td>
                                            <td id="add-motherboard">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['motherboard']] as $component)
                                                                <option onclick="selectComponent('motherboard', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Ram</td>
                                            <td id="add-ram">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['ram']] as $component)
                                                                <option onclick="selectComponent('ram', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Primary Storage</td>
                                            <td id="add-primary_storage">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['primary_storage']] as $component)
                                                                <option onclick="selectComponent('primary_storage', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Secondary Storage</td>
                                            <td id="add-secondary_storage">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['secondary_storage']] as $component)
                                                                <option onclick="selectComponent('secondary_storage', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Graphics Card</td>
                                            <td id="add-gpu">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['gpu']] as $component)
                                                                <option onclick="selectComponent('gpu', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">PC Case</td>
                                            <td id="add-tower">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['tower']] as $component)
                                                                <option onclick="selectComponent('tower', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Case Cooler</td>
                                            <td id="add-tower_cooler">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['tower_cooler']] as $component)
                                                                <option onclick="selectComponent('tower_cooler', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Optical Drive</td>
                                            <td id="add-optical_drive">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['optical_drive']] as $component)
                                                                <option onclick="selectComponent('optical_drive', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">CPU Cooler</td>
                                            <td id="add-cpu_cooler">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['cpu_cooler']] as $component)
                                                                <option onclick="selectComponent('cpu_cooler', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Power Supply</td>
                                            <td id="add-power_supply">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['power_supply']] as $component)
                                                                <option onclick="selectComponent('power_supply', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Monitor</td>
                                            <td id="add-monitor">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['monitor']] as $component)
                                                                <option onclick="selectComponent('monitor', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Keyboard</td>
                                            <td id="add-keyboard">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['keyboard']] as $component)
                                                                <option onclick="selectComponent('keyboard', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Mouse</td>
                                            <td id="add-mouse">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['mouse']] as $component)
                                                                <option onclick="selectComponent('mouse', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Headphone</td>
                                            <td id="add-headphone">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" id="">
                                                                <option id="none" value="0">None</option>
                                                                @foreach($components[$pcBuildSettings['headphone']] as $component)
                                                                <option onclick="selectComponent('headphone', '{{$component}}')" value="{{$component->id}}">{{$component->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Total Cost</td>
                                            <td id="cost" class="text-center" style="font-size: large;"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" style="width: 15%;">Save</td>
                                            <td class="text-left" style="font-size: large;">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" placeholder="Name" name="build_name" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="build_access" id="" required>
                                                                <!-- <option value="public">Public</option> -->
                                                                <option value="private">Private</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button class="btn" style="background: #f8770c;">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

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
    <script src="{{asset('js/cart.js')}}"></script>

    <script type="text/javascript">
        /* wait for images to load */
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
        });
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
        });

        function selectComponent(type, product) {
            product = JSON.parse(product);
            let typeId = "#add-" + type;
            let exitstingLength = 2;
            let buildNumber = $(typeId).parent().children().length - exitstingLength + 1;
            let componentId = `build-${buildNumber}-${type}`;
            let productUrl = '{{ route("store.aproduct", ":id") }}';
            let imageUrl = '{{ route("store.product.image", ":id") }}';

            productUrl = productUrl.replace(':id', product.id);
            imageUrl = imageUrl.replace(':id', product.image_id);
            componentHtml = `
            <td id="${componentId}" class="build-${buildNumber}" style="width:80%">
                <div class="card text-left" >
                    <div class="card-body">
                    <input class="d-none" type="text" name="components[${type}]" value="${product.id}" readonly>
                    <h5 class="card-title"><a href="${productUrl}">${product.name}</a></h5>
                    <h6  class="price card-subtitle mb-2 text-muted">${(product.price)?product.price:'N/A'}</h6>
                    <img style="width:100px !important;" src="${imageUrl}"  height="50">
                    <p class="card-text">
                        <span>Brand: ${(product.brand_name)?product.brand_name:'N/A'}</span>
                    </p>
                        <a onclick="removeComponent('${componentId}', '${typeId}')" class="btn btn-danger card-link">remove</a>
                    </div>
                </div>
            </td>
            `;
            $(componentHtml).insertBefore(typeId);
            if ($(typeId).parent().children().length == 3) {
                $(typeId).hide();
            }
            calculateCost();
        }

        function removeComponent(id, typeId) {
            $(`#${id}`).remove();
            if ($(typeId).parent().children().length < 3) {
                $(typeId).show();
            }
            calculateCost();
        }

        function calculateCost() {
            totalCost = 0;
            let prices = $('.price').each(function(index) {
                let price = isNaN($(this).text()) ? 0 : Number($(this).text());
                totalCost += price;
                $('#cost').html(totalCost);
            });
            $('#cost').html(totalCost);
        }
    </script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js "></script>

</body>

</html>