<html lang=ja>
<head>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/main/dashboard/login.css') }}" />
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<link rel="icon" href="/img/cap-icon.png">
	<title>CAP ログイン</title>
</head>
<body class="container-fluid">
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="box">
			<div class="logo-contents">
				<img src="img/cap-icon.png" alt="cap_logo" width="70px" height="60px">
				<!-- <img src="img/cap-char-logo.png" alt="cap_char" width="70px" height="45px"> -->
				<p>Cognitive AD-Check Platform</p>
			</div>
			<form role="form">
				<div class="divider-form"></div>
				<div class="form-group">
					<label for="inputEmail">メールアドレス</label>
					<input type="email" class="form-control" id="exampleInputEmail1" placeholder="メールアドレスを入力してください。">
					@if ($errors->has('email'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<div class="divider-form"></div>
				<div class="form-group">
					<label for="inputPassword">パスワード</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワードを入力してください。">
					@if ($errors->has('password'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
				<div class="divider-form"></div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
					</label>
				</div>
				<button type="submit" class="btn-block btn btn-lg btn-primary">サインイン</button>
				<a class="btn btn-link" href="{{ route('password.request') }}">
					パスワードが分からなくなった場合はこちら
				</a>
			</form>
			</div>
		</div>
	</div>
</body>
</html>