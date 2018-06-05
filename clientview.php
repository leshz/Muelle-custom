<?php 

function muelle_status() {
	$datainfo = createFormConsulDb();
?>
	<div class="container_muelle">
		<div class="loader">
			<div class="loading">
				<div class="sk-folding-cube">
					<div class="sk-cube1 sk-cube"></div>
					<div class="sk-cube2 sk-cube"></div>
					<div class="sk-cube4 sk-cube"></div>
					<div class="sk-cube3 sk-cube"></div>
				</div>
			</div>
		</div>
		<div class="muelle_back">
			<img src="<?php echo plugins_url( 'assets/client/img/mapa-puerto-2.png', __FILE__ ) ?>" draggable="false" />
			<div class="battleship">
			<?php
			if( $datainfo[0]['motonave'] != "" ){
				foreach ($datainfo as $ship) {
			?>
				<div class="ship <?php echo "muelle{$ship['muelle_actual']}" ;
											if($ship['orientacion']==1){
													echo" babor";
												}
												else{
													echo" estribor";
												}
											?>"
											id="<?php echo"muelle{$ship['muelle_actual']}" ;?>" >
				 <span class="tooltiptext"><?php echo $ship['motonave'];  ?></span>
				</div>
			<?php
			}
			?>
			</div>
		</div>

		<div class="container infomuelle" id ="info-ship">
		<?php
			foreach ($datainfo as $ship) { ?>
<div class="shipinfo " id="<?php echo "muelle{$ship['muelle_actual']}" ?>" >


	<?php
			if($GLOBALS['spanish']){
	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Motonave</th>
	                    <td><?php echo $ship['motonave']; ?></td>
	                </tr>
	                <tr>
	                    <th>Fecha de Atraque</th>
	                    <td><?php echo $ship['fecha_atrac']; ?></td>
	                </tr>
	                <tr>
	                    <th>Hora Atraque</th>
	                    <td><?php echo $ship['hora']; ?></td>
	                </tr>
	                <tr>
	                    <th>Agente Maritimo</th>
	                    <td><?php echo $ship['agente']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Eslora</th>
	                    <td><?php echo $ship['eslora']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Calado</th>
	                    <td><?php echo $ship['calado']; ?></td>
	                </tr>
	                <tr>
	                    <th>Atracado</th>
	                    <td><?php if ($ship['orientacion']==1){
	                    		echo "Babor";
	                    	} else if ($ship['orientacion']==2){
	                    		echo "Estribor";
	                    	} ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Operador</th>
										<td><?php echo $ship['responsable'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Clientes Principales</th>
	                    <td><?php echo $ship['client_princp']; ?></td>
	                </tr>
	                <tr>
	                    <th>Producto</th>
	                    <td><?php echo $ship['producto']; ?></td>
	                </tr>
	                <tr>
	                    <th>Tonelaje Anunciado</th>
	                    <td><?php echo $ship['ton_anun']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Tonelaje descargado día</th>
	                    <td><?php echo $ship['ton_desc']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Tonelaje Acumulado</th>
	                    <td><?php echo $ship['ton_acum']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Saldo motonave</th>
	                    <td><?php echo $ship['sal-motonave']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Atracado en Muelle #</th>
	                    <td><?php echo $ship['muelle_actual']; ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Hora y fecha de actualización</th>
										<td><?php echo $ship['actualizacion'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	</div>

	<?php
	}
	else {
	?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Motor ship</th>
	                    <td><?php echo $ship['motonave']; ?></td>
	                </tr>
	                <tr>
	                    <th>Mooring Date</th>
	                    <td><?php echo $ship['fecha_atrac']; ?></td>
	                </tr>
	                <tr>
	                    <th>Mooring Time</th>
	                    <td><?php echo $ship['hora']; ?></td>
	                </tr>
	                <tr>
	                    <th>Shipping Agent</th>
	                    <td><?php echo $ship['agente']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Length</th>
	                    <td><?php echo $ship['eslora']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Depth of Water</th>
	                    <td><?php echo $ship['calado']; ?></td>
	                </tr>
	                <tr>
	                    <th>Moorgin to</th>
	                    <td><?php if ($ship['orientacion']==1){
	                    		echo "Port";
	                    	} else if ($ship['orientacion']==2){
	                    		echo "Standboard";
	                    	} ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Operator</th>
										<td><?php echo $ship['responsable'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Main Customers</th>
	                    <td><?php echo $ship['client_princp']; ?></td>
	                </tr>
	                <tr>
	                    <th>Product</th>
	                    <td><?php echo $ship['producto']; ?></td>
	                </tr>
	                <tr>
	                    <th>Announced Tonnage</th>
	                    <td><?php echo $ship['ton_anun']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Unloader Tonnage</th>
	                    <td><?php echo $ship['ton_desc']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Accumulated Tonnage</th>
	                    <td><?php echo $ship['ton_acum']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Motorship Balance</th>
	                    <td><?php echo $ship['sal-motonave']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Mooring at dock #</th>
	                    <td><?php echo $ship['muelle_actual']; ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Last update</th>
										<td><?php echo $ship['actualizacion'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	</div>


	<?php
	}
	?>
</div>
		<?php } }
		?>
		</div>
	</div>
<?php
	wp_enqueue_style('muellecss');
	wp_enqueue_script('maskLibrary');
}

add_shortcode('muelle_status', 'muelle_status');


function getFiveLastpdf($atts){

	$attachments = get_posts(
		array(
		    'post_type' => 'attachment',
		    'posts_per_page' => $atts['val'],
		    'post_status' => null,
		    'post_mime_type' => 'application/pdf'
    	)
	);
?>
	<div class="filepicker">
	<select>

	<option value="0">
	<?php
		$txt = ($GLOBALS['spanish']) ? "Seleccione una fecha" : "Select date" ;
		echo $txt;
	?>
	</option>

<?php
	foreach ( $attachments as $attachment ) {
		$title = get_the_title($attachment);
		$title = explode(" ", $title);
			if (strnatcasecmp ($title[0] , "SITUACION") == 0 ){
				$hora = get_the_date('j \d\e\ F \d\e\ Y', $attachment);
				echo "<option value='{$attachment->guid}'>{$hora}</option>";
			}
	}
?>
	</select>
	<button>
	<?php
		$txt = ($GLOBALS['spanish']) ? "Descargar Situacion portuaria" : "Download pier status" ;
		echo $txt;
	?></button>
	</div>
<?php
}
add_shortcode('pdfselect', 'getFiveLastpdf');

?>