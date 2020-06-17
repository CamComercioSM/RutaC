@push('styles')
    <style>
        #contenedor{
            position:relative;
            margin:5vh auto;
            width:1000px;
            height:500px;
        }

        #lienzo{
            background:url("../../../img/mountains.png");
            margin-right: auto;
            margin-left: auto;
            display: block;
        }

        #contenedor button{
            display:block;
            position: relative;
            margin:5px 0;
            padding:10px;
            cursor:pointer;
        }
    </style>
@endpush
<canvas id="lienzo" width="1000px" height="500px"></canvas>
<input type="hidden" id="resultado" value="{{ number_format($diagnostico->diagnosticoRESULTADO,0) }}" >
@push('scripts')
<script>
    let resultado;
    let mi_canvas;
    let contexto;
    let img_sprite;
    let X = 0;
	let y_canvas = 0;
	let contador = 0;
	let cuadro_del_sprite = 0;
	let cuadros_por_segundo = 0;
    let fotogramasPorSegundo = 50;
	let velocidad = 0.010;

    window.onload = function() { 
        resultadoDiv=document.getElementById("resultado").value;
        resultado= ((resultadoDiv * 900) / 100);
        mi_canvas = document.getElementById("lienzo");
        contexto = mi_canvas.getContext("2d"); 
        img_sprite = new Image();  
        img_sprite.src = "../../../img/opcion1.png";
        img_sprite.addEventListener('load', mostrar_imagen, false);
    }
    
    function mostrar_imagen() { 
        if((contador * 3) < resultado) {
            setTimeout(function() {
                fx_animar_imagen = requestAnimationFrame(mostrar_imagen);
            }, 500 / fotogramasPorSegundo);
        }

		contexto.clearRect(0, 0, mi_canvas.width, mi_canvas.height);
		dibularLinea();
		contexto.drawImage(img_sprite, 100*cuadro_del_sprite, 0, 100, 100,contador * 3, 400 - contador, 100, 100);
		cuadros_por_segundo++;
		
		if(cuadros_por_segundo % 3 == 0) {
            cuadro_del_sprite++;
            y_canvas++;
            contador++;
            if(cuadro_del_sprite > 5) {
                cuadro_del_sprite = 0;
            }
		}
	}
    
    function dibularLinea(){
        contexto.setLineDash([]);
        contexto.beginPath();
        contexto.moveTo(0, 500);
        contexto.lineTo(1000, 500);
        contexto.lineTo(1000, 200);
        contexto.lineTo(900, 200);
        contexto.strokeStyle = "green";
        contexto.lineWidth = 5;
        contexto.stroke();

        contexto.fillStyle ='rgba(65, 143, 51, 0.8)';
        contexto.fill();

        contexto.beginPath();
        contexto.setLineDash([4, 5]);
        contexto.strokeStyle = "red";
        contexto.lineWidth = 3;
        contexto.beginPath();
        contexto.moveTo(135, 500);
        contexto.lineTo(135, 200);
        contexto.stroke();
        contexto.beginPath();
        contexto.moveTo(275, 500);
        contexto.lineTo(275, 200);
        contexto.stroke();
        contexto.beginPath();
        contexto.moveTo(370, 500);
        contexto.lineTo(370, 200);
        contexto.stroke();
        contexto.beginPath();
        contexto.moveTo(725, 500);
        contexto.lineTo(725, 200);
        contexto.stroke();
        contexto.beginPath();

        contexto.fillStyle = "rgba(255, 175, 9, 0.8)";
        contexto.fillRect(900, 200, 100, 300);

        contexto.beginPath();
        contexto.font = "15px Arial";
        contexto.fillStyle = "black";
        contexto.fillText("Descubrimiento", 10, 497);
        contexto.beginPath();
        contexto.font = "15px Arial";
        contexto.fillStyle = "black";
        contexto.fillText("Nacimiento", 170, 497);
        contexto.beginPath();
        contexto.font = "15px Arial";
        contexto.fillStyle = "black";
        contexto.fillText("Crecimiento", 280, 497);
        contexto.font = "15px Arial";
        contexto.fillStyle = "black";
        contexto.fillText("Aceleración", 500, 497);
        contexto.font = "15px Arial";
        contexto.fillStyle = "black";
        contexto.fillText("Madurez", 850, 497);
    }
</script>
@endpush
