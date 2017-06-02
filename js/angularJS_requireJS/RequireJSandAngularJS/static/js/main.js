/*require.config({
    baseUrl: 'C://Users/小老鼠/Desktop/RequireJSandAngularJS',
    
    paths: {
        'angular': 'lib/angular.min',
        'uiRouter': 'components/angular-route.min'
    },
    
    shim: {
        'app': {
            deps: ['angular']
        }
    }
});

require(['app'], function(){
    angular.bootstrap(document, ['myApp']);
})*/
//alert("安安");
require.config({
    baseUrl:'RequireJSandAngularJS',
    paths : {
        'jquery':'lib/jquery.min',
        'angular' : 'lib/angular.min'
    },
    shim : {
        'add' : {
            deps: ['angular']
        }
    }
});
require(['jquery','add'],function(){
    angular.bootstrap(document,['myApp']);
})