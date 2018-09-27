<?php

/*
██████╗ ██████╗  ██████╗      ██╗███████╗ ██████╗████████╗
██╔══██╗██╔══██╗██╔═══██╗     ██║██╔════╝██╔════╝╚══██╔══╝
██████╔╝██████╔╝██║   ██║     ██║█████╗  ██║        ██║
██╔═══╝ ██╔══██╗██║   ██║██   ██║██╔══╝  ██║        ██║
██║     ██║  ██║╚██████╔╝╚█████╔╝███████╗╚██████╗   ██║
╚═╝     ╚═╝  ╚═╝ ╚═════╝  ╚════╝ ╚══════╝ ╚═════╝   ╚═╝
 */

//Pushes
const GENERIC_PUSH_1 = 1;
const FILE_REMINDER_PUSH_2 = 2;

const TOTAL_STORAGE_FOR_FREE_USERS_IN_BYTES = 5 * 1024 * 1024 * 1024; //5GB
const FREE_USERS_STORAGE_IN_BYTES_TO_ALERT_THE_USER = 5 * 1024 * 1024; //5MB
const DAYS_TO_DELETE_A_FILE_INSIDE_TRASH = 1;

const FREE_SUSBSCRIPTION_0 = 0;
const FREEMIUM_SUSBSCRIPTION_1 = 1;
const PREMIUM_SUSBSCRIPTION_2 = 2;

const CREATE_FAKE_FILES = false;

/*
█████╗ ███████╗███████╗███████╗████████╗███████╗
██╔══██╗██╔════╝██╔════╝██╔════╝╚══██╔══╝██╔════╝
███████║███████╗███████╗█████╗     ██║   ███████╗
██╔══██║╚════██║╚════██║██╔══╝     ██║   ╚════██║
██║  ██║███████║███████║███████╗   ██║   ███████║
╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝   ╚═╝   ╚══════╝
*/

const USER_PHOTOS_DIRECTORY = 'photos/users/';
const USER_FILES_DIRECTORY = 'files/';
const ICONS_DIRECTORY = 'icons/';
const NOTIFICATION_IMAGES_DIRECTORY = 'photos/notifications/';

/*
███████╗██╗      █████╗  ██████╗ ███████╗
██╔════╝██║     ██╔══██╗██╔════╝ ██╔════╝
█████╗  ██║     ███████║██║  ███╗███████╗
██╔══╝  ██║     ██╔══██║██║   ██║╚════██║
██║     ███████╗██║  ██║╚██████╔╝███████║
╚═╝     ╚══════╝╚═╝  ╚═╝ ╚═════╝ ╚══════╝
*/

//CheckHeaders middleware status
const CHECK_HEADERS_MIDDLEWARE = true;

//Show the first message when a validation fail
const SHOW_FIRST_MESSAGE_IN_VALIDATION = true;

//Deploy modes
const WEBHOOK_DEPLOY = 0;
const AUTO_DEPLOY = 1;

//User must verify an email to login
const USER_MUST_VERIFY_EMAIL = true;

//User can have multiple push tokens to notify different devices
const USER_HAS_MULTIPLE_PUSH_TOKENS = true;

/*
██╗   ██╗███████╗███████╗██████╗ ███████╗
██║   ██║██╔════╝██╔════╝██╔══██╗██╔════╝
██║   ██║███████╗█████╗  ██████╔╝███████╗
██║   ██║╚════██║██╔══╝  ██╔══██╗╚════██║
╚██████╔╝███████║███████╗██║  ██║███████║
 ╚═════╝ ╚══════╝╚══════╝╚═╝  ╚═╝╚══════╝
*/

const GENERIC_USER = 0;
const ROOT_USER = 1;
const ADMIN_USER = 2;
const CONSULTANT_USER = 3;

//User login/registration type
const MAIL_USER = 1;
const FACEBOOK_USER = 2;
const GOOGLE_USER = 3;

/***
 * ██████╗  █████╗ ███████╗███████╗██████╗  ██████╗ ██████╗ ████████╗
 * ██╔══██╗██╔══██╗██╔════╝██╔════╝██╔══██╗██╔═══██╗██╔══██╗╚══██╔══╝
 * ██████╔╝███████║███████╗███████╗██████╔╝██║   ██║██████╔╝   ██║
 * ██╔═══╝ ██╔══██║╚════██║╚════██║██╔═══╝ ██║   ██║██╔══██╗   ██║
 * ██║     ██║  ██║███████║███████║██║     ╚██████╔╝██║  ██║   ██║
 * ╚═╝     ╚═╝  ╚═╝╚══════╝╚══════╝╚═╝      ╚═════╝ ╚═╝  ╚═╝   ╚═╝
 */

