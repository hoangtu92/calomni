@extends("layout.frontend")

@section("content")

    <section class="header header-bg">
        @include("layout.general.menu")

        <div class="container">
            <div class="spacer30"></div>

            <div class="spacer30"></div>
            <div class="row mb-24 text-center">
                <div class="col-xs-12 col-lg-12">
                    <h1 class="hero-heading col-xs-12">Lorem ipsum dolor sit amet</h1>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    <p class="hero-subheading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

                </div>
            </div>

            <div class="hero-sections">
                <div class="hero-host col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hero-section-logo">
                                <img alt="Storj logo" src="{{ asset("images/logo-blue.png") }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="hero-section-subHeading">Lorem ipsum</h1>
                            <p class="hero-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <a class="btn btn-primary hero-sections-cta" href="{{ route("sign_up_host") }}">Become
                                a Service Host</a>

                            <a class="btn btn-primary hero-sections-cta" href="{{ backpack_url("/login") }}">Login

                            </a>

                        </div>
                    </div>
                </div>
                <div class="hero-cs col-sm-12 col-md-6 careers-grey">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hero-section-logo">
                                <img alt="Tardigrade logo" class="hero-section-logo-tardigrade"
                                     src="{{ asset("images/logo-blue.png") }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="hero-section-subHeading">Lorem ipsum</h1>
                            <p class="hero-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <a class="btn btn-primary hero-sections-cta" href="{{ route("register") }}">Become a Request Host

                            </a>

                            <a class="btn btn-primary hero-sections-cta" href="{{ backpack_url("/login") }}">Login

                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <img alt="globe background" class="globe-background" src="{{ asset("images/globe.png") }}">

        </div>
    </section>


    {{--<div class="diskSpace-bg container-fluid">
        <div class="container">
            <div class="row text-center">
                <div class="spacer100"></div>
                <div class="col-xs-12 text-center mt-5">
                    <h1 class="diskSpace-header">Put Your Extra Disk Space to Work</h1>
                    <p class="diskSpace-subheader">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <div class="spacer60"></div>
                </div>
                <div class="diskSpace-content row mt-5" style="margin-top:100px;">

                    <div class="diskSpace-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="diskSpace-icon">
                            <img alt="Get Paid" class="img-fluid" height="37" src="{{ asset("images/storj-ico-coins.svg") }}"
                                 width="35">
                        </div>
                        <div class="spacer30"></div>
                        <h4 class="diskSpace-subheading">
                            Get Paid
                        </h4>
                        <div class="spacer20"></div>
                        <p class="diskSpace-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.                         </p>
                    </div>

                    <div class="diskSpace-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="diskSpace-icon">
                            <img alt="Be the Cloud" class="img-fluid" height="35" src="{{ asset("images/storj-ico-cloud.svg") }}"
                                 width="47">
                        </div>
                        <div class="spacer30"></div>
                        <h4 class="diskSpace-subheading">
                            Be the Cloud
                        </h4>
                        <div class="spacer20"></div>
                        <p class="diskSpace-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.                         </p>
                    </div>

                    <div class="diskSpace-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="diskSpace-icon">
                            <img alt="Use Existing Hardware" class="img-fluid" height="34"
                                 src="{{ asset("images/storj-ico-hardware.svg") }}" width="54">
                        </div>
                        <div class="spacer30"></div>
                        <h4 class="diskSpace-subheading">
                            Use Existing Hardware
                        </h4>
                        <div class="spacer20"></div>
                        <p class="diskSpace-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.                         </p>
                    </div>

                </div>
                <div class="spacer60"></div>
                <a class="btn btn-primary diskSpace-button" href="https://storj.io/storage-node-estimator/">Estimate Your
                    Node's Payout</a>
            </div>
            <div class="spacer125"></div>
        </div>
    </div>


    <div class="introducing careers-grey container-fluid">
        <div class="container">
            <div class="spacer100"></div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-5 col-md-12 text-center introducing-content">
                    <h2 class="introducing-heading">
                        Upgrade Your Storage Layer
                    </h2>
                    <br>
                    <p class="introducing-subheading">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                    </p>
                    <div class="spacer20"></div>
                    <div>
                        <ul class="introducing-list">

                            <li class="introducing-list-item">
                                <img alt="Checkmark" class="introducing-list-check" src="{{ asset("images/storj-check.svg") }}">
                                <h4 class="introducing-list-item-content">100% Secure</h4>
                            </li>

                            <li class="introducing-list-item">
                                <img alt="Checkmark" class="introducing-list-check" src="{{ asset("images/storj-check.svg") }}">
                                <h4 class="introducing-list-item-content">A Fraction of the Cost</h4>
                            </li>

                            <li class="introducing-list-item">
                                <img alt="Checkmark" class="introducing-list-check" src="{{ asset("images/storj-check.svg") }}">
                                <h4 class="introducing-list-item-content">More Durable</h4>
                            </li>

                            <li class="introducing-list-item">
                                <img alt="Checkmark" class="introducing-list-check" src="{{ asset("images/storj-check.svg") }}">
                                <h4 class="introducing-list-item-content">Easier to Use</h4>
                            </li>

                        </ul>
                        <div class="spacer30"></div>
                        <p class="introducing-cta-text">
                            <a class="introducing-cta-link" href="https://tardigrade.io/" target="_blank">
                                Visit Tardigrade.io
                                <img alt="Visit Tardigrade.io" height="16" src="{{ asset("images/carrot-right.svg") }}" width="16">
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                </div>
            </div>
            <div class="col-lg-7 col-md-12 introducing-bg">
            </div>
        </div>
    </div>


    <div class="container-fluid helpDevs-bg">
        <div class="container">
            <div class="row text-center">
                <div class="col-xs-12 text-center mt-5">
                    <h1 class="helpDevs-header">Lorem ipsum dolor sit amet<br> onsectetur adipiscing elit, sed do eiusmod tempor incididunt</h1>
                    <div class="spacer60"></div>
                </div>
                <div class="row mt-5" style="margin-top:100px;">

                    <div class="helpDevs-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="helpDevs-icon">
                            <img alt="Encrypt &amp; Upload Files" class="img-fluid" height="110"
                                 src="{{ asset("images/encrypt-upload.png") }}" width="110">
                        </div>
                        <h4 class="helpDevs-subheading">
                            Encrypt &amp; Upload Files
                        </h4>
                        <div class="spacer20"></div>
                        <p class="helpDevs-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.                         </p>
                    </div>

                    <div class="helpDevs-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="helpDevs-icon">
                            <img alt="Split Files &amp; Distribute" class="img-fluid" height="110"
                                 src="{{ asset("images/split-files.png") }}" width="110">
                        </div>
                        <h4 class="helpDevs-subheading">
                            Split Files &amp; Distribute
                        </h4>
                        <div class="spacer20"></div>
                        <p class="helpDevs-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>

                    <div class="helpDevs-section col-xs-12 col-lg-4 mt-5 p-3 text-xs-center">
                        <div class="helpDevs-icon">
                            <img alt="Store &amp; Retrieve File Pieces" class="img-fluid" height="110"
                                 src="{{ asset("images/store-retrieve.png") }}" width="110">
                        </div>
                        <h4 class="helpDevs-subheading">
                            Store &amp; Retrieve File Pieces
                        </h4>
                        <div class="spacer20"></div>
                        <p class="helpDevs-desc">
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>

                </div>
            </div>
            <div class="spacer45"></div>
            <div class="spacer45"></div>
            <div class="spacer45"></div>
        </div>
    </div>

    <div>
        <div class="row">
            <div class="col-lg-6 careers-grey">
                <div class="osp">
                    <div class="spacer90"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <img alt="Open Source" class="osp-image" src="{{ asset("images/opensource-storj.png") }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="osp-heading">Got an Open Source App?</h1>
                            <p class="osp-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <div class="spacer15"></div>
                            <a class="btn btn-primary ospTrans-button" href="https://tardigrade.io/partner/"
                               target="_blank">Become a Tardigrade Partner</a>
                        </div>
                    </div>
                </div>
                <div class="spacer125"></div>
            </div>
            <div class="col-lg-6">
                <div class="transparency">
                    <div class="spacer90"></div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img alt="Token transparency" class="transparency-img" src="{{ asset("images/governance.png") }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="transparency-heading">Token Transparent</h1>
                            <p class="transparency-subheading">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <div class="spacer15"></div>
                            <a class="btn btn-primary ospTrans-button"
                               href="https://storj.io/blog/2018/12/an-overview-of-tokens-uses-flows-and-policies-at-storj-labs/"
                               target="_blank">Learn More</a>
                        </div>
                    </div>
                    <div class="spacer90"></div>
                </div>
            </div>
        </div>
    </div>--}}


    @endsection

