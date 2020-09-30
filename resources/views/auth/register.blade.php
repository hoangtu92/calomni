@extends("layout.landing")

@section('content')

    <div class="signup-node-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 signup-node-form">
                    <div>
                        <p class="sno-ad-message text-muted">For the best experience, disable ad blockers and use Chrome
                            or Edge.</p>
                        <div class="steps">
                            <span class="active">1</span>
                            <div></div>
                            <span>2</span>
                            <div></div>
                            <span>3</span>
                        </div>
                    </div>

                    <div class="form-container email-form-container">
                        <div class="form email-form">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-md-6 border-right pr-5">
                                        <h3>Your IP address</h3>


                                        <div class="form-group mt-5">
                                            {{ $_SERVER['REMOTE_ADDR'] }}
                                            {{--<div class="label-select">
                                                <input id="us-central" type="radio" name="region" value="US Central">
                                                <label for="us-central" >US Central</label>
                                            </div>
                                            <div class="label-select">
                                                <input id="asia-east" type="radio" name="region" value="Asia East">
                                                <label for="asia-east">Asia East</label>
                                            </div>
                                            <div class="label-select">
                                                <input id="europe-west" type="radio" name="region" value="Europe West">
                                                <label for="europe-west">Europe West</label>
                                            </div>
                                            @error("region")
                                            <label><div class="error text-danger">{{ $message }}</div></label>
                                            @enderror--}}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6 pl-5">
                                        <h3>Sign Up</h3>
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
                                            <input type="submit" value="Continue" class="btn btn-primary">
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
