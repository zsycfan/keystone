(function($){

  $.fn.videoEmbed = function(url)
  {
    if (url.match(/youtube.com/)) {
      parts = url.match(/v=([a-z0-9_]+)/i);
      src = 'http://www.youtube.com/embed/'+parts[1];
      this.replaceWith('<iframe src="'+src+'" width="420" height="315" frameborder="0" allowfullscreen />');
    }
    else if (url.match(/youtu.be/)) {
     parts = url.match(/youtu.be\/([a-z0-9_]+)/i);
      src = 'http://www.youtube.com/embed/'+parts[1];
      this.replaceWith('<iframe src="'+src+'" width="420" height="315" frameborder="0" allowfullscreen />'); 
    }
    else if (url.match(/vimeo.com/)) {
      parts = url.match(/vimeo.com\/(\d+)/);
      src = 'http://player.vimeo.com/video/'+parts[1];
      this.replaceWith('<iframe src="'+src+'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="815" height="458" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen />');
    }
  };

})( jQuery );