<?php
/**
 * Plugin Name: Get Individual CC Data
 * Description: API to fetch credit card data from the MySQL database
 * Version: 1.0
 * Author: Your Name
 */


// Our function to register new API endpoint
function get_individual_cc_data_register_routes() {
    register_rest_route('get-individual-cc-data/v1', '/cc_data/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_individual_cc_data_callback',
        'args' => array(
            'card_name' => array(
                'required' => true,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}

add_action('rest_api_init', 'get_individual_cc_data_register_routes');

// Our callback function that will handle the request
function get_individual_cc_data_callback(WP_REST_Request $request) {
    global $wpdb;

    // Get card name from the request
    $card_name = $request->get_param('card_name');

// Prepare query to get all fields for a specific card_name
$dataQuery = $wpdb->prepare("SELECT * FROM cc_data WHERE card_name = %s", $card_name);


// Execute the query
$result = $wpdb->get_row($dataQuery, ARRAY_A); // ARRAY_A makes the result an associative array

if ($result !== null) {
    // Append 'card' => $card_name to $result and return the combined array
    return array_merge(array('card' => $card_name), $result);
} else {
    return new WP_Error( 'no_card', 'No card with this name found', array( 'status' => 404 ) );
}

}
?>