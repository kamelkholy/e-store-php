<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> -->
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="//cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>

    <title>Dashboard</title>

</head>

<body class="antialiased">
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        function getProducts(id) {
            let optionsHtml = '<option value="">Select</option>\n';
            if (id) {
                let url = '{{ route("featuredCategories.getProducts", ":id") }}';
                url = url.replace(':id', id);
                axios.get(url)
                    .then(function(response) {
                        if (response.data && response.data.length > 0) {

                            let options = response.data.map(function(product) {
                                return `<option value="${product.id}">${product.name}</option>`
                            });
                            optionsHtml += options.join('\n');
                            $('#featured_products').html(optionsHtml);
                        }
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                    })
            } else {
                $('#featured_products').html(optionsHtml);
            }
        }

        function filterProductsInputs() {
            let input, filter, ul, li, a, i, txtValue;
            input = $("#filterProducts")[0];
            filter = input.value.toUpperCase();
            li = $("#all-products").find('label');
            for (i = 0; i < li.length; i++) {
                txtValue = li[i].textContent || li[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    $(`#product-${li[i].id}`).show();
                } else {
                    $(`#product-${li[i].id}`).hide();
                }
            }
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

        });
    </script>
    <nav id="topbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <button type="button" id="sidebarCollapse" class="btn-sm btn-info mx-2">
            <i class="fas fa-align-left"></i>
        </button>

        <div class=" navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('store')}}">Store</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>Store Name</h4>
            </div>

            <ul class="list-unstyled components">
                <p>Management</p>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : ''  }}">
                    <a href="{{url('/admin')}}">Dashboard</a>
                </li>
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Store Modules</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li class="{{ request()->routeIs('categories.index') ? 'active' : ''  }}">
                            <a href=" {{url('/categories')}}">Categories</a>
                        </li>
                        <li class="{{ request()->routeIs('types.index') ? 'active' : ''  }}">
                            <a href="{{url('/types')}}">Types</a>
                        </li>
                        <li class="{{ request()->routeIs('brands.index') ? 'active' : ''  }}">
                            <a href=" {{url('/brands')}}">Brands</a>
                        </li>
                        <li class="{{ request()->routeIs('tags.index') ? 'active' : ''  }}">
                            <a href=" {{url('/tags')}}">Tags</a>
                        </li>
                        <li class="{{ request()->routeIs('products.index') ? 'active' : ''  }}">
                            <a href=" {{url('/products')}}">Products</a>
                        </li>
                        <li class="{{ request()->routeIs('orders.index') ? 'active' : ''  }}">
                            <a href=" {{url('/orders')}}">Orders</a>
                        </li>
                    </ul>
                </li>

                <li class="mb-5">
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li class="{{ request()->routeIs('storeSettings.index') ? 'active' : ''  }}">
                            <a href="{{route('storeSettings.index')}}">Store Settings</a>
                        </li>
                        <li class="{{ request()->routeIs('sliders.index') ? 'active' : ''  }}">
                            <a href="{{route('sliders.index')}}">Sliders</a>
                        </li>
                        <li class="{{ request()->routeIs('featuredImages.index') ? 'active' : ''  }}">
                            <a href="{{route('featuredImages.index')}}">Featured Images</a>
                        </li>
                        <li class="{{ request()->routeIs('featuredCategories.index') ? 'active' : ''  }}">
                            <a href="{{route('featuredCategories.index')}}">Featured Categories</a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'active' : ''  }}">
                            <a href="{{route('users.index')}}">Users</a>
                        </li>
                        <li class="{{ request()->routeIs('customers.index') ? 'active' : ''  }}">
                            <a href="{{route('customers.index')}}">Customers</a>
                        </li>
                        <li class="{{ request()->routeIs('cityShippings.index') ? 'active' : ''  }}">
                            <a href="{{route('cityShippings.index')}}">City Shipping</a>
                        </li>

                        <li class="{{ request()->routeIs('promoCodes.index') ? 'active' : ''  }}">
                            <a href="{{route('promoCodes.index')}}">Promo Codes</a>
                        </li>
                        <li class="{{ request()->routeIs('dailyOffers.index') ? 'active' : ''  }}">
                            <a href="{{route('dailyOffers.index')}}">Daily Offers</a>
                        </li>
                        <li class="{{ request()->routeIs('pcBuildSettings.index') ? 'active' : ''  }}">
                            <a href="{{route('pcBuildSettings.index')}}">PC Build Settings</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>

        <!-- Page Content -->
        <div id="content" class="container">

            @yield('main')

        </div>
    </div>
</body>

</html>