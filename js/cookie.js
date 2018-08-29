// Eliminar Cookie
var unsetcookie = function (key) {
    return document.cookie = key + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

var setCookie = function(key, value, time_expire = 31536000000){
    if (value==undefined || value === undefined || value == '') {
        keyValue = document.cookie.match("(^|;) ?" + key + "=([^;]*)(;|$)");
        if (keyValue) {
            return keyValue[2];
        }
        else {
            return undefined;
        }
        return false;
    }
    else{
        expires = new Date();
        expires.setTime(expires.getTime() + time_expire); // Estableces el tiempo de expiración, genius
        cookie = key + "=" + value + ";expires=" + expires.toUTCString();
        return document.cookie = cookie;    
    }
}