//Token and refresh token expiration time (minutes * hours * days * years)
const TOKEN_EXPIRES = true;
const ACCESS_TOKEN_EXPIRATION_MINUTES = 60 * 24 * 1;
const ACCESS_TOKEN_REFRESHING_MINUTES = 60 * 24 * 30;

//HTTP code errors
const EXPIRED_TOKEN = 0;
const EXPIRED_REFRESH_TOKEN = 1;

//Username for passport
const OAUTH_MAIL_USER_USERNAME_FIELD = 'email';
const OAUTH_FACEBOOK_USER_USERNAME_FIELD = 'id';
const OAUTH_GOOGLE_USER_USERNAME_FIELD = 'id';

//Password for passport
const OAUTH_MAIL_USER_PASSWORD_FIELD = 'password';
const OAUTH_FACEBOOK_USER_PASSWORD_FIELD = 'facebook_id';
const OAUTH_GOOGLE_USER_PASSWORD_FIELD = 'google_id';

//Show swagger refreshing route as deprecated if token doesn't expire
define('SWAGGER_REFRESH_TOKEN_ROUTE', !TOKEN_EXPIRES);

/***
 * █████╗ ██████╗ ██╗
 * ██╔══██╗██╔══██╗██║
 * ███████║██████╔╝██║
 * ██╔══██║██╔═══╝ ██║
 * ██║  ██║██║     ██║
 * ╚═╝  ╚═╝╚═╝     ╚═╝
 */

//Environments
const LOCAL_ENVIRONMENT = 'local';
const DEVELOPMENT_ENVIRONMENT = 'develop';
const TESTING_ENVIRONMENT = 'testing';
const STAGING_ENVIRONMENT = 'staging';
const PRODUCTION_ENVIRONMENT = 'production';

//Language and timezone
const API_DEFAULT_LANGUAGE = 'es';
const API_DEFAULT_TIMEZONE = 'Europe/Madrid';
const API_DEFAULT_LANGUAGES = ['es', 'en'];

//OS's
const ANDROID_OS = 1;
const IOS_OS = 2;
const OTHER_OS = 0;

const ANDROID_OS_DESCRIPTION = 'Android';
const IOS_OS_DESCRIPTION = 'iOS';

//Genders
const USER_MAN_GENDER = 1;
const USER_WOMAN_GENDER = 2;

//Pagination
const API_QUERY_RESULTS_PER_PAGE = 64;

//Headers
const API_KEY_HEADER = 'apiKey';
const LANGUAGE_HEADER = 'Language';
const APP_VERSION_HEADER = 'appVersion';
const OS_HEADER = 'os';

//HTTP response codes
const HTTP_CODE_200_OK = 200;
const HTTP_CODE_201_OK_CREATED = 201;
const HTTP_CODE_202_OK_ACCEPTED = 202;
const HTTP_CODE_400_BAD_REQUEST = 400;
const HTTP_CODE_401_UNAUTHORIZED = 401;
const HTTP_CODE_402_PAYMENT_REQUIRED = 402;
const HTTP_CODE_403_FORBIDDEN = 403;
const HTTP_CODE_404_NOT_FOUND = 404;
const HTTP_CODE_409_CONFLICT = 409;
const HTTP_CODE_422_UNPROCESSABLE_ENTITY = 422;
const HTTP_CODE_426_UPGRADE_REQUIRED = 426;
const HTTP_CODE_429_TOO_MANY_REQUESTS = 429;
const HTTP_CODE_500_INTERNAL_SERVER_ERROR = 500;
const HTTP_CODE_503_SERVICE_UNAVAILABLE = 503;

//API Docs: Title
define('API_DOCS_TITLE', env('APP_NAME') . ' Api Docs');

//API Docs: Show the apikey in local or development environment
define('API_KEY', in_array(env('APP_ENV'), [LOCAL_ENVIRONMENT, DEVELOPMENT_ENVIRONMENT]) ? env('APP_KEY') : '');

/*
 ██████╗ ██████╗ ██████╗ ██╗███████╗███████╗
██╔════╝██╔═══██╗██╔══██╗██║██╔════╝██╔════╝
██║     ██║   ██║██████╔╝██║█████╗  ███████╗
██║     ██║   ██║██╔═══╝ ██║██╔══╝  ╚════██║
╚██████╗╚██████╔╝██║     ██║███████╗███████║
 ╚═════╝ ╚═════╝ ╚═╝     ╚═╝╚══════╝╚══════╝
*/

