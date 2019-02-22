<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	@php
		$style = [
			'body' => "margin:0; padding:0; font-family: Arial, 'Helvetica Neue',Helvetica, sans-serif; background-color: #f2f2f2; width:100%;",
			'section_container' => 'width: 50%; margin:0 25%; background-color: #fff;',
			'nav' => 'background:#2ab27b; width:100%; margin:0; display: block; padding: 25px 0;',
			'nav_h1' => 'color: white; font-size: 38px; padding:5px 20px; text-align:center; margin: 0;',
			'section_body' => 'padding: 40px 25px; border-bottom: 2px solid #EAEAEA',			
			'footer' => 'padding: 25px; text-align:center; color: #656565; background-color: #FAFAFA;'
		];	
	@endphp
	<body style="{{ $style['body'] }}">
		<section style="{{ $style['section_container'] }}">
			<div style="{{ $style['nav'] }}">
				<h1 style="{{ $style['nav_h1'] }}">RUTAC</h1>
			</div>
			<section style="{{ $style['section_body'] }}">
				@yield('content')
				<footer style="{{ $style['footer'] }}">
					<hr style='border: 1px solid #EEEEEE'>
					<em>¿Necesitas ayuda? ¿Tienes comentarios? No dude en <a href="https://www.ccsm.org.co/" target="_blank">contactarnos</a>.</em>
					<br><br>
					<span style="font-size:10px">Enviado por la Cámara de Comercio de Santa Marta para el Magdalena</span>
					<br>
				</footer>
			</section>
		</section>	
	</body>
</html>