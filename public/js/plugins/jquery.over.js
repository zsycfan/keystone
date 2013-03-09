(function($){
  $.fn.over = function(x, y, properties)
  {
    var location = $(this).location(properties);

    if (y >= location.top && y <= location.top + location.height/2 && x >= location.left && x <= location.right) {
      return 'topHalf';
    }
    if (y >= location.top + location.height/2 && y <= location.bottom && x >= location.left && x <= location.right) {
      return 'bottomHalf';
    }
    if (y >= location.top && y <= location.bottom && x >= location.left && x <= location.left + location.width/2) {
      return 'leftHalf';
    }
    if (y >= location.top && y <= location.bottom && x >= location.left + location.width/2 && x <= location.right) {
      return 'rightHalf';
    }

    return false;
  };

})( jQuery );