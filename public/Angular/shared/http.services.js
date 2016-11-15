/**
 * Created by:  Muhammad Basit Munir
 * Date: 15 November 2016.
 * Description: 
 */
angular.module('httpServiceModel',[]).factory('httpService', ['$http', function($http){
	
    var service = {
            
        };

    service.getUrl = function (url) {
        console.log('/index.php/api/'+url);
        return '/index.php/api/'+url;
    }
    // build the api and return it
    return service;

}]);