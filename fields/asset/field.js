$(document).on('field:init', '.field-asset', function() {
  var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: $(this).find('.uploader').get(0),
    // path to server-side upload script
    action: '/keystone/assets/upload',
    // only allow a single image
    multiple: false,
    onUpload: function(id, fileName) {
      $(this._element).trigger('asset:update');
    },
    onComplete: function(id, fileName, responseJSON) {
      list = $(uploader._element).closest('.field-asset').find('.file-list');
      list.find('li').remove();
      li = $('<li />').appendTo(list);
      li.append('<img src="/uploads/'+responseJSON.asset.name+'" width="200" />');
      li.append('<input type="hidden" name="file" value="'+responseJSON.asset.id+'" />');
      li.append('<a class="remove" href="#">Remove</a>');
      $(this._element).trigger('asset:update');
    },
    uploadButtonText: '<i class="icon-picture"></i>',
    template: '<div class="qq-uploader">' +
            '<ul class="qq-upload-list" style="display:none;"></ul>' +
            '<div class="qq-upload-drop-area"><span>{dragText}</span></div>' +
            '<div class="qq-upload-button">{uploadButtonText}</div>' +
            '</div>',
  });
  $(this).trigger('asset:update');
});

$(document).on('click', '.file-list .remove', function(e) {
  fileList = $(this).closest('.file-list');
  $(this).closest('li').remove();
  fileList.trigger('asset:update');
  return false;
});

$(document).on('asset:update', '.field-asset', function(e) {
  if ($(this).find('.file-list li').size()) {
    $(this).find('.qq-upload-button').hide();
  }
  else {
    $(this).find('.qq-upload-button').show();
  }
});