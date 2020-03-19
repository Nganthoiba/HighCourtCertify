<?php
/* Redirect to default authorized page according to user role */
function redirectTo() {
    switch (Logins::getRoleName()){
        case "Admin":
            redirect("User", "viewUsers");
            break;
        default :
            //echo "default ".Logins::getRoleName();
            redirect("Application", "index");
    }
}

