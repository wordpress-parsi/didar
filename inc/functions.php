<?php



function did_get_sku($pid) {
	if($sku = get_post_meta( $pid, "_sku", true))
		return $sku;
	$sku = "SKU_$pid";
	update_post_meta($pid, "_sku",$sku);
	return $sku;
}

function add_errorlog($order_id,$path,$params,$output){
	global $wpdb;
	$path   = esc_sql($path);
	$output = empty($output)?[]:$output;
	$params = json_encode($params,JSON_UNESCAPED_UNICODE);
	$output = json_encode($output,JSON_UNESCAPED_UNICODE);

	return $wpdb->insert("{$wpdb->prefix}didar_error",[
		'date'    =>date('Y-m-d H:i:s'),
		'order_id'=>$order_id,
		'error'   =>$output,
		'path'    =>$path,
		'params'  =>$params]);
}

function did_fix_price($price){
	$opt = get_option( 'did_option', [] );
	$price_type = isset($opt['price_type'])?$opt['price_type']:0;
	if(get_option('woocommerce_currency')=='IRT' and 'IRR' == $price_type)
		return $price*10;
	if(get_option('woocommerce_currency')=='IRR' and 'IRT' == $price_type)
		return $price/10;
	return $price;
}


function did_get_variation_id_by_sku($sku) {
	global $wpdb;

	$variation_id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT p.ID
            FROM {$wpdb->prefix}posts p
            INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
            WHERE p.post_type = 'product_variation'
            AND p.post_status = 'publish'
            AND pm.meta_key = '_sku'
            AND pm.meta_value = %s",
			$sku
		)
	);

	return $variation_id;
}

