// @codekit-prepend "jquery.min.js"
// @codekit-prepend "jquery.fitvid.min.js"
// @codekit-prepend "bootstrap.min.js"
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
  $('form[data-autosubmit]').autoSubmit({
    'delay': 1000
  });

  // Form submissions
  $(document).on('submit', 'form[data-action="edit-node"]', function() {
    var form = $(this);
    form.matryoshka();
    form.contenteditable();
    form.find('input[type="submit"]').tempVal('Saving...');
    $.post('#', $(this).serializeObject(), function(data) {
      form.find('input[type="submit"]').tempVal(':reset');
    })
    return false;
  });

  // Choose Field
  $(document).on('click', '[data-action="choose-field"]', function() {
    $(this).closest('[data-region]').find('[data-fields]').attr('data-waiting-for', 'field');
    $.get($(this).attr('href'), function(data) {
      $(data).appendTo(document.body).modal();
    });
    return false;
  });

  // Add Field
  $(document).on('submit', '[data-action="add-field"]', function() {
    var modalElement = $(this).closest('.modal');
    $.post($(this).attr('action'), {'field':{'type':'plain'}}, function(data) {
      $('[data-waiting-for="field"]').append(data).removeAttr('data-waiting-for');
      modalElement.modal('hide');
    });
    return false;
  });

});