/**
 * Created by:  Muhammad Basit Munir
 * Date: 11 November 2016.
 * Description: 
 */
angular.module('contactsModel',['httpServiceModel']).factory('Contact', ['$http', 'httpService', function($http, httpService){
	
    var Contact = {
            contactList: [],
            contactForm: {
                contact_id: '',
                email: '',
                name: '',
                user_id:'',
                phone_number:''
            }
        };
    
    Contact.getContacts = function () {
       return $http.get(httpService.getUrl('contacts'));       
    };

    Contact.getContactDetails = function (contactID) {
        return $http.get(httpService.getUrl('contact/'+contactID));
    }

    Contact.saveContactDetails = function () {
        return $http.post(httpService.getUrl('save_contact'), Contact.contactForm);
    }

    Contact.parseContact = function(contactList, reCon) {
         contactList.filter(function(contact){
            if(contact.contact_id == reCon.contact_id) {
                contact = reCon;
            }
         });
        return contactList;
    }

    // build the api and return it
    return Contact;

}]);