(function() {
    'use strict';
    /**
     * [app Defined module as patchables]
     */
    var app = angular.module('contactsApp',[
        'contactsModel',
        'pusherServiceModel',
        'ngSanitize',
        'ui.bootstrap',
    ]);
    //
    app.config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    /**
     * Initializes controller for patch cables module.
     */
    app.controller('contactsController', [
        '$scope','$http', '$window', '$interval','pusherService', 'Contact', ContactsController
    ]);
    
    function ContactsController(scope, $http, $window, $interval, pusherService, Contact) {
        
        scope.state ={};
        scope.contact = Contact;
        scope.contacts;
        scope.contactForm = Contact.contactForm;
        scope.$watch('scope.contacts',function(){
            console.log('scope.contacts: changed');
            Contact.contactList = scope.contacts;
        },true);

        
        /**********Initializes Pusher**************/
        pusherSubscription();
        /*****************/
        // scope.$watchGroup(['state.showSpinner','state.selectedItems','state.cartItems' ], function(){ 
            
        // });
        //fetching out contact list;
         LoadContactList();

         /**
          * Scope Functions
          */
        scope.deleteRecord = function (id) {
            if(confirm("Are you sure to delete this record?") ) {
                console.log(id);
            }
        };

        scope.editRecord = function (contact) {
            scope.contactForm = contact;
        };

        scope.viewRecord = function (id) {
            console.log(id);
        };

        scope.saveContactChanges = function() {
           Contact.contactForm = scope.contactForm;
           Contact.saveContactDetails().then(
                function (response) { //success

                },
                function (response) { //error

                }
            );
        }

        //definition functions
        function LoadContactList() {
            Contact.getContacts().then(
                function(response){
                    console.log("ok response received");
                    scope.contacts = response.data;
                },
                function(response){
                    console.log('there is something wrong please review');
                    return {};
                }

            );
        }

        function pusherSubscription() {
            var pusher = pusherService.initlizePusherObject();

            var channel = pusher.subscribe('contacts-channel');
            
            channel.bind('pusher:subscription_succeeded', function(){
                console.log('subscription completed');
            });

            channel.bind('contact-updated', function(data) {
                console.log(data.contact);
                scope.contacts = Contact.parseContact(scope.contacts, data.contact);
            });
        }
    }
})();