const SERVER_ERROR = 'SERVER_ERROR';
const NO_API_KEY = 'NO_API_KEY';
const NO_APP_VERSION = 'NO_APP_VERSION';
const APP_IN_MAINTENANCE = 'APP_IN_MAINTENANCE';
const APP_VERSION_OUTDATED = 'APP_VERSION_OUTDATED';
const UNAUTHORIZED_REQUEST = 'UNAUTHORIZED_REQUEST';
const TOO_MANY_LOGIN_ATTEMPTS = 'TOO_MANY_LOGIN_ATTEMPTS';
const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
const RESOURCE_CONFLICT = 'RESOURCE_CONFLICT';
const VALIDATION_FAILS = 'VALIDATION_FAILS';

//Language codes to use as copies
const LANGUAGES = [
    'es' => 'LANGUAGE_SPANISH_ES',
    'ca' => 'LANGUAGE_CATALAN_CA',
    'gl' => 'LANGUAGE_GALICIAN_GL',
    'en' => 'LANGUAGE_ENGLISH_EN',
    'it' => 'LANGUAGE_ITALIAN_IT',
    'pt' => 'LANGUAGE_PORTUGUESE_PT',
    'de' => 'LANGUAGE_GERMAN_DE',
    'fr' => 'LANGUAGE_FRENCH_FR',
    'ru' => 'LANGUAGE_RUSSIAN_RU',
    'ja' => 'LANGUAGE_JAPANESE_JA',
    'zh' => 'LANGUAGE_CHINESE_ZH',
    'aa' => 'LANGUAGE_AFAR_AA',
    'ab' => 'LANGUAGE_ABKHAZIAN_AB',
    'af' => 'LANGUAGE_AFRIKAANS_AF',
    'am' => 'LANGUAGE_AMHARIC_AM',
    'ar' => 'LANGUAGE_ARABIC_AR',
    'as' => 'LANGUAGE_ASSAMESE_AS',
    'ay' => 'LANGUAGE_AYMARA_AY',
    'az' => 'LANGUAGE_AZERBAIJANI_AZ',
    'ba' => 'LANGUAGE_BASHKIR_BA',
    'be' => 'LANGUAGE_BYELORUSSIAN_BE',
    'bg' => 'LANGUAGE_BULGARIAN_BG',
    'bh' => 'LANGUAGE_BIHARI_BH',
    'bi' => 'LANGUAGE_BISLAMA_BI',
    'bn' => 'LANGUAGE_BENGALI_BN',
    'bo' => 'LANGUAGE_TIBETAN_BO',
    'br' => 'LANGUAGE_BRETON_BR',
    'co' => 'LANGUAGE_CORSICAN_CO',
    'cs' => 'LANGUAGE_CZECH_CS',
    'cy' => 'LANGUAGE_WELSH_CY',
    'da' => 'LANGUAGE_DANISH_DA',
    'dz' => 'LANGUAGE_BHUTANI_DZ',
    'el' => 'LANGUAGE_GREEK_EL',
    'eo' => 'LANGUAGE_ESPERANTO_EO',
    'et' => 'LANGUAGE_ESTONIAN_ET',
    'eu' => 'LANGUAGE_BASQUE_EU',
    'fa' => 'LANGUAGE_PERSIAN_FA',
    'fi' => 'LANGUAGE_FINNISH_FI',
    'fj' => 'LANGUAGE_FIJI_FJ',
    'fo' => 'LANGUAGE_FAEROESE_FO',
    'fy' => 'LANGUAGE_FRISIAN_FY',
    'ga' => 'LANGUAGE_IRISH_GA',
    'gd' => 'LANGUAGE_SCOTS_GD',
    'gn' => 'LANGUAGE_GUARANI_GN',
    'gu' => 'LANGUAGE_GUJARATI_GU',
    'ha' => 'LANGUAGE_HAUSA_HA',
    'hi' => 'LANGUAGE_HINDI_HI',
    'hr' => 'LANGUAGE_CROATIAN_HR',
    'hu' => 'LANGUAGE_HUNGARIAN_HU',
    'hy' => 'LANGUAGE_ARMENIAN_HY',
    'ia' => 'LANGUAGE_INTERLINGUA_IA',
    'ie' => 'LANGUAGE_INTERLINGUE_IE',
    'ik' => 'LANGUAGE_INUPIAK_IK',
    'in' => 'LANGUAGE_INDONESIAN_IN',
    'is' => 'LANGUAGE_ICELANDIC_IS',
    'iw' => 'LANGUAGE_HEBREW_IW',
    'ji' => 'LANGUAGE_YIDDISH_JI',
    'jw' => 'LANGUAGE_JAVANESE_JW',
    'ka' => 'LANGUAGE_GEORGIAN_KA',
    'kk' => 'LANGUAGE_KAZAKH_KK',
    'kl' => 'LANGUAGE_GREENLANDIC_KL',
    'km' => 'LANGUAGE_CAMBODIAN_KM',
    'kn' => 'LANGUAGE_KANNADA_KN',
    'ko' => 'LANGUAGE_KOREAN_KO',
    'ks' => 'LANGUAGE_KASHMIRI_KS',
    'ku' => 'LANGUAGE_KURDISH_KU',
    'ky' => 'LANGUAGE_KIRGHIZ_KY',
    'la' => 'LANGUAGE_LATIN_LA',
    'ln' => 'LANGUAGE_LINGALA_LN',
    'lo' => 'LANGUAGE_LAOTHIAN_LO',
    'lt' => 'LANGUAGE_LITHUANIAN_LT',
    'lv' => 'LANGUAGE_LATVIAN_LV',
    'mg' => 'LANGUAGE_MALAGASY_MG',
    'mi' => 'LANGUAGE_MAORI_MI',
    'mk' => 'LANGUAGE_MACEDONIAN_MK',
    'ml' => 'LANGUAGE_MALAYALAM_ML',
    'mn' => 'LANGUAGE_MONGOLIAN_MN',
    'mo' => 'LANGUAGE_MOLDAVIAN_MO',
    'mr' => 'LANGUAGE_MARATHI_MR',
    'ms' => 'LANGUAGE_MALAY_MS',
    'mt' => 'LANGUAGE_MALTESE_MT',
    'my' => 'LANGUAGE_BURMESE_MY',
    'na' => 'LANGUAGE_NAURU_NA',
    'ne' => 'LANGUAGE_NEPALI_NE',
    'nl' => 'LANGUAGE_DUTCH_NL',
    'no' => 'LANGUAGE_NORWEGIAN_NO',
    'oc' => 'LANGUAGE_OCCITAN_OC',
    'om' => 'LANGUAGE_AFAN_OM',
    'pa' => 'LANGUAGE_PUNJABI_PA',
    'pl' => 'LANGUAGE_POLISH_PL',
    'ps' => 'LANGUAGE_PASHTO_PS',
    'qu' => 'LANGUAGE_QUECHUA_QU',
    'rm' => 'LANGUAGE_RHAETO_RM',
    'rn' => 'LANGUAGE_KIRUNDI_RN',
    'ro' => 'LANGUAGE_ROMANIAN_RO',
    'rw' => 'LANGUAGE_KINYARWANDA_RW',
    'sa' => 'LANGUAGE_SANSKRIT_SA',
    'sd' => 'LANGUAGE_SINDHI_SD',
    'sg' => 'LANGUAGE_SANGRO_SG',
    'sh' => 'LANGUAGE_SERBO_SH',
    'si' => 'LANGUAGE_SINGHALESE_SI',
    'sk' => 'LANGUAGE_SLOVAK_SK',
    'sl' => 'LANGUAGE_SLOVENIAN_SL',
    'sm' => 'LANGUAGE_SAMOAN_SM',
    'sn' => 'LANGUAGE_SHONA_SN',
    'so' => 'LANGUAGE_SOMALI_SO',
    'sq' => 'LANGUAGE_ALBANIAN_SQ',
    'sr' => 'LANGUAGE_SERBIAN_SR',
    'ss' => 'LANGUAGE_SISWATI_SS',
    'st' => 'LANGUAGE_SESOTHO_ST',
    'su' => 'LANGUAGE_SUNDANESE_SU',
    'sv' => 'LANGUAGE_SWEDISH_SV',
    'sw' => 'LANGUAGE_SWAHILI_SW',
    'ta' => 'LANGUAGE_TAMIL_TA',
    'te' => 'LANGUAGE_TEGULU_TE',
    'tg' => 'LANGUAGE_TAJIK_TG',
    'th' => 'LANGUAGE_THAI_TH',
    'ti' => 'LANGUAGE_TIGRINYA_TI',
    'tk' => 'LANGUAGE_TURKMEN_TK',
    'tl' => 'LANGUAGE_TAGALOG_TL',
    'tn' => 'LANGUAGE_SETSWANA_TN',
    'to' => 'LANGUAGE_TONGA_TO',
    'tr' => 'LANGUAGE_TURKISH_TR',
    'ts' => 'LANGUAGE_TSONGA_TS',
    'tt' => 'LANGUAGE_TATAR_TT',
    'tw' => 'LANGUAGE_TWI_TW',
    'uk' => 'LANGUAGE_UKRAINIAN_UK',
    'ur' => 'LANGUAGE_URDU_UR',
    'uz' => 'LANGUAGE_UZBEK_UZ',
    'vi' => 'LANGUAGE_VIETNAMESE_VI',
    'vo' => 'LANGUAGE_VOLAPUK_VO',
    'wo' => 'LANGUAGE_WOLOF_WO',
    'xh' => 'LANGUAGE_XHOSA_XH',
    'yo' => 'LANGUAGE_YORUBA_YO',
    'zu' => 'LANGUAGE_ZULU_ZU',
];