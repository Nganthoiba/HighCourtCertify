
/*
 * 
 * Data structure of args
 * 
 * {
 *      "url"   :   "http://something.com",
 *      "param" :   "param1=1&param2=2",
 *      "type"  :   "JSON",
 *      "method":   "GET/POST/PUT/DELETE"
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
    

    var result;
    $.ajax({
        async: false,
        url: url,
        method: method,
        data: param,
        dataType: type,
        beforeSend: function(xhr){
            //var csrf_token = document.getElementById("csrf_token").value;//getCookie("csrf_token");
            //alert(csrf_token);
            //xhr.setRequestHeader('Authorization', csrf_token);
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
function getFormDataToJson(form){
    var obj = {};
    var curr_key = "";//current key
    var curr_val = "";//current value
    var prev_key = [];//previous keys
    var array_val = [];
    var checkbox_arr = [];
    var current_element;
    for(var i=0;i<form.elements.length;i++){
        current_element = form.elements[i];
        if((current_element.type).toLowerCase()!=="submit" && (current_element.type).toLowerCase()!=="button"){
            
            curr_key = current_element.name.trim().replace("[]","");
            curr_val = current_element.value.trim();
            
            if(prev_key.includes(curr_key)){
                //If current key already encountered in the prevoius key list, then
                
                //For checkbox with same key name
                if((current_element.type).toLowerCase()==="checkbox"){
                    if(current_element.checked === true){
                        checkbox_arr.push(curr_val);
                    }
                    if(!Array.isArray(obj[curr_key])){
                        if(!checkbox_arr.includes(obj[curr_key])){
                            checkbox_arr.push(obj[curr_key]);
                        }
                    }
                    obj[curr_key]=checkbox_arr;
                    
                }
                else if((current_element.type).toLowerCase() === "radio"){
                    if(current_element.checked === true){
                        obj[curr_key]= curr_val;
                    }
                }
                else{
                    array_val.push(curr_val);
                    obj[curr_key]=array_val;
                }
                
            }
            else{
                obj[curr_key]= curr_val;
            }
            prev_key.push(curr_key);//adding the current key
        }
    }
    /*
    form.forEach((value, key) => {
        // Reflect.has in favor of: object.hasOwnProperty(key)
        if(!Reflect.has(obj, key)){
            obj[key] = value;
            return;
        }
        if(!Array.isArray(obj[key])){
            obj[key] = [obj[key]];    
        }
        obj[key].push(value);
    });
    */
    return obj;
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
