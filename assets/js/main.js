$(document).ready(function () {

    filterTriggers();


    $(document).on("click", "#submitSurvey", function () {
        submitFormSurvey();
    });

    $(document).on("click",".addToCartBtn",function (e){
        addToCart(e,$(this));
    });

    $(document).on("click",".addCartItem",function (e){
        addToCart(e,$(this));
        loadCart();
    });
    $(document).on("click",".subtractCartItem",function (e){
        addToCart(e,$(this));
        loadCart();
    });
    $(document).on("click",".removeCartItem",function (e){
        addToCart(e,$(this));
        loadCart();
    });
    displayCartItems();
});


function callBack(url,type,data,success){
    $.ajax({
        url:url,
        method: type,
        data: data,
        success: success
    })
}

function displayCartItems(){
    $.ajax({
        url:"models/getCart.php",
        method: "POST",
        success: function (data){
            let html = `<i class="fas fa-cart-arrow-down"></i> (${data})`;
            if(data == 0){
                $("#cartHeader").addClass("text-white");
                $("#cartHeader").removeClass("bg-warning");
            }else{
                $("#cartHeader").addClass("bg-warning");
            }
            $("#cartHeader").html(html);
        }
    })
}
function addToCart(e,elem){

    e.preventDefault();
    let id = elem.data("id");
    let action = elem.data("action");

    let cartObj = {
        id: id,
        action: action
    }

    $.ajax({
        url:"models/addToCart.php",
        method: "POST",
        data: cartObj,
        success: function (data){
            // console.log(data);
            if(data == "1"){
                $('#myAlert').removeClass("bg-danger text-white").show().html("Added new item!").delay(3000).fadeOut();
            }else if(data == "2"){
                $('#myAlert').removeClass("bg-danger text-white").show().html("Added to one more!").delay(3000).fadeOut();
            }else if(data == "0"){
                $('#myAlert').addClass("bg-danger text-white").show().html("Removed item from cart!").delay(3000).fadeOut();
            }else if(data == "-1"){
                $('#myAlert').addClass("bg-danger text-white").html("Removed for one!").delay(3000).fadeOut();
            }
            displayCartItems();
        },
        error: function (err){
            window.location.href = "index.php?page=login";
        }
    })
}
function cartEvent() {
    googles.render();
    googles.cart.on('googles_checkout', function (evt) {
        var items, len, i;
        if (this.subtotal() > 0) {
            items = this.items();
            for (i = 0, len = items.length; i < len; i++) {
            }
        }
    });
}

function filterTriggers() {

    $(document).on("change", ".filterCheck", function () {
        filterArticles();
    })

    $(document).on("change", "#sortArticles", function () {
        filterArticles();
    })
    $(document).on("change", "#maxPrice", function () {
        filterArticles();
    })
    $(document).on("change", "#minPrice", function () {
        filterArticles();
    })
    $(document).on("change", "#minPrice", function () {
        filterArticles();
    })

    $(document).on("click", "#searchFind", function () {
        filterArticles();
    })
    $(document).on("click", ".page-link", function (e) {
        let page = $(this).data("page");
        filterArticles(page);
        e.preventDefault();

    })



}

