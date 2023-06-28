<?php
    if(!isset($_SESSION["user_id"])){
        redirect("index.php");
    }
?>
<link rel="stylesheet" type="text/css" href="assets/css/checkout.css">
<link href="assets/css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/>
<link href="assets/css/style.css" rel='stylesheet' type='text/css'/>
</head>

<body>
<div class="banner-top container-fluid" id="home">
    <!-- banner -->
    <div class="banner_inner">
        <div class="services-breadcrumb">
            <div class="inner_breadcrumb">

                <ul class="short">
                    <li>
                        <a href="index.html">Home</a>
                        <i>|</i>
                    </li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>

    </div>
    <!--//banner -->
</div>
<!--// header_top -->
<!--checkout-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <div class="inner-sec-shop px-lg-4 px-3">
            <h3 class="tittle-w3layouts my-lg-4 mt-3">Checkout </h3>
            <div class="checkout-right" id="checkoutTable">
                <!-- <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Product Name</th>

                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="cartWrap">


                    </tbody>
                </table>
                <button class="btn btn-primary mt-4" id="btnPrimary">Submit</button> -->
            </div>

        </div>

    </div>
</section>
<!--//checkout-->

<script src="assets/js/minicart.js"></script>
<script>
    function loadCart() {
        $.ajax({
            url: "models/getUsersArticles.php",
            method: "POST",
            success: function (data) {
                let items = JSON.parse(data);
                console.log(items);
                let html = '';
                let sum = 0;
                if (items.length > 0) {
                    html += `<table class="timetable_sub">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Product Name</th>

                                        <th>Price</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="cartWrap">`;
                    items.forEach((el, index) => {
                        sum += el.current_price * el.quantity;
                        html += `<tr class="rem">
                                <td class="invert">${index + 1}</td>
                                <td class="invert-image w-50">
                                    <a href="index.php?page=single&id=${el.article_id}">
                                        <img src="assets/img/${el.photo}" alt="${el.alt}" class="img-responsive">
                                    </a>
                                </td>

                                <td class="invert">
                                    <div class="quantity">
                                        <div class="quantity-select">
                                            <a href="#" class="entry value subtractCartItem" data-id="${el.article_id}" data-action="subtract">
                                                -
                                            </a>
                                            <div class="entry value">
                                                <span>${el.quantity}</span>
                                            </div>
                                            <a href="#" class="entry value addCartItem" data-id="${el.article_id}" data-action="add">
                                                +
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="invert">${el.name} </td>
                                <td class="invert">$${el.current_price}</td>
                                <td class="invert">
                                    <div class="rem">
                                        <div data-id="${el.article_id}" data-action="remove" class="close1 removeCartItem"> </div>
                                    </div>

                                </td>
                            </tr>
                    `;
                    });
                    html += `</tbody>
                            </table>
                            <h4 class="text-right fw-bold text-dark">Total : $${sum}</h4>

                            <button class="btn btn-primary mt-4 submit-button" id="btnPrimary">Submit order</button> `;
                    $("#checkoutTable").html(html);


                } else {
                    $("#checkoutTable").html(`<h2 class="text-center">Your cart is empty!</h2><p class="text-center mt-4"><a href="index.php?page=shop" class="submit-button mt-4 text-white">Go Shopping</a></p>`);
                }
            }
        });
    }

    loadCart();

    $(document).on("click","#btnPrimary",function (){

       $.ajax({
           url: "models/checkoutCart.php",
           method: "POST",
           success: function (data){
                console.log(data);
                loadCart();
                displayCartItems();
           }
       })
    });


    // googles.cart.on('googles_checkout', function (evt) {
    //     var items, len, i;
    //
    //     if (this.subtotal() > 0) {
    //         items = this.items();
    //
    //         for (i = 0, len = items.length; i < len; i++) { }
    //     }
    // });
    // function loadCart() {
    //
    //     $.ajax({
    //         url:"models/getUsersArticles.php",
    //         method: "POST",
    //         success: function (data){
    //             console.log(data);
    //         }
    //     })
    //
    //     let cartItems = googles.cart.items();
    //     console.log("ispis " + cartItems);
    //     let html = ``;
    //     if (cartItems.length > 0) {
    //         html += `<table class="timetable_sub">
    // 					<thead>
    // 						<tr>
    // 							<th>SL No.</th>
    // 							<th>Product</th>
    // 							<th>Quantity</th>
    // 							<th>Product Name</th>
    //
    // 							<th>Price</th>
    // 							<th>Remove</th>
    // 						</tr>
    // 					</thead>
    // 					<tbody id="cartWrap">`;
    //         cartItems.forEach((el, index) => {
    //             html += `<tr class="rem">
    // 					<td class="invert">${index + 1}</td>
    // 					<td class="invert-image w-50">
    // 						<a href="single.php?id=${el._data.id}">
    // 							<img src="assets/images/${el._data.image}" alt="${el._data.googles_item}" class="img-responsive">
    // 						</a>
    // 					</td>
    // 					<td class="invert">
    // 						<div class="quantity">
    // 							<div class="quantity-select">
    // 								<div class="entry value">
    // 									<span>${el._data.quantity}</span>
    // 								</div>
    // 							</div>
    // 						</div>
    // 					</td>
    // 					<td class="invert">${el._data.googles_item} </td>
    //
    // 					<td class="invert">$${el._data.amount}</td>
    // 					<td class="invert">
    // 						<div class="rem">
    // 							<div onClick="remove()" data-id="${el._data.id}" class="close1"> </div>
    // 						</div>
    //
    // 					</td>
    // 				</tr>
    // 		`;
    //
    //         });
    //         let total = googles.cart.subtotal();
    //         html += `</tbody>
    // 				</table>
    // 				<h4 class="text-right fw-bold text-dark">Total : $${total}</h4>
    //
    // 				<button class="btn btn-primary mt-4 submit-button" id="btnPrimary">Submit order</button> `;
    //         $("#checkoutTable").html(html);
    //
    //
    //     } else {
    //         $("#checkoutTable").html(`<h2 class="text-center">Your cart is empty!</h2><p class="text-center mt-4"><a href="index.php?page=shop" class="submit-button mt-4 text-white">Go Shopping</a></p>`);
    //     }
    // }
    // function remove() {
    //     let id = $(this).data("id");
    //
    //     googles.cart.remove(id);
    //     window.location = "index.php?page=checkout";
    // }


    // cartWrap.innerHtml = html;
