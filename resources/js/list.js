const { colors } = require("laravel-mix/src/Log");

var app = new Vue({
    el: '#app',
    data: {
        expenses: 'ciao',
        background: '',
        colorList: [
            'red',
            'blue',
            'yellow',
            'green'
        ],
        colorsBox: 'colorsBox',
        class1: 'block',
        class2: 'none',
        selectedColor: ''
    },
    methods: {
        nomeFunzione: function(){
            let xhr = new XMLHttpRequest();

            xhr.open('POST', '/list');
            xhr.responseType = 'json';
            xhr.send();
            xhr.onload = function() {
                let responseObj = xhr.response;
                alert(responseObj[0]['id']);
            };
        },
        testKeyup: function(){
            this.background = 'color';
        },
        selectColor: function(color){
            this.class1 = 'none';
            this.class2 = 'block';
            this.selectedColor = color;
        }
    }
});