function filterArticles(page = 1) {

    let brandArray = [];
    $(".brandChb:checked").each(function () {
        brandArray.push($(this).val());
    });
    let tagArray = [];
    $(".tagChb:checked").each(function () {
        tagArray.push($(this).val());
    });
    let searchText = $("#searchName").val();

    let sortArticles = $("#sortArticles").val();
    let minPrice = $("#minPrice").val();
    let maxPrice = $("#maxPrice").val();

    let dataObj = {
        brand: brandArray,
        tag: tagArray,
        name: searchText,
        sortArticles: sortArticles,
        min: minPrice,
        max: maxPrice
    }

    $.ajax({
        url: "models/filterArticles.php",
        method: "POST",
        data: dataObj,
        success: function (data) {
            let items = JSON.parse(data);
            let html = '';
            let perPage = 8;
            let itemsCount = items.length;
            if (page <= itemsCount) {
                items = items.slice((page - 1) * perPage, (page - 1) * perPage + perPage);
            }
            let pageNumber = Math.ceil(itemsCount / perPage);
            if (items.length > 0) {
                items.forEach(x => {
                    html += `<div class="col-md-3 mb-3 product-men women_two">
                                    <div class="product-googles-info googles">
                                        <div class="men-pro-item">
                                            <div class="men-thumb-item">
                                                <img src="assets/img/${x.photo}" class="img-fluid" alt="">
                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="index.php?page=single&id=${x.article_id}"
                                                           class="link-product-add-cart">Quick
                                                            View</a>
                                                    </div>
                                                </div>
                                                ${x.tag_name != null ? "<span class='product-new-top " + x.class + "'> " + x.tag_name + "</span>" : ""}
                                                ${x.discount != null ? "<span class='product-discount-top'> " + x.discount + "%</span>" : ""}
                                            </div>
                                            <div class="item-info-product">
                                                <div class="info-product-price">
                                                    <div class="grid_meta">
                                                        <div class="">
                                                            <h4>
                                                                <a href="single.html" class="primary-text fw-bold">
                                                                    ${x.name}
                                                                </a>
                                                            </h4>
                                                            <h5>
                                                                <a href="single.html" class="text-dark">
                                                                    ${x.brand_name}
                                                                </a>
                                                            </h5>
                                                            <div class="grid-price mt-2">
                                                                <span class="money h3">$${x.current_price}</span>
                                                                ${x.old_price != null ? "<span class='h6'><s>" + x.old_price + "</s></span>" : ""}
                                                            </div>

                                                        </div>
                                                        <ul class="stars">`;
                    for (let i = 0; i < x.rating; i++) {
                        html += `<li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>`;
                    }
                    ;
                    html += `
                                                        </ul>
                                                    </div>
                                                    <button type="submit" class="googles-cart addToCartBtn" data-action="add" data-id="${x.article_id}">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          `
                });

                let paginationHtml = `<ul class="pagination justify-content-center">`;

                for (let i = 0; i < pageNumber; i++) {
                    paginationHtml += `<li class="page-item ${i + 1 == page ? "active" : ""}"><a class="page-link" href="#" data-page="${i + 1}">${i + 1}</a></li>`;
                }

                paginationHtml += `</ul>`;

                $("#paginationWrap").html(paginationHtml);
            } else {
                html += "<h1 class='text-center'>No articles available!</h1>";
            }
            $("#productsWrap").html(html);
            filterTriggers();
            cartEvent();
        }
    });

}

function submitFormSurvey() {
    console.log("pozz");
    let form = document.forms["surveyForm"];

    console.log(form);

    let type = parseInt(form.type.value);
    let question = form.qid.value;


    if (type == 0) {
        var answer = [];
        $('.checkboxAnswer:checked').each(function () {
            answer.push($(this).val());
        })
    } else {
        var answer = form.answer.value;
    }
    // return;
    console.log(answer)

    if (answer != "" || answer.length > 0) {
        let answerObj = {
            answer: answer,
            question: question
        };
        console.log(answerObj);
        $.ajax({
            url: "models/sendSurveyAnswer.php",
            type: "POST",
            data: answerObj,
            success: function (data) {
                console.log(data);
                renderSurvey();
            }
        })
    }
}

function renderSurvey() {

    $.ajax({
        url: "models/getAvailableSurvey.php",
        type: "POST",
        success: function (data) {

            let html = "";

            if (data == "401") {
                html += `<h3><a href="index.php?page=login"> Sign in</a> to complete surveys!</h3>`;
            } else {
                let res = JSON.parse(data);

                if (res[0]) {

                    html += `<div class="deal-leftmk left-side">
                                <h3 class="agileits-sear-head">Complete a Survey</h3>
                                <h4 class="mb-3">
                                    ${res[0].question}
                                </h4>
                            </div>
                            <form action="#" name="surveyForm" method="post">
                                <input type="hidden" id="type" name="type" value="${res[0].type}">`;
                    if (res[0].type) {
                        res[1].forEach(el => {
                            html += `<input type="radio" name="answer" required
                                                       id="answer${el.answer_id}"
                                                       value="${el.answer_id}"> ${el.answer}
                                                <br/>`
                        });
                    } else {
                        res[1].forEach(el => {
                            html += `<input type="checkbox" name="answer[]" required
                                                        class="checkboxAnswer"
                                                       id="answer${el.answer_id}"
                                                       value="${el.answer_id}"> ${el.answer}
                                                <br/>`
                        });
                    }
                    html += `<input type="hidden" name="qid" id="qid"
                                               value="${res[0].question_id}">
                                        <input type="button" value="Submit" class="mt-3 submit-button" required name="submitSurvey"
                                               id="submitSurvey"
                                               placeholder="Search"/></form>`
                } else {
                    html += `<h3>No more surveys to complete!</h3>`;
                }
            }
            $("#surveyWrap").html(html);
        }
    });
}

function countdown() {
    // Set the target date 20-30 days from now
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + Math.floor(Math.random() * 11) + 20);

    const countdownTimer = setInterval(() => {
        const currentDate = new Date();
        const timeDifference = targetDate - currentDate;

        if (timeDifference < 0) {
            clearInterval(countdownTimer);
            console.log("Countdown expired!");
            return;
        }

        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

        $("#countDownDeal").html(`<h1 class="text-white text-center font-weight-bold"> ${days}d ${hours}h ${minutes}m ${seconds}s</h1>`);
    }, 1000);
}