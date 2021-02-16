'use strict';

const passwdConf = () =>
{
    var conf = doc.querySelector('form input[name="conf-passwd"]')
    var passwd = doc.querySelector('form input[name="passwd"]')

    if(conf.value !== passwd.value) {
        conf.classList.add('is--error')
        return false
    }
    else {
        conf.classList.remove('is--error')
        alert();
        return false
    }


}

