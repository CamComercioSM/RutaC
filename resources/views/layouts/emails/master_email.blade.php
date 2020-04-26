<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body style="margin:0; padding:0; font-family: Arial, 'Helvetica Neue',Helvetica, sans-serif; background-color: #f2f2f2; width:100%;">
		<section style="width: 90%;margin:0 5%;border: 5px solid #fff;border-radius: 20px;">
			<div style="width:100%;margin:0;display: block;">
				<img style="width: 100%;" src="{{ asset('public/mails/01.png') }}"/>
			</div>
			<div style="width: 80%;margin: 5% 10%;">
				
				@yield('content')
			
			</div>
			<div style="width: 50%;margin:0;display: block;padding: 0px 25%;">
				<img style="width: 100%;" src="{{ asset('public/mails/03.png') }}"/>
			</div>
			<div style="width: 50%;margin:0;display: block;padding: 0 25%;">
				<img style="width: 100%;" src="{{ asset('public/mails/04.png') }}"/>
			</div>
			<div style="width:100%;margin:0;display: block;">
				<img style="width: 100%;" src="{{ asset('public/mails/02.png') }}"/>
			</div>
		</section>	
	</body>
</html>