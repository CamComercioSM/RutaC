$('#marcarEstacion').on('show.bs.modal', function (e) {
    let estacion = $(e.relatedTarget).data('estacion');
    let ruta = $(e.relatedTarget).data('ruta');

    axios.get('http://localhost/innovando/RutaC/public/user/marcar-estacion/'+estacion+'/'+ruta, {})
        .then(function (response) {
            console.log(response);
            document.getElementById("cumplimiento").innerHTML = response.data.cumplimiento;
            document.getElementById("icCumplimiento-"+estacion).innerHTML = '<i class="fas fa-check-circle text-success mr-2"></i>';
        });
});