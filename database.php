<?php 

    // Hooks WP
//register_deactivation_hook( __FILE__ , 'remove_tables' );
//register_activation_hook( __FILE__ , 'installDB' );

function installDB () {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;

	$table_name = $wpdb->prefix . 'muelle_status';

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
		$charset_collate = $wpdb->get_charset_collate();
		$sql =  "CREATE TABLE $table_name (`id` int(3) NOT NULL,
                `motonave` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
                `muelle_actual` int(5) DEFAULT NULL,
                `orientacion` int(5) DEFAULT NULL,
                `fecha_atrac` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
                `hora` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `agente` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
                `client_princp` varchar(99) COLLATE utf8_spanish_ci DEFAULT NULL,
                `producto` varchar(99) COLLATE utf8_spanish_ci DEFAULT NULL,
                `eslora` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `calado` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `ton_anun` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `ton_desc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `ton_acum` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `sal-motonave` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `responsable` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
                `actualizacion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL) $charset_collate;" ;

		dbDelta( $sql );
		$sql = "ALTER TABLE $table_name ADD PRIMARY KEY (`id`);";
		$wpdb->query($sql);
		$sql = "ALTER TABLE $table_name MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;";
		$wpdb->query($sql);
	}
}
function remove_tables(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'muelle_status';
    $sql = "DROP table IF EXISTS $table_name";
	$wpdb->query($sql);
}


  
?>