</script>
<!-- //cart-js -->


<!-- SUBMIT CART -->
<script>



    // $(document).ready(function () {
    //     $("#btnPrimary").click(function () {
    //
    //         let cartItems = googles.cart.items();
    //
    //         console.log(cartItems);
    //         let data = [];
    //
    //         cartItems.forEach(el => {
    //             let item = {};
    //             item.id = el._data.id;
    //             item.qty = el._data.quantity;
    //             data.push(item);
    //         });
    //
    //         data = JSON.stringify(data);
    //         let dataWrap = {};
    //         dataWrap.data = data;
    //         if (data.length > 0) {
    //             $.ajax({
    //                 type: "post",
    //                 url: "models/insert_cart.php",
    //                 data: dataWrap,
    //                 success: function (data) {
    //                     console.log(data);
    //                     if (data == "0") {
    //                         window.location = "index.php?page=login";
    //                     }
    //                     if (data == "1") {
    //                         googles.cart.destroy();
    //                         loadCart();
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });

</script>


<script>
    $(document).ready(function () {
        $(".button-log a").click(function () {
            $(".overlay-login").fadeToggle(200);
            $(this).toggleClass('btn-open').toggleClass('btn-close');
        });
    });
    $('.overlay-close1').on('click', function () {
        $(".overlay-login").fadeToggle(200);
        $(".button-log a").toggleClass('btn-open').toggleClass('btn-close');
        open = false;
    });
</script>
<!-- carousel -->
<!-- easy-responsive-tabs -->
<script src="assets/js/easy-responsive-tabs.js"></script>
<script>
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            activate: function (event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
</script>
<!--quantity-->
<script>
    $('.value-plus').on('click', function () {
        var divUpd = $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) + 1;
        divUpd.text(newVal);
    });

    $('.value-minus').on('click', function () {
        var divUpd = $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) - 1;
        if (newVal >= 1) divUpd.text(newVal);
    });
</script>
<!--quantity-->
<!--close-->
<script>
    $(document).ready(function (c) {
        $('.close1').on('click', function (c) {
            $('.rem1').fadeOut('slow', function (c) {
                $('.rem1').remove();
            });
        });
    });
</script>
<script>
    $(document).ready(function (c) {
        $('.close2').on('click', function (c) {
            $('.rem2').fadeOut('slow', function (c) {
                $('.rem2').remove();
            });
        });
    });
</script>
<script>
    $(document).ready(function (c) {
        $('.close3').on('click', function (c) {
            $('.rem3').fadeOut('slow', function (c) {
                $('.rem3').remove();
            });
        });
    });
</script>
<!--//close-->

<!-- dropdown nav -->
<script>
    $(document).ready(function () {
        $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                $(this).toggleClass('open');
            },
            function () {
                $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                $(this).toggleClass('open');
            }
        );
    });
</script>