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
				<h1>Estimado (a), {{$data->dato_usuarioNOMBRE_COMPLETO}}:</h1>
	
				<p style="text-align: justify;font-size: 1.3em;line-height: 1.3em;letter-spacing: 2px;">
					A través de este programa, usted podrá fortalecer los conocimientos y habilidades para el desarrollo y crecimiento de su negocio, así como también encontrar el acompañamiento y herramientas necesarias para cumplir su sueño empresarial.
				</p>

				<p style="text-align: justify;font-size: 1.3em;line-height: 1.3em;letter-spacing: 2px;">
					Para poder avanzar en su ruta de crecimiento, lo invitamos a realizar el auto diagnóstico de su negocio/proyecto empresarial.
				</p>

			    <h1 style="text-align: center;letter-spacing: 2px;width: 80%;margin: 50px 10%;">
					¡Gracias por ser parte de este programa, estamos creciendo contigo!
				</h1>
				<p style="text-align: center;letter-spacing: 2px;width: 50%;margin: 0px 25%;line-height: 1.4em;">
					Si tiene alguna inquietud sobre su diagnóstico, por favor contáctenos al correo <a href="mailto:rutac@ccsm.org.co">rutac@ccsm.org.co</a>
				</p>
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