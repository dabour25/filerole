@php
    if(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->exists()){
        $org = DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->first();
    }
    if(App\Organization::where('custom_domain', explode('/',url()->current())[2])->exists()){
        $org = App\Organization::where('custom_domain', explode('/',url()->current())[2])->first();
    }
@endphp
@extends('layouts.login', ['title' => $org->name_en .' - Change Password'])

@section('content')
    <div class="limiter">
        <div class="container-login100"
             style="background:url({{ asset(!empty($org->front_image) && !empty(App\Photo::findOrFail($org->front_image)->file) ? str_replace(' ', '%20', App\Photo::findOrFail($org->front_image)->file) : '') }})">
            <div class="overlay_login"></div>

            <div class="wrap-login100 reset_pass">

                @if(Request::is('admin/password/reset/*'))
                    <form class="login100-form validate-form" method="post" action="{{ route('password.request') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="login100-pic js-tilt pulse" data-tilt>
                            <img src="{{ asset(!empty($org->image_id) && !empty(App\Photo::findOrFail($org->image_id)->file) ? App\Photo::findOrFail($org->image_id)->file : 'trust.png') }}"
                                 alt="IMG">
                        </div>
                        <span class="login100-form-title">
							Change Password
						</span>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email"
                                   value="{{ $email or old('email') }}">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
                            @if ($errors->any())
                                <div class="text-center p-t-12">
							<span class="txt1">
								{{ $errors->first() }}
							</span>
                                </div>
                            @endif
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Confirmation Password is required">
                            <input class="input100" type="password" name="password_confirmation"
                                   placeholder="Confirmation password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Change
                            </button>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="{{ url('admin/login') }}">
                                Back to login
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                @else
                    <form class="login100-form validate-form" method="post" action="{{ url('password/request') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
						<span class="login100-form-title">
							Change Password
						</span>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email"
                                   value="{{ $email or old('email') }}">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Confirmation Password is required">
                            <input class="input100" type="password" name="password_confirmation"
                                   placeholder="Confirmation password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Change
                            </button>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="{{ url('admin/login') }}">
                                Back to login
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>

    <script>
        function showPass() {
            var x = document.getElementById("showpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
