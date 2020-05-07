$('#videoEstacion').on('show.bs.modal', function (e) {
    $('#embedVideo').attr('src', 'https://www.youtube.com/embed/'+$(e.relatedTarget).data('route'));
});