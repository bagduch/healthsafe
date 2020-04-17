<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <title>Shopping Cart</title>
</head>

<body>
    <div id="app">
        <div class="container">


            <div class="row" v-if="cart">
                <table class="table table-dark">
                    <thead>
                        <td>Name</td>
                        <td>qty</td>
                        <td>price</td>
                        <td>Subtotal</td>
                        <td></td>
                    </thead>
                    <tbody>
                        <tr v-for="item in cart.items">
                            <td>{{ item.name}}</td>
                            <td><input type="number" v-model="item.qty" :key="item.id"> <button @click="updateCart(item.rowid,item.qty)">Update</button></td>
                            <td>${{ item.price.toFixed(2)}}</td>
                            <td>${{ item.subtotal.toFixed(2)}}</td>
                            <td><button class="bt btn-danger" @click="removeItem(item.rowid)">Remove</button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total: ${{cart.total.toFixed(2)}}</td>
                            <td><button class="btn btn-warning" @click="emptyCart">Empty Cart</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row" v-if="products">
                <div class="col-md-3" v-for="product in products">
                    <figure class="card card-product">
                        <figcaption class="info-wrap">
                            <h6 class="title text-dots"><a href="#">{{ product.name }}</a></h6>
                            <div class="action-wrap">
                                <button @click="addToCart(product.id)" class="btn btn-primary btn-sm float-right"> Order </button>
                                <div class="price-wrap h5">
                                    <span class="price-new">${{ product.price.toFixed(2) }}</span>
                                </div> <!-- price-wrap.// -->
                            </div> <!-- action-wrap -->
                        </figcaption>
                    </figure> <!-- card // -->
                </div> <!-- col // -->
            </div>




        </div>
    </div>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                products: null,
                cart: null
            },
            mounted() {
                fetch('/product').then(response => response.json()).then((data) => {
                    this.products = data.products;
                })

                fetch('/cart').then(response => response.json()).then((data) => {
                    this.cart = data;
                })

            },
            methods: {
                addToCart(id) {
                    const formData = new FormData();
                    formData.append('id', id);

                    fetch('/cart/add', {
                            method: 'POST',
                            body: formData
                        }).then((response) => response.json())
                        .then((result) => {
                            this.cart = result;
                        });
                },

                updateCart(rowid, qty) {
                    const formData = new FormData();
                    formData.append('rowid', rowid);
                    formData.append('qty', qty);
                    fetch('/cart/update', {
                            method: 'POST',
                            body: formData
                        }).then((response) => response.json())
                        .then((result) => {
                            this.cart = result;
                        });
                },

                removeItem(rowid) {
                    const formData = new FormData();
                    formData.append('rowid', rowid);
                    fetch('/cart/delete', {
                            method: 'POST',
                            body: formData
                        }).then((response) => response.json())
                        .then((result) => {
                            this.cart = result;
                        });
                },

                emptyCart() {
                    const formData = new FormData();
                    fetch('/cart/clear', {
                            method: 'POST',
                            body: formData
                        }).then((response) => response.json())
                        .then((result) => {
                            this.cart = result;
                        });
                }
            }
        })
    </script>
</body>

</html>