    $(document).ready(function() {
        window.YiiShop = window.YiiShop || {};

        let oTable =  $('#histories').DataTable( {
            'processing': true,
            'serverSide': true,
            'ajax': {
                url: '/history/ajax',
                type: 'POST'
            },
            columns: [
                { title: 'Id' },
                { title: 'Type' },
                { title: 'Card' },
                { title: 'User' },
                { title: 'Created' },
                { title: 'Info' }
            ],
            'columnDefs': [
                {
                    'targets': 0,
                    'name': 'h.id',
                    'searchable': false
                },
                {
                    'targets': 1,
                    'name': 't.name'
                },
                {
                    'targets': 2,
                    'name': 'c.name'
                },
                {
                    'targets': 3,
                    'name': 'u.email'
                },
                {
                    'targets': 4,
                    'name': 'h.createDate'
                },
                {
                    'targets': 5,
                    'sortable': false,
                    'searchable': false
                }
            ]
        } );
        yadcf.init(oTable,
        [
            {column_number : 1, data: window.YiiShop.optionsType},
            {column_number : 3, data: window.YiiShop.optionsUser},
            {column_number : 4, filter_type: "range_date", date_format: "yyyy-mm-dd", filter_delay: 500},
            {column_number : 2, data: window.YiiShop.cardOptions}
            ]
        );
    });
