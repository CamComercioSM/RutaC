var _apisicam = _apisicam || {};
_apisicam.clavePublica = 'm8mcJFLAGT5ba%2FP%2BUNITJv3jf9%2FU4zDM2DERnNFpMjGhC1xXlFAPleRAorZVikJA';
_apisicam.clavePrivada = 'l6LHlDIvNrsuFtLDZx0ti80%2BZltejZmFVokVWczuEuU%3D';

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
  c.src = 'https://api.sicam32.net/clientes/javascript/index.php?' + _apisicam.clavePublica + ':' + _apisicam.clavePrivada;
  s.parentNode.insertBefore(c, s);
})(document);