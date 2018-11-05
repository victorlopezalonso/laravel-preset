<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Default server and client copies
   |--------------------------------------------------------------------------
   |
   | These copies are used only for seeding, create custom copies using the
   | admin panel
   |
   */

    'server' => [

        /*
         * --------------------------------------------------------------------------
         * Languages
         * --------------------------------------------------------------------------
         */

        [
            "key" => "LANGUAGE_CATALAN_CA",
            "es"  => "Catalán",
            "en"  => "Catalan",
        ],
        [
            "key" => "LANGUAGE_BASQUE_EU",
            "es"  => "Euskera",
            "en"  => "Basque",
        ],
        [
            "key" => "LANGUAGE_CHINESE_ZH",
            "es"  => "Chino",
            "en"  => "Chinese",
        ],
        [
            "key" => "LANGUAGE_ENGLISH_EN",
            "es"  => "Inglés",
            "en"  => "English",
        ],
        [
            "key" => "LANGUAGE_FRENCH_FR",
            "es"  => "Francés",
            "en"  => "French",
        ],
        [
            "key" => "LANGUAGE_GALICIAN_GL",
            "es"  => "Gallego",
            "en"  => "Galician",
        ],
        [
            "key" => "LANGUAGE_GERMAN_DE",
            "es"  => "Alemán",
            "en"  => "German",
        ],
        [
            "key" => "LANGUAGE_ITALIAN_IT",
            "es"  => "Italiano",
            "en"  => "Italian",
        ],
        [
            "key" => "LANGUAGE_JAPANESE_JA",
            "es"  => "Japonés",
            "en"  => "Japanese",
        ],
        [
            "key" => "LANGUAGE_PORTUGUESE_PT",
            "es"  => "Portugués",
            "en"  => "Portuguese",
        ],
        [
            "key" => "LANGUAGE_RUSSIAN_RU",
            "es"  => "Ruso",
            "en"  => "Russian",
        ],
        [
            "key" => "LANGUAGE_SPANISH_ES",
            "es"  => "Español",
            "en"  => "Spanish",
        ],
        [
            "key" => "LANGUAGE_ARABIC_AR",
            "es"  => "Árabe",
            "en"  => "Arabian",
        ],

        /*
         * --------------------------------------------------------------------------
         * Exception Messages
         * --------------------------------------------------------------------------
         */

        [
            "key" => "SERVER_ERROR",
            "es"  => "Se ha producido un error en el servidor, por favor, inténtelo de nuevo más tarde",
            "en"  => "Service error, try again later",
        ],
        [
            "key" => "ROUTE_OR_METHOD_NOT_FOUND",
            "es"  => "Ruta o método no permitido",
            "en"  => "Route or method not allowed",
        ],
        [
            "key" => "TOO_MANY_LOGIN_ATTEMPTS",
            "es"  => "Demasiados intentos de login, vuelve a intentarlo en %1 segundos",
            "en"  => "Too many login attempts, try again after %1 seconds",
        ],
        [
            "key" => "UNAUTHORIZED_REQUEST",
            "es"  => "Permiso denegado.",
            "en"  => "Unauthorized.",
        ],
        [
            "key" => "VALIDATION_FAILS",
            "es"  => "Rellene los datos correctamente.",
            "en"  => "The given data was invalid.",
        ],

        /*
         * --------------------------------------------------------------------------
         * Error Messages
         * --------------------------------------------------------------------------
         */

        [
            "key" => "RESOURCE_NOT_FOUND",
            "es"  => "Recurso no encontrado",
            "en"  => "Resource not found",
        ],
        [
            "key" => "RESOURCE_CONFLICT",
            "es"  => "El recurso ya existe",
            "en"  => "The resource already exists",
        ],
        [
            "key" => "APP_IN_MAINTENANCE",
            "es"  => "Estamos realizando tareas de mantenimiento, disculpe las molestias",
            "en"  => "We are currently performing maintenance, sorry for the inconvenience",
        ],
        [
            "key" => "APP_VERSION_OUTDATED",
            "es"  => "Esta versión está desactualizada, descargue la nueva versión",
            "en"  => "This app version is outdated, download the new version",
        ],

        /*
         * --------------------------------------------------------------------------
         * Admin Messages
         * --------------------------------------------------------------------------
         */

        [
            "key" => "ADMIN_COPIES_UPDATE_OK",
            "es"  => "Los textos de la aplicación se han actualizado correctamente",
            "en"  => "Texts updated correctly",
        ],
        [
            "key" => "PROJECT_DEPLOYED",
            "es"  => "Se ha desplegado el último commit del repositorio, los cambios se reflejarán en un máximo de 1",
            "en"  => "Project deployed using the last commit from the repository, changes will be available within the next minute",
        ],

        /*
         * --------------------------------------------------------------------------
         * User Messages
         * --------------------------------------------------------------------------
         */

        [
            "key" => "INCORRECT_PASSWORD",
            "es"  => "La contraseña no es correcta, revise la información",
            "en"  => "Incorrect password, check your credentials",
        ],
        [
            "key" => "PASSWORD_MODIFIED",
            "es"  => "La contraseña se ha modificado correctamente",
            "en"  => "Password has been modified correctly",
        ],
        [
            "key" => "USER_LOGIN_KO",
            "es"  => "El usuario no existe, revise la información",
            "en"  => "User doesn't exists, check your credentials",
        ],
        [
            "key" => "USER_NOT_VALIDATED",
            "es"  => "Su email no ha sido confirmado, revise su correo y verifique su cuenta",
            "en"  => "Mail not verified, check your mail and verify your account",
        ],
        [
            "key" => "USER_REGISTER_CONFIRM",
            "es"  => "Se ha registrado correctamente, revise su correo y confirme su cuenta",
            "en"  => "User registered, check your mail and verify your account",
        ],
        [
            "key" => "USER_REGISTER_EXISTS",
            "es"  => "El usuario ya existe, si la información es correcta pruebe a identificarse para acceder a la app",
            "en"  => "User exists, try to login with your credentials",
        ],
        [
            "key" => "USER_REGISTER_OK",
            "es"  => "Se ha registrado correctamente",
            "en"  => "User registered",
        ],
        [
            "key" => "PASSWORD_RESET_EMAIL_SENT",
            "es"  => "Para resetear su contraseña siga las instrucciones del correo que le hemos enviado.",
            "en"  => "We've just sent you an email, follow the instructions to reset your password.",
        ],

        /*
         * --------------------------------------------------------------------------
         * Mails
         * --------------------------------------------------------------------------
         */

        [
            "key" => "USER_VERIFICATION_MAIL_SUBJECT",
            "es"  => "¡Bienvenido a %1!",
            "en"  => "Welcome to %1!",
        ],
        [
            "key" => "USER_VERIFICATION_MAIL_TITLE",
            "es"  => "¡Bienvenido %1!",
            "en"  => "Welcome %1!",
        ],
        [
            "key" => "USER_VERIFICATION_MAIL_CONTENT",
            "es"  => "Para poder usar nuestra app debes confirmar tu correo electrónico visitando el siguiente enlace.",
            "en"  => "In order to use our app you need to confirm your email by visiting the next link.",
        ],
        [
            "key" => "USER_VERIFICATION_MAIL_LINK",
            "es"  => "Haz clic aquí para confirmar tu cuenta.",
            "en"  => "Click here to confirm your account.",
        ],
        [
            "key" => "USER_RESET_MAIL_TITLE",
            "es"  => "Solicitud para reestablecer contraseña",
            "en"  => "Request for establish your password",
        ],
        [
            "key" => "USER_RESET_MAIL_CONTENT",
            "es"  => "Has recibido este email porque hemos recibido una solicitud de cambio de contraseña. Para establecer una nueva contraseña haz clic en el siguiente enlace:",
            "en"  => "You are receiving this email because we received a password reset request for your account. To set a new password click the following link:",
        ],
        [
            "key" => "USER_RESET_MAIL_LINK",
            "es"  => "Resetear contraseña",
            "en"  => "Reset password",
        ],
        [
            "key" => "USER_RESET_MAIL_FOOTER",
            "es"  => "Si no ha solicitado una nueva contraseña no haga caso de este email.",
            "en"  => "If you don't make a reset password request no further action is needed",
        ],
        [
            "key" => "USER_RESET_MAIL_BUTTON_ALTERNATIVE",
            "es"  => "Si está teniendo problemas con el botón \"Resetear contraseña\", copie y pegue esta URL en su navegador",
            "en"  => "If you’re having trouble clicking the \"Reset Password\" button, copy and paste the URL below into your web browser:",
        ],
        [
            "key" => "USER_PASSWORD_RESET_OK",
            "es"  => "Su contraseña se ha reseteado correctamente",
            "en"  => "Your password has been reset",
        ],
        [
            "key" => "USER_MAIL_NOT_VERIFIED",
            "es"  => "El link no corresponde a ningún usuario, por favor, revise su información",
            "en"  => "This link doesn't belong to any user, please check your info",
        ],
        [
            "key" => "USER_MAIL_VERIFIED",
            "es"  => "Enhorabuena %1, su email ha sido confirmado, ya puede loguearse en la app con sus credenciales.",
            "en"  => "Congratulations!!! your mail has been confirmed, now you can do login in the app using your credentials.",
        ],

        /*
         * --------------------------------------------------------------------------
         * Validations
         * --------------------------------------------------------------------------
         */

        [
            'key' => 'VALIDATION_ACCEPTED',
            'es'  => 'Se debe aceptar el parámetro :attribute',
            'en'  => 'The :attribute must be accepted.'
        ],
        [
            'key' => 'VALIDATION_ACTIVE_URL',
            'es'  => ':attribute no es una URL válida.',
            'en'  => 'The :attribute is not a valid URL.'
        ],
        [
            'key' => 'VALIDATION_AFTER',
            'es'  => ':attribute debe ser una fecha posterior a :date',
            'en'  => 'The :attribute must be a date after :date.'
        ],
        [
            'key' => 'VALIDATION_AFTER_OR_EQUAL',
            'es'  => ':attribute debe ser una fecha posterior o igual a :date',
            'en'  => 'The :attribute must be a date after or equal to :date.'
        ],
        [
            'key' => 'VALIDATION_ALPHA',
            'es'  => ':attribute sólo puede contener letras.',
            'en'  => 'The :attribute may only contain letters.'
        ],
        [
            'key' => 'VALIDATION_ALPHA_DASH',
            'es'  => ':attribute sólo puede contener letras, números y guiones bajos.',
            'en'  => 'The :attribute may only contain letters, numbers, and dashes.'
        ],
        [
            'key' => 'VALIDATION_ALPHA_NUM',
            'es'  => ':attribute sólo puede contener letras y números',
            'en'  => 'The :attribute may only contain letters and numbers.'
        ],
        [
            'key' => 'VALIDATION_ARRAY',
            'es'  => ':attribute debe ser un array.',
            'en'  => 'The :attribute must be an array.'
        ],
        [
            'key' => 'VALIDATION_BEFORE',
            'es'  => ':attribute debe ser una fecha anterior a :date.',
            'en'  => 'The :attribute must be a date before :date.'
        ],
        [
            'key' => 'VALIDATION_BEFORE_OR_EQUEAL',
            'es'  => ':attribute debe ser una fecha anterior o igual a :date',
            'en'  => 'The :attribute must be a date before or equal to :date.'
        ],
        [
            'key' => 'VALIDATION_BETWEEN_NUMERIC',
            'es'  => ':attribute debe estar entre :min y :max',
            'en'  => 'The :attribute must be between :min and :max.'
        ],
        [
            'key' => 'VALIDATION_BETWEEN_FILE',
            'es'  => ':attribute tiene que tener un mínimo de :min y un máximo de :max kilobytes.',
            'en'  => 'The :attribute must be between :min and :max kilobytes.'
        ],
        [
            'key' => 'VALIDATION_BETWEEN_STRING',
            'es'  => ':attribute debe contener entre :min y :max caracteres.',
            'en'  => 'The :attribute must be between :min and :max characters.'
        ],
        [
            'key' => 'VALIDATION_BETWEEN_ARRAY',
            'es'  => ':attribute debe contener entre :min y :max elementos.',
            'en'  => 'The :attribute must have between :min and :max items.'
        ],
        [
            'key' => 'VALIDATION_BOOLEAN',
            'es'  => ':attribute debe ser true o false.',
            'en'  => 'The :attribute field must be true or false.'
        ],
        [
            'key' => 'VALIDATION_CONFIRMED',
            'es'  => 'El campo :attribute no coincide.',
            'en'  => 'The :attribute confirmation does not match.'
        ],
        [
            'key' => 'VALIDATION_DATE',
            'es'  => ':attribute no es una fecha válida',
            'en'  => 'The :attribute is not a valid date.'
        ],
        [
            'key' => 'VALIDATION_DATE_FORMAT',
            'es'  => ':attribute no se ajusta al formato :format.',
            'en'  => 'The :attribute does not match the format :format.'
        ],
        [
            'key' => 'VALIDATION_DIFFERENT',
            'es'  => ':attribute y :other deben ser diferentes.',
            'en'  => 'The :attribute and :other must be different.'
        ],
        [
            'key' => 'VALIDATION_DIGITS',
            'es'  => ':attribute tiene que tener :digits dígitos',
            'en'  => 'The :attribute must be :digits digits.'
        ],
        [
            'key' => 'VALIDATION_DIGITS_BETWEEN',
            'es'  => ':attribute debe contener entre :min y :max dígitos.',
            'en'  => 'The :attribute must be between :min and :max digits.'
        ],
        [
            'key' => 'VALIDATION_DIMENSIONS',
            'es'  => 'Las dimensiones de :attribute no son válidas.',
            'en'  => 'The :attribute has invalid image dimensions.'
        ],
        [
            'key' => 'VALIDATION_DISTINCT',
            'es'  => 'El campo :attribute tiene un valor duplicado.',
            'en'  => 'The :attribute field has a duplicate value.'
        ],
        [
            'key' => 'VALIDATION_EMAIL',
            'es'  => ':attribute debe ser una dirección de correo electrónico válida.',
            'en'  => 'The :attribute must be a valid email address.'
        ],
        [
            'key' => 'VALIDATION_EXISTS',
            'es'  => 'El valor seleccionado en :attribute no es válido',
            'en'  => 'The selected :attribute is invalid.'
        ],
        [
            'key' => 'VALIDATION_FILE',
            'es'  => ':attribute debe ser un archivo.',
            'en'  => 'The :attribute must be a file.'
        ],
        [
            'key' => 'VALIDATION_FILLED',
            'es'  => 'El campo :attribute tiene que tener un valor.',
            'en'  => 'The :attribute field must have a value.'
        ],
        [
            'key' => 'VALIDATION_IMAGE',
            'es'  => ':attribute tiene que ser una imagen.',
            'en'  => 'The :attribute must be an image.'
        ],
        [
            'key' => 'VALIDATION_IN',
            'es'  => 'El campo :attribute no es válido.',
            'en'  => 'The selected :attribute is invalid.'
        ],
        [
            'key' => 'VALIDATION_IN_ARRAY',
            'es'  => 'El campo :attribute no existe en :other',
            'en'  => 'The :attribute field does not exist in :other.'
        ],
        [
            'key' => 'VALIDATION_INTEGER',
            'es'  => ':attribute debe ser de tipo integer.',
            'en'  => 'The :attribute must be an integer.'
        ],
        [
            'key' => 'VALIDATION_IP',
            'es'  => ':attribute debe ser una IP válida.',
            'en'  => 'The :attribute must be a valid IP address.'
        ],
        [
            'key' => 'VALIDATION_IPV4',
            'es'  => ':attribute debe ser una IPv4 válida.',
            'en'  => 'The :attribute must be a valid IPv4 address.'
        ],
        [
            'key' => 'VALIDATION_IPV6',
            'es'  => ':attribute debe ser una IPv6 válida.',
            'en'  => 'The :attribute must be a valid IPv6 address.'
        ],
        [
            'key' => 'VALIDATION_JSON',
            'es'  => ':attribute debe ser un string JSON válido',
            'en'  => 'The :attribute must be a valid JSON string.'
        ],
        [
            'key' => 'VALIDATION_MAX_NUMERIC',
            'es'  => ':attribute no puede ser mayor que :max',
            'en'  => 'The :attribute may not be greater than :max.'
        ],
        [
            'key' => 'VALIDATION_MAX_FILE',
            'es'  => ':attribute no puede contener más de :max kilobytes',
            'en'  => 'The :attribute may not be greater than :max kilobytes.'
        ],
        [
            'key' => 'VALIDATION_MAX_STRING',
            'es'  => ':attribute no puede contener más de :max caracteres.',
            'en'  => 'The :attribute may not be greater than :max characters.'
        ],
        [
            'key' => 'VALIDATION_MAX_ARRAY',
            'es'  => ':attribute no puede tener máx',
            'en'  => 'The :attribute may not have more than :max items.'
        ],
        [
            'key' => 'VALIDATION_MIMES',
            'es'  => ':attribute debe ser un archivo de tipo :values',
            'en'  => 'The :attribute must be a file of type: :values.'
        ],
        [
            'key' => 'VALIDATION_MIMETYPES',
            'es'  => ':attribute debe ser un archivo de tipo :values',
            'en'  => 'The :attribute must be a file of type: :values.'
        ],
        [
            'key' => 'VALIDATION_MIN_NUMERIC',
            'es'  => ':attribute debe ser como mínimo :min',
            'en'  => 'The :attribute must be at least :min.'
        ],
        [
            'key' => 'VALIDATION_MIN_FILE',
            'es'  => ':attribute tiene que tener un mínimo de :min kilobytes.',
            'en'  => 'The :attribute must be at least :min kilobytes.'
        ],
        [
            'key' => 'VALIDATION_MIN_STRING',
            'es'  => ':attribute debe contener un mínimo de :min caracteres.',
            'en'  => 'The :attribute must be at least :min characters.'
        ],
        [
            'key' => 'VALIDATION_MIN_ARRAY',
            'es'  => ':attribute tiene que tener al menos :min elementos.',
            'en'  => 'The :attribute must have at least :min items.'
        ],
        [
            'key' => 'VALIDATION_NOT_IN',
            'es'  => 'El campo :attribute no es válido.',
            'en'  => 'The selected :attribute is invalid.'
        ],
        [
            'key' => 'VALIDATION_NUMERIC',
            'es'  => ':attribute debe ser un número.',
            'en'  => 'The :attribute must be a number.'
        ],
        [
            'key' => 'VALIDATION_PRESENT',
            'es'  => ':attribute es obligatorio.',
            'en'  => 'The :attribute field must be present.'
        ],
        [
            'key' => 'VALIDATION_REGEX',
            'es'  => ':attribute no es válido.',
            'en'  => 'The :attribute format is invalid.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED',
            'es'  => ':attribute es obligatorio.',
            'en'  => 'The :attribute field is required.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_IF',
            'es'  => ':attribute es obligatorio cuando :other es :value',
            'en'  => 'The :attribute field is required when :other is :value.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_UNLESS',
            'es'  => 'El campo :attribute es obligatorio cuando :other no está en :values.',
            'en'  => 'The :attribute field is required unless :other is in :values.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_WITH',
            'es'  => 'El campo :attribute es obligatorio cuando :values está presente.',
            'en'  => 'The :attribute field is required when :values is present.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_WITH_ALL',
            'es'  => 'El campo :attribute es obligatorio cuando :values está presente.',
            'en'  => 'The :attribute field is required when :values is present.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_WITHOUT',
            'es'  => 'El campo :attribute es obligatorio cuando :values no está presente.',
            'en'  => 'The :attribute field is required when :values is not present.'
        ],
        [
            'key' => 'VALIDATION_REQUIRED_WITHOUT_ALL',
            'es'  => 'El campo :attribute es obligatorio cuando :values no están presentes.',
            'en'  => 'The :attribute field is required when none of :values are present.'
        ],
        [
            'key' => 'VALIDATION_SAME',
            'es'  => ':attribute y :other deben coincidir.',
            'en'  => 'The :attribute and :other must match.'
        ],
        [
            'key' => 'VALIDATION_SIZE_NUMERIC',
            'es'  => ':attribute debe ser :size.',
            'en'  => 'The :attribute must be :size.'
        ],
        [
            'key' => 'VALIDATION_SIZE_FILE',
            'es'  => ':attribute tiene que tener :size kilobytes.',
            'en'  => 'The :attribute must be :size kilobytes.'
        ],
        [
            'key' => 'VALIDATION_SIZE_STRING',
            'es'  => ':attribute tiene que tener :size caracteres.',
            'en'  => 'The :attribute must be :size characters.'
        ],
        [
            'key' => 'VALIDATION_SIZE_ARRAY',
            'es'  => ':attribute debe contener :size elementos.',
            'en'  => 'The :attribute must contain :size items.'
        ],
        [
            'key' => 'VALIDATION_STRING',
            'es'  => ':attribute debe ser de tipo string.',
            'en'  => 'The :attribute must be a string.'
        ],
        [
            'key' => 'VALIDATION_TIMEZONE',
            'es'  => ':attribute debe ser una zona válida.',
            'en'  => 'The :attribute must be a valid zone.'
        ],
        [
            'key' => 'VALIDATION_UNIQUE',
            'es'  => 'El :attribute ya existe.',
            'en'  => 'The :attribute has already been taken.'
        ],
        [
            'key' => 'VALIDATION_UPLOADED',
            'es'  => ':attribute falló al subirse.',
            'en'  => 'The :attribute failed to upload.'
        ],
        [
            'key' => 'VALIDATION_URL',
            'es'  => 'El formato de :attribute no es válido',
            'en'  => 'The :attribute format is invalid.'
        ],

        /*
         * --------------------------------------------------------------------------
         * App copies
         * --------------------------------------------------------------------------
         */

    ],
    'client' => [
        [
            "key" => "APP_NAME",
            "es"  => env('APP_NAME'),
            "en"  => env('APP_NAME'),
        ],
    ],
    'admin'  => [
        ['key' => 'ADMIN_ADD', 'es' => 'añadir', 'en' => 'add'],
        ['key' => 'ADMIN_COPY', 'es' => 'texto', 'en' => 'text'],
        ['key' => 'IMPORT_FROM_FILE', 'es' => 'importar desde archivo', 'en' => 'import from file'],
        ['key' => 'DOWNLOAD_INTO_FILE', 'es' => 'descargar a un archivo', 'en' => 'download to a file'],
        ['key' => 'ADMIN_EDIT', 'es' => 'editar', 'en' => 'edit'],
        ['key' => 'ADMIN_DELETE', 'es' => 'eliminar', 'en' => 'delete'],
        ['key' => 'ADMIN_CANCEL', 'es' => 'cancelar', 'en' => 'cancel'],
        ['key' => 'ADMIN_SAVE', 'es' => 'guardar', 'en' => 'save'],
        ['key' => 'ADMIN_NEXT_PAGE', 'es' => 'siguiente', 'en' => 'next page'],
        ['key' => 'ADMIN_PREVIOUS_PAGE', 'es' => 'anterior', 'en' => 'previous'],
        ['key' => 'ADMIN_NAME', 'es' => 'nombre', 'en' => 'name'],
        ['key' => 'ADMIN_LAST_NAME', 'es' => 'apellido', 'en' => 'last name'],
        ['key' => 'ADMIN_EMAIL', 'es' => 'email', 'en' => 'email'],
        ['key' => 'ADMIN_ADMIN', 'es' => 'admin', 'en' => 'admin'],
        ['key' => 'ADMIN_PERMISSIONS', 'es' => 'permisos', 'en' => 'permissions'],
        ['key' => 'ADMIN_USER', 'es' => 'usuario', 'en' => 'user'],
        ['key' => 'ADMIN_TITLE', 'es' => 'título', 'en' => 'title'],
        ['key' => 'ADMIN_HEADER', 'es' => 'cabecera', 'en' => 'header'],
        ['key' => 'ADMIN_CONTENT', 'es' => 'contenido', 'en' => 'content'],
        ['key' => 'ADMIN_IMAGE', 'es' => 'imagen', 'en' => 'image'],
        ['key' => 'ADMIN_CHOOSE_IMAGE', 'es' => 'Elige una imagen...', 'en' => 'Choose an image...'],
        ['key' => 'ADMIN_LINK', 'es' => 'enlace', 'en' => 'link'],
        ['key' => 'ADMIN_SEND_NOTIFICATION', 'es' => 'Enviar notificación', 'en' => 'Send notification'],
        ['key' => 'ADMIN_LINK_DESCRIPTION', 'es' => 'Url que se abrirá cuando la app reciba la notificación push', 'en' => 'Url to open when the app receives the push notification'],
        ['key' => 'ADMIN_MAINTENANCE_MODE', 'es' => 'Modo de mantenimiento', 'en' => 'Maintenance mode'],
        ['key' => 'ADMIN_YES', 'es' => 'si', 'en' => 'yes'],
        ['key' => 'ADMIN_NO', 'es' => 'no', 'en' => 'no'],
        ['key' => 'ADMIN_MAINTENANCE_WARNING', 'es' => 'Cuidado: los usuarios no podrán acceder a la app si el modo de mantenimiento está activo', 'en' => 'Attention: users will be unable to access the app when the maintenance mode is ON'],
        ['key' => 'ADMIN_ANDROID_VERSION', 'es' => 'Versión Android', 'en' => 'Android version'],
        ['key' => 'ADMIN_IOS_VERSION', 'es' => 'Versión iOS', 'en' => 'iOS version'],
        ['key' => 'ADMIN_LANGUAGES', 'es' => 'Idiomas', 'en' => 'Languages'],
        ['key' => 'ADMIN_CONTACT_MAIL', 'es' => 'Correo de contacto', 'en' => 'Contact mail'],
        ['key' => 'ADMIN_FAQ_URL', 'es' => 'FAQ url', 'en' => 'FAQ url'],
        ['key' => 'ADMIN_TERMS_USE_URL', 'es' => 'Url de términos de uso', 'en' => 'Terms of use URL'],
        ['key' => 'ADMIN_PRIVACY_URL', 'es' => 'Url de términos de privacidad', 'en' => 'Privacy URL'],
        ['key' => 'ADMIN_DEEPLINK', 'es' => 'Deeplink', 'en' => 'Deeplink'],
        ['key' => 'ADMIN_DEPLOY_FROM_REPOSITORY', 'es' => 'Desplegar el proyecto desde el repositorio', 'en' => 'Deploy project from repository'],
        ['key' => 'ADMIN_OPERATING_SYSTEMS', 'es' => 'Sistemas operativos', 'en' => 'Operating systems'],
        ['key' => 'ADMIN_GENDERS', 'es' => 'Géneros', 'en' => 'Genders'],
        ['key' => 'ADMIN_MESSAGE', 'es' => 'Mensaje', 'en' => 'Message'],
        ['key' => 'ADMIN_ACCEPT', 'es' => 'Aceptar', 'en' => 'Accept'],
        ['key' => 'ADMIN_PASSWORD', 'es' => 'Contraseña', 'en' => 'Password'],
        ['key' => 'ADMIN_SEARCH', 'es' => 'buscar', 'en' => 'search'],
        ['key' => 'SECTION_HOME', 'es' => 'Inicio', 'en' => 'Home'],
        ['key' => 'SECTION_SETTINGS', 'es' => 'Configuraciones', 'en' => 'Settings'],
        ['key' => 'SECTION_COPIES', 'es' => 'Copies', 'en' => 'Copies'],
        ['key' => 'SECTION_VARIABLES', 'es' => 'Variables', 'en' => 'Variables'],
        ['key' => 'SECTION_USERS', 'es' => 'Usuarios', 'en' => 'Users'],
    ],
];