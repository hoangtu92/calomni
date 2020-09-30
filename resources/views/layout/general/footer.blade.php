<footer class="footer">

    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-3 col-md-3">
                <a class="footer-logo" href="#">
                    <img alt="calomni" height="40" src="{{ asset("images/logo.png") }}" width="154">
                </a>
            </div>

            <div class="col-xs-6 col-sm-2">
                <h5 class="footer-col-heading">Legal</h5>
                <div class="spacer5"></div>

                <a class="footer-link" href="#">Privacy Policy</a><br>

                <a class="footer-link" href="#">Terms of Use</a><br>

                <a class="footer-link" href="#">Menu.</a><br>

            </div>

            <div class="col-xs-6 col-sm-2">
                <h5 class="footer-col-heading">Resources</h5>
                <div class="spacer5"></div>

                <a class="footer-link" href="#">Menu 1</a><br>

                <a class="footer-link" href="#">Menu 2</a><br>

                <a class="footer-link" href="#">Menu 3</a><br>

                <a class="footer-link" href="#">Menu 4</a><br>

                <a class="footer-link" href="#">Menu 5</a><br>

                <a class="footer-link" href="#">Menu 6</a><br>

                <a class="footer-link" href="#">Menu 7</a><br>

            </div>


            <div class="col-xs-6 col-sm-2">
                <h5 class="footer-col-heading">Connect</h5>
                <div class="spacer5"></div>

                <a class="footer-link" href="#">
                    <img alt="{{ env("APP_NAME") }} on Twitter" class="social-link" src="{{ asset("images/twitter.svg") }}">
                    Twitter</a><br>

                <a class="footer-link" href="#">
                    <img alt="{{ env("APP_NAME") }} on GitHub" class="social-link" src="{{ asset("images/github.svg") }}">
                    GitHub</a><br>

                <a class="footer-link" href="#">
                    <img alt="{{ env("APP_NAME") }} on Reddit" class="social-link" src="{{ asset("images/reddit.svg") }}">
                    Reddit</a><br>

                <a class="footer-link" href="#">
                    <img alt="{{ env("APP_NAME") }} on Facebook" class="social-link" src="{{ asset("images/facebook.svg") }}">
                    Facebook</a><br>

                <a class="footer-link" href="#">
                    <img alt="{{ env("APP_NAME") }} on Medium" class="social-link" src="{{ asset("images/medium.svg") }}">
                    Medium</a><br>

            </div>

            <div class="col-xs-6 col-sm-3 footer-signup">
                <h5 class="footer-col-heading stay-in-touch">Stay in Touch</h5>
                <div id="mc_embed_signup">
                    <form class="validate" id="mc-embedded-subscribe-form" method="post"
                          name="mc-embedded-subscribe-form" novalidate="" target="_blank">
                        <div id="mc_embed_signup_scroll">
                            <label class="hidden" for="mce-EMAIL-newsletter">Email address</label>
                            <input class="footer__email-input footer-em-input" id="mce-EMAIL-newsletter" name="EMAIL"
                                   placeholder="Email Address" required="" type="email" value="">
                            <input class="footer__btn-submit btn-signup footer-sub" id="mc-embedded-subscribe-footer"
                                   name="subscribe" type="submit" value="Subscribe">
                            <div class="clear" id="mce-responses">
                                <div class="response" id="mce-error-response-newsletter" style="display:none;">The email
                                    address you provided is not valid!
                                </div>
                                <div class="response" id="mce-success-response-newsletter" style="display:none;">Thank
                                    you for subscribing!
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="d-flex row justify-content-center text-center">
            <div class="col-xs-12">
                <address class="text-white">
        <span
            style="font-family: Roboto,serif;font-style: normal;font-weight: 300;font-size: 13px;line-height: 28px;color: rgba(255, 255, 255, 0.4);">
          © 2020 {{ env("APP_NAME") }} Inc
        </span>
                </address>
            </div>
        </div>

    </div>
</footer>
<div class="container-fluid consent-banner" id="consent-banner">
    <p class="consent-banner_text">This site uses cookies. By continuing to use this site, you are agreeing to our <a
            class="consent-banner_link" href="#">use of cookies and privacy policy</a>.</p>
    <p class="consent-banner_text consent-banner_close" onclick="closeBanner()">x</p>
</div>
