'use strict';


var myApp = angular.module('themesApp', ['angularFileUpload']);


    myApp.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });
	}]);