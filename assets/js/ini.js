$(document).ready(function(){
  $("body").on('click', 'button', function () {

      // Si el boton no tiene el atributo ajax no hacemos nada
      if ($(this).data('ajax') === undefined)
          return;

      // El metodo .data identifica la entrada y la castea al valor más correcto
      if ($(this).data('ajax') !== true)
          return;

      var form = $(this).closest("form");
      var button = $(this);
      var url = form.attr('action');

      if (button.data('confirm') !== undefined)
      {
          if (button.data('confirm') === '') {
              if (!confirm('¿Esta seguro de realizar esta acción?'))
                  return false;
          } else {
              if (!confirm(button.data('confirm')))
                  return false;
          }
      }

      if (button.data('delete') !== undefined)
      {
          if (button.data('delete') === true)
          {
              url = button.data('url');
          }
      }

      // Creamos un div que bloqueara todo el formulario
      var block = $('<div class="block-loading" />');
      form.prepend(block);

      // Alert container
      var alertContainer = form.find('.alert-container');
      alertContainer.html('');

      // Escondomes los errores
      form.find(".form-validation-failed").html('');

      form.ajaxSubmit({
          dataType: 'JSON',
          type: 'POST',
          url: url,
          success: function (r) {
              block.remove();

              if (r.response) {
                  if (!button.data('reset') !== undefined) {
                      if (button.data('reset'))
                          form.reset();
                  } else
                  {
                      form.find('input:file').val('');
                  }
              }

              // Mostrar mensaje
              if (r.message !== null) {
                  if (r.message.length > 0) {
                      var css = "";
                      if (r.response) {
                          css = "alert-success";
                      } else {
                          css = "alert-danger";
                      }

                      var message = '<div class="alert ' + css + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + r.message + '</div>';

                      if(alertContainer.length > 0){
                          alertContainer.html(message);
                      } else {
                          form.prepend(message);
                      }
                  }
              }

              // Validaciones
              if(r.errors !== null) {
                for(var e in r.errors) {
                   form.find("[data-key='" + e + "']").html(r.errors[e][0]);
                }
              }

              // Ejecutar funciones que son especificadas por el servidor
              if (r.function !== null) {
                  setTimeout(r.function, 0);
              }

              // Ejecutar funciones que son especificadas por el cliente
              if (button.data('success') !== undefined && r.response) {
                  setTimeout('{0}()'.format(button.data('success')), 0);
              }

              // Redireccionar
              if (r.href !== null) {
                  if (r.href === 'self') window.location.reload(true);
                  else redirect(r.href);
              }

              // Si el servidor retorno algo
              if (r.result !== null && button.data('result') !== undefined && r.response) {
                  var resultFunction = button.data('result') + '({0})';
                  resultFunction = resultFunction.format(JSON.stringify(r.result));
                  setTimeout(resultFunction, 0);
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {
              if (jqXHR.status === 422) {
                  for (var k in jqXHR.responseJSON) {
                      var control = form.find('.validation-message[data-target="' + k + '"]');
                      control.text(jqXHR.responseJSON[k][0]);
                      control.css('display', 'block');
                  }
              } else {
                  var message = '<div class="alert alert-warning alert-dismissable response-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorThrown + ' | <b>' + textStatus + '</b></div>';

                  if(alertContainer.length > 0){
                      alertContainer.html(message);
                  } else {
                      form.prepend(message);
                  }
              }

              block.remove();
          }
      });

      return false;
  })
})

if (!String.prototype.ucwords) {
    String.prototype.ucwords = function () {
        if(this.length > 0) {
          return this.substring(0, 1).toUpperCase() + this.substring(1, this.length);
        }
    }
}

if (!String.prototype.format) {
    String.prototype.format = function () {
        var text = this;

        for (var i = 0; i < arguments.length; i++) {
            text = text.replace("{" + i + "}", arguments[i]);
        }

        return text;
    }
}

if (!String.prototype.render) {
    String.prototype.render = function (obj) {
        var text = this;

        for (var k in obj) {
            text = text.replace("{" + k + "}", obj[k]);
        }

        return text;
    }
}

if (!Number.prototype.format) {
    Number.prototype.format = function (moneySymbol) {
        moneySymbol = moneySymbol || false;
        moneySymbol = moneySymbol ? '$' : '';

        return moneySymbol + this.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    };
}

if (!Number.prototype.padLeft) {
    Number.prototype.padLeft = function (n) {
        n = n || 0;

        var zeros = '';

        for (var i = 0; i < n; i++) {
            zeros += '0';
        }

        return zeros.substring(0, zeros.length - this.toString().length) + this.toString();
    };
}

if (!String.prototype.separateWithSpaceCapitalLetter) {
    String.prototype.separateWithSpaceCapitalLetter = function () {
        return this.replace(/([A-Z])/g, ' $1').trim();
    }
}

if (!moment.prototype.defaultFormat) {
    moment.prototype.defaultFormat = function () {
        return moment(this).format('DD/MM/YYYY');
    }
}

function mergeObjects(obj1, obj2) {
    for (var k in obj2) {
        obj1[k] = obj2[k];
    }

    return obj1;
}

function isNullOrEmpty(x) {
    if (x === undefined) return true;
    if (x === null) return true;
    if (x.toString().trim().length === 0) return true;
}

function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

jQuery.fn.reset = function () {
  $("input", $(this)).each(function(){
    var type = $(this).attr('type');

    if(type === 'checkbox' && $(this).is('checked')) {
      $(this).click();
    } else {
      $(this).val('');
    }
  })

  $("select", $(this)).val(0);
};
