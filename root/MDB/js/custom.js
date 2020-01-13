
/*
 * 
 * Data structure of args
 * 
 * {
 *      "url"   :   "http://something.com",
 *      "param" :   "param1=1&param2=2",
 *      "type"  :   "JSON",
 *      "method":   "GET/POST/PUT/DELETE"
 *      "token":   "authorization token id, e.g. login_id"
 * }
 */
function ajax_request(args)
{
    if(args.url === undefined || args.url === ""){
        var resp = {status: false, msg: "Url not found!"};
        return resp;
    }
    var url = args.url;

    var param = (args.param  === undefined)?'':args.param;

    var type = (args.type === undefined)?'JSON':args.type;
    
    var method = (args.method === undefined)?"GET":args.method;
    
    var token = (args.token === undefined)?"":args.token;
    
    var ContentType = (args.ContentType === undefined)?"application/x-www-form-urlencoded":args.ContentType;

    var result;
    $.ajax({
        async: false,
        url: url,
        type: method,
        data: param,
        dataType: type,
        contentType: ContentType,
        beforeSend: function(xhr){
            //var csrf_token = document.getElementById("csrf_token").value;//getCookie("csrf_token");
            //alert(csrf_token);
            xhr.setRequestHeader('Authorization', "Bearer "+token);
        },
        success: function(response){
            result =  response;
        },
        error: function (jqXHR, exception, errorThrown) {
            result = {};
            if (jqXHR.status === 0) {
                result['msg'] = 'Not connect.\n Verify Network.';
                result['status'] = jqXHR.status;
            } 
            else{
                result = JSON.parse(jqXHR.responseText);
            }
            
        }
    });
    return result;
}

function isNumber(event) {
    //event.preventDefault();
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
        return true;
    }
}

function isChar(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    }
    else if((key>=65 && key<=91) || (key>=97 && key<=122)){
        return true;
    }
    else {
        return false;
    }
}

function isValidEmail(email) 
{
    var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    return re.test(email);
}
//function to convert form data to json
function getFormDataAsJson(form){
    var obj = {};//json object
    var curr_element; //current element
    var curr_key = "";//current key
    var curr_val = "";//current value
    var array_val = {};//Object of array of values of same key name
    var radio_val = {};//Object of value of the last checked radio button
    
    for(var i=0;i<form.elements.length;i++){
        //check for every element in the form 
        curr_element = form.elements[i];
        if((curr_element.type).toLowerCase()!=="submit" && (curr_element.type).toLowerCase()!=="button"){
            curr_key = curr_element.name.trim();
            curr_key = curr_key.replace("[]","");
            curr_val = curr_element.value.trim();
            
            if(array_val[curr_key] === undefined){
                array_val[curr_key] = [];
            }
            if(radio_val[curr_key] === undefined){
                radio_val[curr_key] = "";
            }
            var key_name = curr_element.name.trim();
            //check if key name is of array type, which means the key name can have multiple values as an array
            if(key_name.substring(key_name.length-2, key_name.length)=="[]"){
                //For checkbox with same key name
                if((curr_element.type).toLowerCase()==="checkbox"){
                    if(curr_element.checked === true){
                        array_val[curr_key].push(curr_val);
                    }
                    obj[curr_key]=array_val[curr_key];
                }
                else{
                    if(curr_val!==""){
                        array_val[curr_key].push(curr_val);
                    }
                    obj[curr_key]=array_val[curr_key];
                }
                
            }
            else{
                if((curr_element.type).toLowerCase()==="checkbox"){
                    obj[curr_key] = (curr_element.checked === true)?curr_val:"";
                }
                else if((curr_element.type).toLowerCase() === "radio"){
                    if(curr_element.checked === true){
                        //replace last value of checked radio button with the 
                        //new value of radio button if checked
                        radio_val[curr_key] = curr_val;
                    }
                    obj[curr_key]= radio_val[curr_key];
                }
                else{
                    obj[curr_key] = curr_val;
                }
            }
        }
    }
    return obj;
}
class JsFunctions{
    constructor(function_name,params="") {
        this.function_name = function_name;
        this.params = params;
    }
}
//sweet alert confirmation
function sweeetConfirm(title, message, type,yes=null, no=null){
    swal.fire({
        title: title,
        text: message,
        type: type,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: "No, I am not sure!"
        
    }).then((result) => {
        if (result.value) {
            if(yes!==null){
                yes.function_name(yes.params);
            }
        }
        else{
            if(no!==null){
                no.function_name(no.params);
            }
        }
    });
}

// client side validation module
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
