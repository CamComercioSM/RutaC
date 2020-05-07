$('#rutaActiva').on('show.bs.modal', function (e) {
    $('#linkRuta').attr('href', $(e.relatedTarget).data('route'));
});