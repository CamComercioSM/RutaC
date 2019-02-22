var _apisicam = _apisicam || {};
_apisicam.clavePublica = 'x';
_apisicam.clavePrivada = 'x';

window.apisicam || (function(d) {
  var s, c, o = apisicam = function(){
      o._.push(arguments);
  };
  o._ = [];
  s = d.getElementsByTagName('script')[0];
  c = d.createElement('script');
  c.type = 'text/javascript';
  c.charset = 'utf-8';
  c.async = true;
  c.src = 'https://sicam32-jpllinas.c9users.io/api/clientes/javascript/?' + _apisicam.clavePublica + ':' + _apisicam.clavePrivada;
  s.parentNode.insertBefore(c, s);
})(document);