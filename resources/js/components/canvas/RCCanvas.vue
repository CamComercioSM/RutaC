<template>
    <canvas id="lienzo" width="1000px" height="500px"></canvas>
</template>
<script>
    export default {
        props: {
            resultado: {
                default: 0,
            }
        },
        data: function() {
            return {
                vueCanvas: null,
                numero: 0,
                ubicacionX: 0,
                contador: 0,
                animacion: null,
                frame: null,
                sprite: null,
                mountain: null,
            }
        },
        methods: {
            load() {
                this.frame = window.requestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.msRequestAnimationFrame ||
                    window.oRequestAnimationFrame;

                this.sprite = new Image();
                this.sprite.src = "../../../img/opcion1.png";

                this.mountain = new Image();
                this.mountain.src = "../../../img/mountains.png";

                this.tiempo();
            },
            tiempo() {
                if(this.numero >= 600) {
                    this.numero = 0
                } else {
                    this.numero+=20
                }

                for(let i = 0; i <= this.numero; i+=100) {
                    if (this.numero >= i) {
                        this.ubicacionX = i
                    }
                }

                this.ctx.clearRect(0,0,this.vueCanvas.width,this.vueCanvas.height);
                this.dibularLinea();
                this.ctx.drawImage(this.sprite, this.ubicacionX, 0, 100, 100, (this.contador)*3, 400-this.contador, 100, 100);
                let result = ((this.res*900)/100);

                if ((this.contador * 3) < result) {
                    this.contador++;
                    this.animacion = this.frame(this.tiempo());
                }
            },
            dibularLinea() {
                this.ctx.setLineDash([]);
                this.ctx.beginPath();
                this.ctx.moveTo(0,500);
                this.ctx.lineTo(1000,500);
                this.ctx.lineTo(1000,200);
                this.ctx.lineTo(900,200);
                this.ctx.strokeStyle = "green";
                this.ctx.lineWidth = 5;
                this.ctx.stroke();
                this.ctx.fillStyle ='rgba( 65, 143, 51, 0.8 )';
                this.ctx.fill();
                this.ctx.beginPath();
                this.ctx.setLineDash([4, 5]);
                this.ctx.strokeStyle = "red";
                this.ctx.lineWidth = 3;
                this.ctx.beginPath();
                this.ctx.moveTo(200,500);
                this.ctx.lineTo(200, 200);
                this.ctx.stroke();
                this.ctx.beginPath();
                this.ctx.moveTo(400,500);
                this.ctx.lineTo(400, 200);
                this.ctx.stroke();
                this.ctx.beginPath();
                this.ctx.moveTo(600,500);
                this.ctx.lineTo(600, 200);
                this.ctx.stroke();
                this.ctx.beginPath();
                this.ctx.moveTo(800,500);
                this.ctx.lineTo(800, 200);
                this.ctx.stroke();
                this.ctx.beginPath();
                this.ctx.fillStyle="rgba(255, 175, 9, 0.8)";
                this.ctx.fillRect(900,200,100,300);
                this.ctx.beginPath();
                this.ctx.font = " 20px Arial";
                this.ctx.fillStyle = "black";
                this.ctx.fillText("Descubrimiento",50,497);
                this.ctx.beginPath();
                this.ctx.font = " 20px Arial";
                this.ctx.fillStyle = "black";
                this.ctx.fillText("Nacimiento",250,497);
                this.ctx.beginPath();
                this.ctx.font = " 20px Arial";
                this.ctx.fillStyle = "black";
                this.ctx.fillText("Crecimiento",450,497);
                this.ctx.font = " 20px Arial";
                this.ctx.fillStyle = "black";
                this.ctx.fillText("Aceleración",650,497);
                this.ctx.font = " 20px Arial";
                this.ctx.fillStyle = "black";
                this.ctx.fillText("Madurez",850,497);
            }
        },
        mounted() {
            this.vueCanvas = document.getElementById("lienzo");
            this.ctx = this.vueCanvas.getContext("2d");
            this.load();
        },
        created() {
            this.res = this.resultado;
            console.log(this.res);
        },
    }
</script>