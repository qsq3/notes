require.config({
    urlArgs : "bust="+ (new Date()).getTime(),

    baseUrl : "./",

    paths :{
        "jquery" : ["http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min", "../requireJS/lib/jquery/jquery.min"],
        "bootstrap" : ["http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js","../requireJS/lib/bootstrap/bootstrap.min"],
        "angular" : ["http://apps.bdimg.com/libs/angular.js/1.4.6/angular.min", "../requireJS/lib/angularjs/angular.min"],
    },

    shim: {
        'jquery': {
            exports: 'jQuery'
        }
        ,"angular":{
          exports: "angular"
        }
        ,'bootstrap': {
            deps: ['jquery']
        }
    }

});


require(["jquery","angular"],function($,angular){

    function hello($scope){
        $scope.greeting = {
            text:'Hello'
        };
    }

})
