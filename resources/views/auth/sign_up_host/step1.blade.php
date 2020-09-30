@extends("layout.landing")


@section("content")

    <div class="signup-node-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 signup-node-form">
                    <div>
                        <p class="sno-ad-message text-muted">For the best experience, disable ad blockers and use Chrome or Edge.</p>
                        <div class="steps">
                            <span class="active">1</span>
                            <div></div>
                            <span>2</span>
                            <div></div>
                            <span>3</span>
                        </div>
                    </div>

                    <div class="form-container requirement-form-container">
                        <div class="form requirement-form @if(old("submit")) invisible @endif">

                            <div class="row">
                                <div class="form-header col-xs-12">
                                    <h2 class="black-text">Get Paid to Share Your Disk Space</h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="sub-header col-xs-12">
                                    <p class="lead">Does your hardware meet these requirements?</p>
                                </div>
                            </div>


                            <div class="row invisible" id="signup-node-form-err-msg-container">
                                <div class="signup-node-form-error-msg col-xs-10">
                                    <span>We’re sorry, your hardware doesn’t meet the minimum requirements.</span>
                                    <a href="#" target="_blank"><span>Learn more about our node requirements.</span></a>
                                </div>
                            </div>

                            <form method="post" id="requirementForm">

                                <ul class="submit-options">
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="processor" />
                                        <span class="checkmark"></span>
                                        <p>1 Processor Core</p>
                                    </li>
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="diskSpace" />
                                        <span class="checkmark"></span>
                                        <p>Minimum 500GB of available disk space</p>
                                    </li>
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="availableBandwidth" />
                                        <span class="checkmark"></span>
                                        <p>Minimum of 2TB of available bandwidth a month</p>
                                    </li>
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="upstreamBandwidth" />
                                        <span class="checkmark"></span>
                                        <p>Minimum upstream bandwidth of 5 Mbps</p>
                                    </li>
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="downloadBandwidth" />
                                        <span class="checkmark"></span>
                                        <p>Minimum download bandwidth of 25 Mbps</p>
                                    </li>
                                    <li class="checkbox-container">
                                        <input type="checkbox" name="downtime" />
                                        <span class="checkmark"></span>
                                        <p>Maximum down time of 5 hours a month</p>
                                    </li>
                                    <div class="spacer10"></div>
                                    <div class="sign-up-node-submit">
                                        <input type="submit" value="Continue" class="btn btn-primary"/>
                                    </div>
                                </ul>
                            </form>

                        </div>

                        <div class="form email-form @if(!old("submit")) invisible @endif">
                            <form action="{{route("sign_up_host_verification")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12">

                                        <h3>Sign Up as Host</h3>
                                        <label class="form-group">Your Name: <br><input type="text" value="{{ old("name") }}" name="name"
                                                                                        class="form-control">
                                            @error("name")
                                            <div class="error text-danger">{{ $message }}</div>@enderror
                                        </label>
                                        <label class="form-group">
                                            Your email: <br>
                                            <input type="text" name="email" value="{{ old("email") }}" class="form-control"
                                                   placeholder="example@email.com">
                                            @error("email")
                                            <div class="error text-danger">{{ $message }}</div>@enderror
                                        </label>
                                        <label class="form-group"> Password: <br><input type="password" name="password"
                                                                                        class="form-control">
                                            @error("password")
                                            <div class="error text-danger">{{ $message }}</div>@enderror
                                        </label>

                                        <label class="form-group"> Confirm Password : <br><input type="password"
                                                                                                 name="password_confirmation"
                                                                                                 class="form-control"></label>



                                        <div class="checkbox-container">
                                            <input type="checkbox" name="license_agree" />
                                            <span class="checkmark"></span>
                                            <p>I agree to the Terms of Service and Privacy Policy</p>
                                            @error("license_agree")
                                            <label><div class="error text-danger">{{ $message }}</div></label>@enderror
                                        </div>

                                        <div class="sign-up-node-submit">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    @endsection
@section("scripts")
    <script>

        document.getElementById("requirementForm").onsubmit = function(event) {
            event.preventDefault();
            var inputs = event.target.getElementsByTagName("input");
            var errElm = document.getElementById("signup-node-form-err-msg-container");
            var result = {
                "processor": false,
                "diskSpace": false,
                "availableBandwidth": false,
                "upstreamBandwidth": false,
                "downloadBandwidth": false,
                "downtime": false
            };

            for (input of inputs) {
                if (input.type === "submit") {
                    continue;
                }
                if (!input.checked) {

                    errElm.setAttribute("class", "row");
                    var formBody = document.querySelector('.requirements');

                    formBody.classList.add("addHeight")
                    return;
                }
                result[input.name] = input.value == "on";
            }
            errElm.setAttribute("class", "row invisible");

            $(".requirement-form").addClass("invisible");
            $(".email-form").removeClass("invisible")

        }

    </script>
    @endsection
