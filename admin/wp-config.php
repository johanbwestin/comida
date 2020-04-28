<?php
/**
 * Baskonfiguration för WordPress.
 *
 * Denna fil används av wp-config.php-genereringsskript under installationen.
 * Du behöver inte använda webbplatsens installationsrutin, utan kan kopiera
 * denna fil direkt till "wp-config.php" och fylla i alla värden.
 *
 * Denna fil innehåller följande konfigurationer:
 *
 * * Inställningar för MySQL
 * * Säkerhetsnycklar
 * * Tabellprefix för databas
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL-inställningar - MySQL-uppgifter får du från ditt webbhotell ** //
/** Namnet på databasen du vill använda för WordPress */
define( 'DB_NAME', 'comida' );

/** MySQL-databasens användarnamn */
define( 'DB_USER', 'root' );

/** MySQL-databasens lösenord */
define( 'DB_PASSWORD', '' );

/** MySQL-server */
define( 'DB_HOST', 'localhost' );

/** Teckenkodning för tabellerna i databasen. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kollationeringstyp för databasen. Ändra inte om du är osäker. */
define('DB_COLLATE', '');

/**#@+
 * Unika autentiseringsnycklar och salter.
 *
 * Ändra dessa till unika fraser!
 * Du kan generera nycklar med {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Du kan när som helst ändra dessa nycklar för att göra aktiva cookies obrukbara, vilket tvingar alla användare att logga in på nytt.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jPwiqYLQQ.rn9lG&`=K.zcHYEK.cQ7eLChoBb2(ti~ua)T99AF5`>SOu0c%O3^}`' );
define( 'SECURE_AUTH_KEY',  'q7vQL<u=ac4/PMviwy~~@kzHr:DT@iV@S-tf @JJ-_@$v%_t#7GyeDD|j3T@jeuR' );
define( 'LOGGED_IN_KEY',    'TK(vFPbiXYL@&CD*yOvq i7E!echf $XZ`~?[P5r+/,5GPpJ_0q<&X1G?4. Fc3^' );
define( 'NONCE_KEY',        'dhSK]#F^99]c!/W@d}IH]4uXmt(TDUs2^h=ZfbN`9@LDfz0b4,ZV^+Oz<b0g(ZcS' );
define( 'AUTH_SALT',        '{5Lw!ew@)m/(A^}r?8G}pK4H/@*>v$H?<GewciJ)du8S>3&/]rv4zeZ|#$A,_E?t' );
define( 'SECURE_AUTH_SALT', '`{,&TCgp-}i?iEjZ9=WC``D4Vz6YL_b^4yXtc4{P4]gV.ec%*N+B&bmIcyD,uA4s' );
define( 'LOGGED_IN_SALT',   '<|}]iH1v0fX[e/Z8O%Z4duWpm?@H|VbNRFYJS(S%X E=-Ug9bw#Dc=sn]$A+O!ZF' );
define( 'NONCE_SALT',       'crJ^~E8?H!h,@j*U.hgu1LGPPPasf?uU$HX-(8F(KME3vo>{bHsx7xM]qRA#k;@;' );

define('JWT_AUTH_SECRET_KEY', 'secret');
define('JWT_AUTH_CORS_ENABLE', true);
/**#@-*/

/**
 * Tabellprefix för WordPress-databasen.
 *
 * Du kan ha flera installationer i samma databas om du ger varje installation ett unikt
 * prefix. Använd endast siffror, bokstäver och understreck!
 */
$table_prefix = 'wp_';

/** 
 * För utvecklare: WordPress felsökningsläge. 
 * 
 * Ändra detta till true för att aktivera meddelanden under utveckling. 
 * Det rekommenderas att man som tilläggsskapare och temaskapare använder WP_DEBUG 
 * i sin utvecklingsmiljö. 
 *
 * För information om andra konstanter som kan användas för felsökning, 
 * se dokumentationen. 
 * 
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */ 
define('WP_DEBUG', false);

/* Det var allt, sluta redigera här och börja publicera! */

/** Absolut sökväg till WordPress-katalogen. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Anger WordPress-värden och inkluderade filer. */
require_once(ABSPATH . 'wp-settings.php');