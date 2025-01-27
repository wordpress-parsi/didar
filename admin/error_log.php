<div class="wrap">
	<h2><?php esc_attr_e('Error log', 'didar'); ?></h2>
	<style>
		table tr td pre{
			max-height: 250px; /* Set maximum height */
    		overflow-y: auto;  /* Enable vertical scrolling */
    		max-width: 300px;
			line-height: 1.5;
		}
	</style>
	<form method="post" enctype="multipart/form-data">
		<table class="widefat striped" style="max-width:100%;">
			<thead>
				<tr>
					<th><?php esc_attr_e('Order ID', 'didar'); ?></th>
					<th><?php esc_attr_e('Error date', 'didar'); ?></th>
					<th><?php esc_attr_e('Error request', 'didar'); ?></th>
					<th><?php esc_attr_e('Params', 'didar'); ?></th>
					<th><?php esc_attr_e('Response', 'didar'); ?></th>
				</tr>
			</thead>
			<body>
				<?php
				/*$ver = didar_api::get_custom_fields();
				var_dump($ver);*/
				global $wpdb;
				$paging = '';
				$rows   = $wpdb->get_results( "select * from {$wpdb->prefix}didar_error order by id desc" );
				if(!empty($rows)){
					$url = admin_url();
					$paging = did_paging($rows,20);
					foreach($rows as $row){
						?><tr>
							<td><?php echo $row->order_id; ?></td>
							<td><bdi><?php echo $row->date;?><bdi></td>
							<td><bdi><?php echo $row->date;?><bdi></td>
							<td><?php echo $row->path;?></td>
							<td><pre dir="ltr"><?php print_r(json_decode($row->params,true));?><pre></td>
							<td><pre dir="ltr"><?php print_r(json_decode($row->error));?><pre></td>
						</tr>
						<?php
					}
				}
				?>
			</body>
		</table>
		<?php echo $paging; ?>
	</form>
</div>