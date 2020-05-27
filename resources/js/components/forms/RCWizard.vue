<template>
    <ValidationObserver v-slot="{ passes }" slim>
        <b-form ref="form" v-bind="$attrs" @submit.prevent="passes(onSubmit)">
            <div class="col-md-12">
                <slot/>
                <div id="content"></div>
            </div>
            <div class="text-right">
                <span id="noRespond" class="text-danger">Debe contestar la pregunta antes de continuar.</span>
                <b-button-group class="mt-2">
                    <b-button variant="info" class="btn-sm" id="siguiente" @click="siguiente">Siguiente <i class="fas fa-arrow-right"></i></b-button>
                    <b-button variant="success" class="btn-sm" id="finalizar" type="submit">Finalizar <i class="fas fa-check"></i></b-button>
                </b-button-group>
            </div>
        </b-form>
    </ValidationObserver>
</template>

<script>
    import {ValidationObserver} from "vee-validate";

    export default {
        components: {
            ValidationObserver
        },
        props: {
            initialValue:{
                default: null,
            },
            seccion:{
                default: null,
            }
        },
        data: function() {
            return {
                current: null,
                currentQ: 0,
                final: 0,
                result: {},
                dependiente: 0,
                respuestaD: 0,
                seleccionadoD: 0,
            }
        },
        mounted() {
            document.getElementById('noRespond').style.display = 'none';
            document.getElementById('finalizar').style.display = 'none';
            this.current = JSON.parse(this.initialValue);
            this.final = this.current.length;
            this.actual()
        },
        methods: {
            actual() {
                if (this.dependiente === 0) {
                    document.getElementById("content").innerHTML = this.construir();
                } else {
                    this.dependiente = 0;
                    if (this.seleccionadoD == this.respuestaD) {
                        this.saltarPendiente();
                    } else {
                        this.actual();
                    }
                }
            },
            siguiente() {
                document.getElementById('noRespond').style.display = 'none';

                if (this.seleccionado()) {
                    this.construirNodo();
                    this.currentQ++;
                    if (this.currentQ < this.final) {
                        this.actual();

                        if (this.currentQ === this.final-1) {
                            document.getElementById('siguiente').style.display = 'none';
                            document.getElementById('finalizar').style.display = 'block';
                        } else {
                            document.getElementById('finalizar').style.display = 'none';
                        }
                    }
                } else {
                    document.getElementById('noRespond').style.display = 'block';
                }
            },
            saltarPendiente() {
                this.construirNodo();
                this.currentQ++;
                if (this.currentQ < this.final) {
                    this.actual();

                    if (this.currentQ === this.final-1) {
                        document.getElementById('siguiente').style.display = 'none';
                        document.getElementById('finalizar').style.display = 'block';
                    } else {
                        document.getElementById('finalizar').style.display = 'none';
                    }
                }
            },
            onSubmit () {
                document.getElementById('noRespond').style.display = 'none';

                if (this.seleccionado()) {
                    this.construirNodo();
                    console.log(JSON.stringify(this.result));
                    document.getElementById("respondData").value = window.btoa(JSON.stringify(this.result));

                    document.getElementById('loading').style.visibility = 'visible';
                    this.$refs.form.submit();
                } else {
                    document.getElementById('noRespond').style.display = 'block';
                }
            },
            construirNodo() {
                this.result[this.current[this.currentQ].resultado_preguntaPREGUNTAID] = this.seleccionado();
            },
            seleccionado() {
                let name = 'pregunta['+this.current[this.currentQ].resultado_preguntaID+']';
                let ele = document.getElementsByName(name);

                for(let i = 0; i < ele.length; i++) {
                    if(ele[i].checked) {
                        this.seleccionadoD = ele[i].value;
                        return ele[i].value;
                    }
                }

                return null;
            },
            construir() {
               let html = "<h3>"+this.current[this.currentQ].resultado_preguntaENUNCIADO_PREGUNTA+"</h3>";

                for (let i = 0; i < this.current[this.currentQ].respuestas.length; i++) {
                    let preguntaID = this.current[this.currentQ].resultado_preguntaID;
                    let respuestaID =  this.current[this.currentQ].respuestas[i].respuestaID;
                    let presentacion =  this.current[this.currentQ].respuestas[i].respuestaPRESENTACION;

                    if (this.current[this.currentQ].respuestas[i].dependiente) {
                        this.dependiente = this.current[this.currentQ].respuestas[i].dependiente.pregunta_dependienteHIJA;
                        this.respuestaD = this.current[this.currentQ].respuestas[i].dependiente.pregunta_dependienteRESPUESTA;
                    }

                    html = html+"<div class='form-check'>" +
                        "<input class='form-check-input' type='radio' " +
                        "name='pregunta["+preguntaID+"]'" +
                        "id='r_"+respuestaID+"' " +
                        "value='"+respuestaID+"'>" +
                        "<label class='form-check-label' for='r_"+respuestaID+"'>" +
                        presentacion +
                        "</label>" +
                        "</div>";
                }

                return html
            }
        }
    };
</script>
