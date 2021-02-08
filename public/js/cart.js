function renderCart(imageUrl) {
    let cart = localStorage.getItem('cart');
    cart = cart ? JSON.parse(cart) : {};
    $('#cart-count').html(Object.keys(cart).length)
    let itemTotal = 0;
    let cartHtml = '';
    for (let i in cart) {
        product = cart[i];
        if (cart[i].final_price) {
            itemTotal += (cart[i].final_price) ? Number(cart[i].final_price) * cart[i].quantity : 0;
        } else {
            itemTotal += (cart[i].price) ? Number(cart[i].price) * cart[i].quantity : 0;
        }
        newImageUrl = imageUrl.replace(':id', product.imageId);
        let price = (cart[i].final_price) ? cart[i].final_price : cart[i].price;
        cartHtml += `
                    <li class="clearfix">
                        <img src="${newImageUrl}" alt="" />
                        <span class="item-name">${product.name}</span>
                        <span class="item-price">${price}</span>
                        <span class="item-quantity">Quantity: ${product.quantity}</span>
                    </li>`;
    }
    $('#cart-items-total').html(itemTotal);
    $('#cart-items').html(cartHtml);
}

function refreshCart(url) {
    let cart = localStorage.getItem('cart');
    if (cart) {
        cart = JSON.parse(cart);
        productsIds = Object.keys(cart);
        if (productsIds.length == 0) {
            return;
        }
        axios.post(url, {
            products: productsIds
        }).then(function (response) {
            let products = response.data;
            for (const product of products) {
                let cartProduct = {
                    name: product.name,
                    price: (product.price) ? product.price : 'N/A',
                    imageId: product.image_id,
                    final_price: product.final_price

                };
                if (cart[product.id]) {
                    cartProduct.quantity = cart[product.id].quantity;
                }
                cart[product.id] = cartProduct;
                localStorage.setItem("cart", JSON.stringify(cart));
            }
        }).catch(function (error) {
            console.log(error);
        });
    }
}