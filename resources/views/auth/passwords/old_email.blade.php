@extends('layouts.login', ['title' => 'Filerole Systems - Forget Password'])

@section('content')
    <div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic js-tilt" data-tilt>
				<img src="{{ asset(!empty(App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id'))->file) ? App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2] )->value('image_id'))->file : 'images/img-01.png') }}" alt="IMG">
			</div>
			

                
			@if(Request::is('admin/password/reset'))
            <form class="login100-form validate-form" method="post" action="{{ route('password.email') }}">
			    @csrf
				<span class="login100-form-title">
					Forget Password
				</span>

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
				</div>
				@if($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                @endif
				@if ($errors->any())
					<p class="text-success">{{ $errors->first() }}</p>
				@endif
				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Forget
					</button>
				</div>

				<div class="text-center p-t-136">
					<a class="txt2" href="{{ route('login') }}">
						Back to login
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>
			</form>
            @else
            <form class="login100-form validate-form" method="post" action="{{ url('password/email') }}">
			    @csrf
				<span class="login100-form-title">
					Forget Password
				</span>
				

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
				</div>
				@if($errors->has('email'))
					<p class="text-danger">{{ $errors->first('email') }}</p>
				@endif
				@if ($errors->any())
					<p class="text-success">{{ $errors->first() }}</p>
				@endif
				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Forget
					</button>
				</div>

				<div class="text-center p-t-136">
					<a class="txt2" href="{{ route('login') }}">
						Back to login
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>
			</form>
            @endif
			    
		</div>
	</div>
</div>
@endsection
