$(document).on('field:init', '.field-relationship', function(e) {
  $('.field-relationship').find('input').typeahead({
    source: function(query, process) {
      var that = this;
      return $.get('/keystone/api/pages/'+query, function(data) {
        that.data = data
        return that.process(data)
      })
    },
    matcher: function (item) {
      return true
    },
    sorter: function (items) {
      return items
    },
    highlighter: function (item) {
      var queries = this.query.split(/\s+/)
      var title = item.title
      for (var i=0; len=queries.length,i<len; i++) {
        var query = queries[i].replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
        title = title.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
          return '{{' + match + '}}'
        })
      }
      return title.replace(/\{\{/g, '<strong class="relationship-highlighter">').replace(/\}\}/g, '</strong>');
    },
    updater: function(item) {
      var item = this.data[this.$menu.find('.active').index()];
      this.$element.before('<div class="selected"><i class="icon-sitemap"></i> '+item.title+'<input type="hidden" name="related" value="'+item.id+'" /></div>')
      return item.title
    }
  });
});