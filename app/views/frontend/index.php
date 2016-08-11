<?php use App\Helpers\Url; ?>
function AnexMailing(config) {
    'use strict';

    if (config === undefined) {
        throw 'Debe inicializar la configuración del componente';
    }

    if (config.email === undefined) {
        throw 'Debe especificar el ID para el contenedor Email';
    }

    var self = this,
        cookie = {
            name: 'am-suscribed',
            timeLife: 720 // minutes
        },
        isRequesting = false;

    if(config.cookie !== undefined) {
        if(config.cookie.name !== undefined) {
            cookie.name += '-' + config.cookie.name;
        }

        if(config.cookie.timeLife !== undefined) {
            cookie.timeLife = config.cookie.timeLife;
        }
    }

    // Parameters to send
    this.email = document.getElementById(config.email);
    this.name = config.name === undefined ? null : document.getElementById(config.name);
    this.relation = config.relation === undefined ? null : config.relation;

    // Callbacks
    this.done = config.done || null;

    // Is ready to work?
    this.check = function() {
        console.log({
            email: self.email,
            name: self.name,
            relation: self.relation,
        });
    }

    // Ajax Request
    this.send = function() {
        if(isRequesting) {
            return;
        }
        
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4) {
                isRequesting = false;
                switch(xhttp.status){
                    case 200:
                        var result = JSON.parse(xhttp.responseText),
                            type = 'error';

                        if(result.result === 'exists') {
                            result.response = true;
                        }

                        if(result.response) {
                            type = 'success';
                            markAsSubscribed();
                        } else if(result.errors !== null) {
                            type = 'validation';
                        }

                        if(self.done !== null) {
                            self.done(type, result);
                        } 
                        break;
                    default:
                        if(self.done !== null) {
                            self.done(type, result);
                        } 
                        break;
                }
            }
        };

        xhttp.open('POST', '<?php echo Url::getBase('frontend/add'); ?>', true);
        xhttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        xhttp.send(
            'token={0}&email={1}&name={2}&relation={3}'.format(
                '<?php echo $token; ?>',
                self.email.value,
                self.name === null ? '' : self.name.value,
                self.relation === null ? '' : self.relation.value
            )
        );
        
        isRequesting = true;
    }

    // Cookie helper
    function markAsSubscribed() {
        var d = new Date();
        d.setTime(d.getTime() + (cookie.timeLife*60*1000));
        var expires = 'expires={0}'.format(d.toUTCString());
        document.cookie = '{0}=1;{2}'.format(cookie.name, expires);
    }

    self.isSuscribed = function(){
        var name = cookie.name + "=";
        var ca = document.cookie.split(';');

        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];

            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return true;
            }
        }

        return false;
    }

    // Credit
    this.credit = function() {
        console.log('<?php echo sprintf('%s: %s by Anexsoft - http://anexsoft.com', $config->productName, $config->productVersion); ?>');
    }

    if (!String.prototype.format) {
        String.prototype.format = function() {
            var text = this;

            for (var i = 0; i < arguments.length; i++) {
                text = text.replace("{" + i + "}", arguments[i]);
            }

            return text;
        }
    }
}