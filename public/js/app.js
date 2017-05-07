/***
         * Add jquery validation plugin method for a valid password
         *
         * Valid passwords contain atleast one letter and one number
         */
        $.validator.addMethod("validPassword", 
            function (value, element, param) {
                // body...
                if (value != ''){
                    if (value.match(/.*[a-z]+.*/i) == null){
                        return false;
                    }

                    if (value.match(/.*\d+.*/) == null){
                        return false;
                    }

                    return true;
                }
            }, 'Must contain atleast one letter and one number');