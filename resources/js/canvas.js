let frame = window.requestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.msRequestAnimationFrame;

let canvas = document.querySelector("#lienzo");
let ctx = canvas.getContext("2d");

width=1000 ;
height=500;
let numero = 0;
let ubicacionX = 0;
let contador =0;
let animacion;

//Dibujar SPRITE
let sprite = new Image();
sprite.src = "../../../img/opcion1.png";

let mountain = new Image();
mountain.src = "../../../img/mountains.png";
// sprite.onload = function(){

// 	//ctx.drawImage(imagen, ubicacionX, ubicacionY, recorteX, recorteY, x1,y1, x2, y2);
// 	ctx.drawImage(sprite, 0, 0, 100, 100, 0, 100, 100, 100);

// }

function tiempo(){

    if(numero >= 600){numero = 0}else{numero+=20}

    for(let i = 0; i <= numero; i+=100){

        if(numero >= i){ubicacionX = i}
    }

    ctx.clearRect(0,0,canvas.width,canvas.height);
    dibularLinea();
    ctx.drawImage(sprite, ubicacionX, 0, 100, 100, (contador)*3, 400-contador, 100, 100);
    if ((contador*3)<250) {
        contador++;
        animacion = frame(tiempo);
    }

}

tiempo();

//cancelAnimationFrame()

/*setTimeout(function(){

cancelAnimationFrame(animacion)

},3000)*/

function dibularLinea(){
    /*=============================================
    MONTAÑA
    =============================================*/
    //ctx.beginPath();
    //ctx.drawImage(mountain,0,0);


    //-------Montaña
    ctx.setLineDash([]);
    ctx.beginPath();
    //ctx.moveTo(x1,y1);
    ctx.moveTo(0,500);
    //ctx.lineTo(x2,y2);
    ctx.lineTo(1000,500);
    ctx.lineTo(1000,200);
    ctx.lineTo(900,200);
    ctx.strokeStyle = "green";
    //Contorno línea
    ctx.lineWidth = 5;
    ctx.stroke();

    //Relleno linea
    ctx.fillStyle ='rgba( 65, 143, 51, 0.8 )';
    ctx.fill();

    /*=============================================
    LINEAS
    =============================================*/

    ctx.beginPath();
    ctx.setLineDash([4, 5]);
    ctx.strokeStyle = "red";
    ctx.lineWidth = 3;
    ctx.beginPath();
    ctx.moveTo(200,500);
    ctx.lineTo(200, 200);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(400,500);
    ctx.lineTo(400, 200);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(600,500);
    ctx.lineTo(600, 200);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(800,500);
    ctx.lineTo(800, 200);
    ctx.stroke();
    /*=============================================
    RECTANGULO
    =============================================*/
    ctx.beginPath();

    ctx.fillStyle="rgba(255, 175, 9, 0.8)";
    ctx.fillRect(900,200,100,300);
    /*=============================================
    TEXTO
    =============================================*/
    ctx.beginPath();
    ctx.font = " 20px Arial";
    ctx.fillStyle = "black";
    ctx.fillText("Descubrimiento",50,497);
    ctx.beginPath();
    ctx.font = " 20px Arial";
    ctx.fillStyle = "black";
    ctx.fillText("Nacimiento",250,497);
    ctx.beginPath();
    ctx.font = " 20px Arial";
    ctx.fillStyle = "black";
    ctx.fillText("Crecimiento",450,497);
    ctx.font = " 20px Arial";
    ctx.fillStyle = "black";
    ctx.fillText("Aceleración",650,497);
    ctx.font = " 20px Arial";
    ctx.fillStyle = "black";
    ctx.fillText("Madurez",850,497);
}
