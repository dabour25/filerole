@extends('layouts.login', ['title' => DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('name'). ' - Shere'])

@section('content')
<style>
	.wrap-login {
		/* width: 840px; */
		background: #17121812;
		border-radius: 10px;
		overflow: hidden;
		display: -webkit-box;
		display: -webkit-flex;
		display: -moz-box;
		display: -ms-flexbox;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		padding: 40px 50px 40px 140px;
	}
	.login-form {
		/* width: 300px; */
		margin: 0 0 0 0;
		position: relative;
		left: -55px;
	}
</style>
<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login">
			<form class="login-form validate-form" method="post" action="{{ url('hotel_share_submit') }}">
				@csrf
				<input type="hidden" name="id" value="{{ $id }}">
				@if (Session::has('message'))
					<div class="alert alert-danger">
						<strong>{{ session('message') }}</strong>
					</div>
				@endif
				<div class="wrap-input100 validate-input" data-validate = "Password is required">
					<input class="input100" type="text" name="password" placeholder="Share code">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Submit
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
