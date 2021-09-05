<?php 
global $wpdb;
$table_name = $wpdb->prefix . "maestro_app_setting";
$maestro_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            ID mediumint(9) NOT NULL AUTO_INCREMENT,
            `url` varchar(500) NOT NULL,
            `access_key` varchar(100) NOT NULL,
            `hash_key` varchar(100) NOT NULL,
            `event_id` int(9) NOT NULL,
            `edition_id` int(9) NOT NULL,
            `app_edition_id` varchar(100) NOT NULL,
            `token` text NOT NULL,
            PRIMARY KEY  (ID)
    )    $charset_collate;";

    $rolesTableName = $wpdb->prefix . "maestro_speaker_roles";
    $sqlRoles = "CREATE TABLE $rolesTableName (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        `name` varchar(500) NOT NULL,
        `speaker_role_id` int(9) NOT NULL,
        `order_number` int(9) NOT NULL,
        PRIMARY KEY  (ID)
    )    $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    dbDelta( $sqlRoles );
    add_option( 'my_db_version', $maestro_db_version );
}