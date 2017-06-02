angular.module('myApp',[])
.controller('UserClass',function($scope){
  
    $scope.formData = {
        zw :'JAVA工程师'
    };
    
    $scope.zwxiala = ['JAVA工程师','.NET工程师','测试工程师'];
    $scope.register = function(u){
        console.log(u);
    }
})