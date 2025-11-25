/*!
  assets/js/validaciones.js
  - Monitorea el envío de formularios (productos y categorías).
  - Valida que los campos required no sean solo espacios en blanco.
  - Si hay campos inválidos:
      * Muestra una alerta con los campos que están mal
      * Inserta debajo de cada campo inválido: "Joaquín Rana Pallero"
  Requisitos:
    - Incluir jQuery antes de este archivo en la página.
*/

(function ($) {
  'use strict';

  // Nombre a mostrar debajo de cada campo inválido
  var AUTHOR_NAME = 'Joaquín Rana Pallero';

  // Clases / selectores utilizados por el script
  var AUTHOR_CLASS = 'validation-author-text';
  var INVALID_FIELD_CLASS = 'validation-invalid-field';

  // Devuelve texto legible para el campo (label asociado, data-label, name o id)
  function getLabelText($field) {
    var id = $field.attr('id');
    if (id) {
      var $label = $('label[for="' + id + '"]');
      if ($label.length) {
        return $.trim($label.first().text());
      }
    }
    if ($field.attr('data-label')) {
      return $field.attr('data-label');
    }
    if ($field.attr('name')) {
      return $field.attr('name');
    }
    if ($field.attr('id')) {
      return $field.attr('id');
    }
    return 'Campo sin nombre';
  }

  // Limpia mensajes previos
  function clearPreviousMessages($form) {
    $form.find('.' + AUTHOR_CLASS).remove();
    $form.find('.' + INVALID_FIELD_CLASS).removeClass(INVALID_FIELD_CLASS);
  }

  // Inserta el nombre debajo del campo inválido
  function insertAuthorBelow($field) {
    var $msg = $('<div>')
      .addClass(AUTHOR_CLASS)
      .text(AUTHOR_NAME)
      .css({
        'color': '#b30000',
        'font-size': '0.9em',
        'margin-top': '4px'
      });
    $field.addClass(INVALID_FIELD_CLASS);
    $field.after($msg);
  }

  // Detecta si valor es sólo espacios en blanco
  function isBlank(value) {
    return $.trim(String(value || '')) === '';
  }

  // Handler principal: valida un formulario
  function validateFormOnSubmit(e) {
    var $form = $(this);

    // Sólo intervenir en formularios marcados para validar o con ids habituales.
    var shouldValidate =
      $form.is('[data-validate="true"]') ||
      $form.is('#form-producto') ||
      $form.is('#form-categoria') ||
      $form.is('#form-productos') ||
      $form.is('#form-categorias');

    if (!shouldValidate) {
      return; // no es formulario objetivo
    }

    clearPreviousMessages($form);

    // Seleccionar campos a validar:
    // - inputs, textareas, selects que tengan el atributo required
    // - o tengan la clase .validate-required
    var $fields = $form.find('input[required], textarea[required], select[required]').add(
      $form.find('.validate-required')
    );

    var invalidFields = [];

    $fields.each(function () {
      var $f = $(this);

      // Se omiten campos ocultos (type=hidden)
      if ($f.is('[type="hidden"]')) {
        return;
      }

      // Para checkboxes/radios: validar si alguno seleccionado cuando es required
      if ($f.is('[type="checkbox"], [type="radio"]')) {
        var name = $f.attr('name');
        if (name) {
          if ($form.find('input[name="' + name + '"]:checked').length === 0) {
            invalidFields.push(getLabelText($f));
            // marcar el primer elemento de ese grupo
            insertAuthorBelow($f.closest('.form-group').length ? $f.closest('.form-group') : $f);
          }
        }
        return;
      }

      var val = $f.val();
      if (isBlank(val)) {
        invalidFields.push(getLabelText($f));
        insertAuthorBelow($f);
      }
    });

    if (invalidFields.length > 0) {
      e.preventDefault();
      // Alerta con la lista de campos inválidos
      var message = 'Los siguientes campos no pueden estar vacíos o contener sólo espacios en blanco:\n\n';
      for (var i = 0; i < invalidFields.length; i++) {
        message += '- ' + invalidFields[i] + '\n';
      }
      message += '\nPor favor, completá correctamente los campos indicados.';
      alert(message);

      // Scroll al primer campo inválido si existe
      var $firstInvalid = $form.find('.' + AUTHOR_CLASS).first();
      if ($firstInvalid.length) {
        $('html, body').animate({ scrollTop: $firstInvalid.offset().top - 60 }, 300);
      }
    }
  }

  // Inicialización
  $(function () {
    // Limpia mensajes previamente añadidos en carga (por si recargan la página)
    $('form').each(function () {
      clearPreviousMessages($(this));
    });

    // Enlazar evento submit en todos los formularios (comprobación condicional dentro)
    $(document).on('submit', 'form', validateFormOnSubmit);
  });
})(jQuery);