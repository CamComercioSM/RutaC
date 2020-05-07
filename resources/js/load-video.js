$('#videoEstacion').on('show.bs.modal', function (e) {
    $('#embedVideo').attr('src', 'https://www.youtube.com/embed/'+$(e.relatedTarget).data('route'));

    let estacion = $(e.relatedTarget).data('estacion');
    let ruta = $(e.relatedTarget).data('ruta');

    axios.get('http://localhost/innovando/RutaC/public/user/marcar-estacion/'+estacion+'/'+ruta, {})
        .then(function (response) {
            console.log(response);
        });
});