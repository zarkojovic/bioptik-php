
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
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>

    </div>
    <!--//banner -->
</div>
<!--// header_top -->
<!-- top Products -->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Contact</h3>
        <div class="inner_sec">
            <p class="sub text-center mb-lg-5 mb-3">We love to discuss your idea</p>
            <div class="address row">
                <?php foreach ($contactArray as $contact): ?>
                    <div class="col-lg-4 address-grid">
                        <div class="row address-info">
                            <div class="col-md-3 address-left text-center">
                                <i class="<?= $contact["icon"] ?>"></i>
                            </div>
                            <div class="col-md-9 address-right text-left">
                                <h6>
                                    <?= $contact["title"] ?>
                                </h6>
                                <p>
                                    <?= $contact["text"] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="contact_grid_right">
                <form action="#" method="post" name="contactForm">
                    <div class="row contact_left_grid">
                        <div class="col-md-6 con-left">
                            <div class="form-group">
                                <label class="my-2">Name</label>
                                <input class="form-control" type="text" name="name">
                                <span class="text-danger" id="errorName"></span>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email">
                                <span class="text-danger" id="errorEmail"></span>
                            </div>
                            <div class="form-group">
                                <label class="my-2">Subject</label>
                                <input class="form-control" type="text" name="subject">
                                <span class="text-danger" id="errorSubject"></span>
                            </div>
                        </div>
                        <div class="col-md-6 con-right">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea id="textarea" name="message"></textarea>
                                <span class="text-danger" id="errorMessage"></span>
                            </div>
                            <input class="form-control submitButton" type="button" id="submitContact"
                                   name="submitContact" value="Submit">

                        </div>
                    </div>
                    <div id="messageReturn"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $("#submitContact").click(function () {
            let forma = document.forms["contactForm"];
            let brGresaka = 0;

            let regFullName = /^[A-ZĆČŠĐŽ][a-zćčšđž]{2,13}\s[A-ZĆČŠĐŽ][a-zćčšđž]{2,13}$/;
            let regSubject = /^(([A-ZĆČŠĐŽa-zćčšđž]{1,13}\s)*){4,70}$/;
            let regEmail =
                /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/;
            let regPhone = /^06[0-9]{6,9}\s*$/;
            let regAdresa =
                /^[A-ZČĆŠĐŽ][a-zčćšđž]{1,15}(\s[1-9](?:[AZČĆŠĐŽ]|[a-zčćšđž]))?(\s[A-ZČĆŠĐŽ][a-zčćšđž]{1,15})?(?:\s[0-9]{0,3}|\s[1-9](?:[A-ZČĆŠĐŽ]|[a-zčćšđž]))?\s*$/;

            let name = forma.name.value;
            let email = forma.email.value;
            let subject = forma.subject.value;
            console.log(subject);
            let text = forma.message.value;

            if (!regFullName.test(name)) {
                brGresaka++;
                $("#errorName").html("Invalid name format. Example: Zarko Jovic");
            } else {
                $("#errorName").html("");
            }
            if (!regEmail.test(email)) {
                brGresaka++;
                $("#errorEmail").html("Invalid email format. Example: test@gmail.com");
            } else {
                $("#errorEmail").html("");
            }
            if (subject == "") {
                brGresaka++;
                $("#errorSubject").html("Subject can't be empty!");
            } else {
                $("#errorSubject").html("");
            }
            if (text == "") {
                brGresaka++;
                $("#errorMessage").html("Message can't be empty!");
            } else {
                $("#errorMessage").html("");
            }


            if (brGresaka == 0) {
                let message = {};
                message.name = name;
                message.email = email;
                message.subject = subject;
                message.message = text;
                message.submit = forma.submitContact.value;

                console.log(message)
                $.ajax({
                    type: "post",
                    url: "models/send_mail.php",
                    // dataType: "json",
                    data: message,
                    success: function (data) {
                        // if (data == "1") {
                        let html = `<div class="alert alert-success" role="alert">
												Message sent!
											</div>`;
                        document.forms["contactForm"].reset();
                        $("#messageReturn").html(html);
                        setTimeout(function () {
                            $("#messageReturn").html("");

                        }, 5000);
                        // }
                        // else if (data == "0") {
                        // 	let html = `<div class="alert alert-danger" role="alert">
                        // 					Message not sent!
                        // 				</div>`;
                        // 	$("#messageReturn").html(html);
                        //
                        // }
                    },
                    error: function (xhr){
                        let html = `<div class="alert alert-danger" role="alert">
												Message not sent!
											</div>`;
                        $("#messageReturn").html(html);
                    }
                });
            }
        });
    });
</script>