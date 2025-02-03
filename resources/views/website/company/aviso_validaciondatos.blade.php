
<div id="modalValidacionDatosDiagnostico" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Debes seleccionar una opción para continuar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Para nosotros es muy importante tu información.</p>
                <h4>Selecciona una de las opciones para continuar con el diagnostico.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var modalValidacionDatosDiagnostico = null;
    $(document).ready(function () {
            modalValidacionDatosDiagnostico = new bootstrap.Modal('#modalValidacionDatosDiagnostico', {
                    keyboard: false
            });
            $('#modalValidacionDatosDiagnostico').modal('show');
    });
</script>
<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


