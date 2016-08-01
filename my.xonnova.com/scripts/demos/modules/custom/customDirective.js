myAppForm.directive('ngActiveuser', ['$http', function ($http) {
    return {
    require: 'ngModel',
    link: function (scope, elem, attrs, ctrl) {
    
      elem.on('blur', function (evt) {
      scope.$apply(function () {
        $http({ 
        type: 'json',
        method: 'POST', 
        url: BASE_URL+'unique/isActive', 
        data: { 
          username:elem.val(), 
          dbField:attrs.ngActiveuser
        } 
        }).success(function(data) {
        ctrl.$setValidity('activeuser', data.status);
       });
      });
      });
    }
    }
  }
]);