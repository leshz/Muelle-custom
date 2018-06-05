<?php

/*
* Función para añadir una página al menú de administrador de wordpress
*/

function mapEdit_plugin_menu(){
add_menu_page(		'Tiempo Real Muelle',	
					'Muelle',				
					'administrator',		
					'muelle_form_settings-page',
					'muelle_form_settings',		
					'dashicons-admin-site'
				);	

			}
add_action('admin_menu','mapEdit_plugin_menu');

?>