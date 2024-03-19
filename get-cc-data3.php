<?php
/**
 * Plugin Name: Get CC Data
 * Description: API to fetch credit card data from the MySQL database
 * Version: 1.0
 * Author: Your Name
 */

// Our function to register new API endpoint
function get_cc_data_register_routes() {
    register_rest_route('get-cc-data/v1', '/cc_data/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_cc_data_callback',
        'args' => array(
            'page' => array(
                'required' => false,
                'default' => 1,
                'sanitize_callback' => 'absint',  // Ensure the value is a non-negative integer
            ),
            'pageSize' => array(
                'required' => false,
                'default' => 10,
                'sanitize_callback' => 'absint',
            ),
        ),
    ));
}

add_action('rest_api_init', 'get_cc_data_register_routes');

// Our callback function that will handle the request
function get_cc_data_callback(WP_REST_Request $request) {
    global $wpdb;

    $start = microtime(true);  // Start time

    // Fetch page and pageSize from the request, defaulting to 1 and 10, respectively:
    $page = $request->get_param('page') ?? 1;
    $pageSize = $request->get_param('pageSize') ?? 5;

    // Compute the offset based on the page number and page size:
    $offset = ($page - 1) * $pageSize;

    // Define a mapping from JS filter parameters to MySQL WHERE clauses:
    $where_clause_mapping = array(
        'creditScore' => array(
            '0' => 'credit_score_low <= 559',
            '1' => 'credit_score_low <= 659',
            '2' => 'credit_score_low <= 724',
            '3' => 'credit_score_low <= 759',
            '4' => 'credit_score_low <= 900',
        ),
        'cashTravel' => array(
            '0' => 'cash_travel = 0',
            '1' => '1=1', // Always true, thus, showing all cards regardless of the cash_travel value
            '2' => 'cash_travel = 2',
        ),
'Business' => array(
    'true' => 'Business = 1', // Only show business cards
    'false' => 'Business = 0',  // Do not show any business cards
),


        'insurance' => array(
            '0' => '1=1',
            '1' => 'insurance_score > 3',
            '2' => 'insurance_score > 8',
        ),
        'lowInterest' => array(
            '0' => '1=1',
            '1' => 'purchase_interest_rate < 19', // Always true, thus, showing all cards regardless of the cash_travel value
            '2' => 'purchase_interest_rate < 12',
        ),
        // 'perks' => array(
        //     '0' => '1=1',
        //     '1' => 'purchase_interest_rate < 19', // Always true, thus, showing all cards regardless of the cash_travel value
        //     '2' => 'purchase_interest_rate < 12',
        // ),
        // ...other mappings...
    );

    $query = " WHERE 1=1 ";
    foreach ($request->get_query_params() as $key => $value) {
        if (array_key_exists($key, $where_clause_mapping)) {
            if (array_key_exists($value, $where_clause_mapping[$key])) {
                $query .= " AND " . $where_clause_mapping[$key][$value] . " ";
            }
        }
    }

    // Get the total number of matching cards (without LIMIT and OFFSET)
    $countQuery = "SELECT COUNT(*) FROM cc_data" . $query;
    $totalCards = $wpdb->get_var($countQuery);

    // Get the current page of cards (with LIMIT and OFFSET)
   $dataQuery = "SELECT annual_fee, purchase_interest_rate, cash_advance_interest_rate, welcome_bonus, card_name, reward_bills, reward_drug, reward_gas, reward_grocery, reward_other, reward_restaurant, reward_store, reward_travel, max_reward, ProsCons, Features, Photos, ReviewLink, BuyLink, Business FROM cc_data" . $query . " ORDER BY ranking DESC, annual_rewards DESC LIMIT $pageSize OFFSET $offset";


    $cards = $wpdb->get_results($dataQuery);

    $end = microtime(true);  // End time
    $execution_time = ($end - $start) * 1000;  // Execution time in milliseconds

    // Return both the cards and the total number of cards, along with execution time
    return array(
        'cards' => $cards,
        'totalCards' => $totalCards,
        'executionTime' => $execution_time,
    );
}
?>