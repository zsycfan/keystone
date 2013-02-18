$(function() {

	$("[data-tags]").select2({
		initSelection: function(element, callback) {
			var data = [];
			var value = element.data('value');
			for (var i=0; len=value.length,i<len; i++) {
				data.push({id:value[i], text:value[i]});
			}
			callback(data);
		},
        width: '100%',
        multiple: true,
        tags: true,
        minimumInputLength: 1,
        tokenSeparators: [",", " "],
        ajax: {
            url: '/keystone/api/tags/search',
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term
                };
            },
            results: function (data, page) {
                return {
                    results: data
                };
            }
        }
    });

});