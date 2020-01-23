$('document').ready(function () {

    const BASE_URL = 'http://w2w.localhost/';

    const resetPasswordModTrigger = $("#resetPasswordModTrigger");
    const loginlabel = $("#loginlabel");
    const formLoginRequire = $("#formLoginRequire");


    resetPasswordModTrigger.on('click', rstPwModal);

    function rstPwModal() {
        formLoginRequire.hide();
        formLoginRequire
            .after(
                "<div class=\"card bg-light\" id=\"formPwReset\">" +
                "<article class=\"card-body mx-auto\" style=\"max-width: 400px;\">" +
                "  <h4 class=\"card-title mt-3 text-center\">Reset my password</h4>" +
                "<form method=\"post\" action=\"" + BASE_URL + "authentication/generate_reset_email.php\">\n" +
                "    <div class=\"form-group\">\n" +
                "        <label for=\"email\">Your email Adress</label>\n" +
                "        <input type=\"email\" class=\"form-control\" id=\"email\" aria-describedby=\"email\"\n" +
                "               placeholder=\"email\" name=\"email\">\n" +
                "    </div>\n" +
                "\n" +
                "\n" +
                "    <button type=\"button\" class=\"btn btn-secondary\" id=\"cancelPwReset\"><- Back</button>\n" +
                "    <button type=\"submit\" class=\"btn btn-primary float-sm-right\">Reset My Password</button>\n" +
                "</form>" +
                "</article>" +
                "</div>"
            );

        $("#cancelPwReset").on('click', showLoginModal);
    }

    function showLoginModal() {
        const formPwReset = $("#formPwReset");
        formPwReset.hide();
        formLoginRequire.show();
    }


});
