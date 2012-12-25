$(function() {

    $("[data-tags]").select2({
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