var _apisicam = _apisicam || {};
<<<<<<< HEAD
_apisicam.clavePublica = 'x';
_apisicam.clavePrivada = 'x';
=======
_apisicam.clavePublica = 'm8mcJFLAGT5ba%2FP%2BUNITJv3jf9%2FU4zDM2DERnNFpMjGhC1xXlFAPleRAorZVikJA';
_apisicam.clavePrivada = 'l6LHlDIvNrsuFtLDZx0ti80%2BZltejZmFVokVWczuEuU%3D';
>>>>>>> d1e1240add6e7eee73d5a2a47eda264d4e130768

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