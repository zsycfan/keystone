// @codekit-prepend "jquery.min.js"
// @codekit-prepend "jquery.fitvid.min.js"
// @codekit-prepend "plugins/jquery.draggable.js"
// @codekit-prepend "plugins/jquery.matryoshka.js"
// @codekit-prepend "plugins/jquery.location.js"
// @codekit-prepend "plugins/jquery.over.js"
// @codekit-prepend "plugins/jquery.contenteditable.js"
// @codekit-prepend "plugins/jquery.autosubmit.js"
// @codekit-prepend "plugins/jquery.serializeobject.js"
// @codekit-prepend "plugins/jquery.tempval.js"
// @codekit-prepend "plugins/jquery.videoembed.js"

$(function() {

  // Make fields sortable
  $('.fields').sortable({
    handle:'.icon',
    placeholder: '<div class="placeholder"><i class="icon-caret-left"></i><i class="icon-caret-right"></i></div>',
    onSortFinish: function() {
      $(this).closest('form').trigger('submit');
    }
  });

  // Make videos fit
  $(document.body).fitVids();

  // Make video field types work
  $(document).on('keyup', '.field-type-video input', function() {
    $(this).parents('.field-type-video').find('iframe').videoEmbed($(this).val());
  });

  // Allow forms to autosubmit
  $('form').autoSubmit({
    'delay': 1000
  });

  // Form submissions
  $(document).on('submit', 'form', function() {
    var form = $(this);
    form.matryoshka();
    form.contenteditable();
    form.find('input[type="submit"]').tempVal('Saving...');
    $.post('#', $(this).serializeObject(), function(data) {
      form.find('input[type="submit"]').tempVal(':reset');
    })
    return false;
  });

});