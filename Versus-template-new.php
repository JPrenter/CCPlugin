<?php

/**
 * Plugin Name: My Custom Shortcodes for replacements
 * Description: A custom plugin for my specific shortcode functionalities.
 * Version: 1.0
 * Author: Your Name
 */

include(plugin_dir_path(__FILE__) . 'Versus-page-template.php');


function get_page_info_versus() {
    global $vstemp_template;
    global $wpdb;
    global $card_data;
    global $first_card_data;
    global $second_card_data;
    global $first_card_name;
    global $second_card_name;
    global $averages_returned_database;
    
    $first_card_name = get_post_meta(get_the_ID(), 'first_card_name', true);
    $second_card_name = get_post_meta(get_the_ID(), 'second_card_name', true);
    
    $first_dataQuery = $wpdb->prepare("SELECT * FROM cc_data WHERE card_name = %s", $first_card_name);
    $first_card_data = $wpdb->get_row($first_dataQuery, ARRAY_A);
    
    $second_dataQuery = $wpdb->prepare("SELECT * FROM cc_data WHERE card_name = %s", $second_card_name);
    $second_card_data = $wpdb->get_row($second_dataQuery, ARRAY_A);
    
    
    $card_data = $first_card_data;
    
    $averages_returned_database = $wpdb->get_results("SELECT * FROM cc_data_test_averages",ARRAY_A);

    $finalcontent = modify_block_content_based_on_placeholders_vs($vstemp_template);

    // Attempt to process the content through the block renderer
    $processed_content = apply_filters('the_content', $finalcontent);

    return $processed_content;

}




function modify_block_content_based_on_placeholders_vs($block_content) {
    global $wpdb;
    global $post;
    global $first_card_data;
    global $second_card_data;
    global $averages_returned_database;
    
    static $starReplaced = false; // Static variable to track replacement status

    // Store the data in the static variable
    $data1 = replace_placeholders_with_db_data_first_vs($first_card_data);
    // Store the data in the static variable
    $data2 = replace_placeholders_with_db_data_second_vs($second_card_data);

    $avg_replacements = make_avg_replacements_vs($averages_returned_database);

    $diff_replacements = diff_replacements_vs($averages_returned_database, $first_card_data, $second_card_data);

    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $data1);
    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $data2);
    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $avg_replacements);

    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $diff_replacements);

    // Only call removeRowsWithEmptyCells if the block content contains a <table> tag
    if (strpos($block_content, '<table') !== false) {
        $block_content = removeRowsWithEmptyCells_vs($block_content);
    }

    return $block_content;
}


function make_avg_replacements_vs($avg_data){
    $avg_replacements = array(
        "{{averages.mean_factor_score_perks}}" => formatValuePlaceholders_vs($avg_data[0]['factor_score_perks'], 'onedecimal'),
        "{{averages.mean_annual_fee}}" => formatValuePlaceholders_vs($avg_data[0]['annual_fee'], 'currency'),
        "{{averages.mean_annual_rewards}}" => formatValuePlaceholders_vs($avg_data[0]['annual_rewards'], 'currency'),
        "{{averages.mean_purchase_interest_rate}}" => $avg_data[0]['purchase_interest_rate'],
    );

    return $avg_replacements;

}


function diff_replacements_vs($avg_data, $first_card_data, $second_card_data){
    
    $first_ir = $first_card_data['purchase_interest_rate'];

    if ($first_ir == 'N/A') {
        preg_match('/\d+/', $first_card_data['late_payment_fee'], $matches);
        if (!empty($matches) && $matches[0] != 0) {
            $first_ir= (float)$matches[0];
        }
    }

    $second_ir = $second_card_data['purchase_interest_rate'];

    if ($second_ir == 'N/A') {
        preg_match('/\d+/', $second_card_data['late_payment_fee'], $matches);
        if (!empty($matches) && $matches[0] != 0) {
            $second_ir= (float)$matches[0];
        }
    }

    

    $interest_rate_diff = max($first_ir,$second_ir) - min($first_ir,$second_ir);

    $ir_statement = null;

    if (empty($interest_rate_diff) || $interest_rate_diff === 0 || is_null($interest_rate_diff)) {
        $ir_statement = "there is no difference in the purchase interest rates between the two cards. Therefore, the interest rates on purchases you make shouldn't be a deciding factor for you when picking between these cards.";
    } else {
        // Assuming a threshold, for example, 2% to determine if the difference is large
        $threshold = 2.0;
        
        $ir_statement =  "the difference in the purchase interest rates between the two cards is $interest_rate_diff%.";
        
        if ($interest_rate_diff > $threshold) {
            $ir_statement =  " This is a meaningful difference in interest rates. A higher interest rate can lead to considerably more interest paid on outstanding balances, which can add up over time. It's important to consider this difference if you plan to carry a balance on your card.";
        } else {
            $ir_statement =  " This difference is relatively small. While interest rates are an important factor, a difference of this magnitude is unlikely to have a major impact on the total interest you will pay, especially if you pay off your balances promptly.";
        }
    }

    $first_rewards = $first_card_data['annual_rewards'];
    $second_rewards = $second_card_data['annual_rewards'];

    if ($first_rewards > $second_rewards) {
        $larger_rewards_variable = 'first_card_data';
    } elseif ($second_rewards > $first_rewards) {
        $larger_rewards_variable = 'second_card_data';
    } else {
        $larger_rewards_variable = 'equal'; // In case both are equal
    }
    
    $rewards_diff = max($first_rewards,$second_rewards) - min($first_rewards,$second_rewards);

    if ($larger_rewards_variable == 'equal') {
        $rewards_diff_text = "The rewards are equal. There is no difference in the rewards between the two cards.";
    } else {
        // Calculate the difference in rewards
        $rewards_diff = abs($first_rewards - $second_rewards);
    
        // Determine which card's data to use
        if ($larger_rewards_variable == 'first_rewards') {
            $rewards_winner_card_name = $first_card_data['card_name'];
            $rewards_loser_card_name = $second_card_data['card_name'];
        } else {
            $rewards_winner_card_name = $second_card_data['card_name'];
            $rewards_loser_card_name = $first_card_data['card_name'];
        }
    
        $better_rewards_text = "If rewards are the most important factor for you, then the " . $rewards_winner_card_name . " is likely to be the better choice for you.";
        $rewards_diff_text = "With the " . $rewards_winner_card_name . " you earn $" . $rewards_diff . " more rewards each year than you would with the " . $rewards_loser_card_name . ".";
    }

    $rewards_avg = $rewards_winner_card_name . " earns $" . max($first_rewards,$second_rewards) . " in rewards value.";
    
    
    $diff_replacements = array(
        "{{interest_diff}}" => $ir_statement,
        "{{rewards_difference}}" => $rewards_diff_text,
       "{{rewards_avg_text}}" => $rewards_avg,
       "{{better_rewards_text}}" => $better_rewards_text,
       "{{winner_rewards}}" => $rewards_winner_card_name,
      );

    return $diff_replacements;

}



function removeRowsWithEmptyCells_vs($content) {
    $timings = '';


    // Adjust the regex to capture the entire <figure> block
    preg_match_all('/<figure.*?>.*?<\/figure>/is', $content, $matches);
    
    $cleaned_tables = [];
    foreach ($matches[0] as $table_html) {

        libxml_use_internal_errors(true); // Suppress libxml errors

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($table_html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors(); // Clear any libxml errors that have been recorded

        
        $xpath = new DOMXPath($dom);
        
        $tables = $xpath->query('//table');
        foreach ($tables as $table) {

            // Flag to indicate whether to skip processing this table
            $skipTable = false;

            // Check if any ancestor <figure> of the <table> has the 'excluded-zero' class
            $ancestorWithClass = $xpath->query('ancestor::figure[contains(@class, "excluded-zero")]', $table);
            if ($ancestorWithClass->length > 0) {
            
                $skipTable = true;
            }

            if ($table->hasAttribute('class')) {
                $classes = explode(' ', $table->getAttribute('class'));
                if (in_array('excluded-zero', $classes)) {
            
                    $skipTable = true;
                }
            }

            // If skipTable is true, skip the row processing for this table
            if ($skipTable) {
                continue;
            }

            $rows = $xpath->query('tbody/tr', $table);



            foreach ($rows as $row) {
                $cells = $xpath->query('td', $row);
                $emptyCellCount = 0; // Initialize a counter for empty cells
            
                foreach ($cells as $cell) {
                    $textContent = trim($cell->textContent);
                    // Check for empty content or specific zero values
                    if (empty($textContent) || $textContent == '0' || $textContent == '0.0' || $textContent == '0.00' || $textContent == '$0.00' || $textContent == '$0' || $textContent == '0%' || $textContent == '0.00%' || $textContent == '0.0%' || $textContent == '$0.0') {
                        $emptyCellCount++; // Increment the counter for each empty cell
                    }
                }
            
                // Remove the row only if two or more cells are empty
                if ($emptyCellCount >= 2) {
                    $row->parentNode->removeChild($row);
                }
            }
            
            
            // Check if the table now has no rows in the tbody and if so, remove the entire table.
            $remainingRows = $xpath->query('tbody/tr', $table);
            if ($remainingRows->length == 0) {
                $table->parentNode->removeChild($table);
            }
        }
        
        $cleaned_tables[] = $dom->saveHTML();
    }
    
    // Replace original tables with cleaned tables in the content
    foreach ($matches[0] as $index => $original_table) {
        $content = str_replace($original_table, $cleaned_tables[$index], $content);
    }
    
return $content;
}

function getBlockIdFromContent_vs($content) {
    // This regex looks for the exact pattern you've described
    if (preg_match('/wp-block-uagb-star-rating\s+uagb-block-([a-f0-9]+)/', $content, $matches)) {
        return $matches[1];
    }
    return null;
}

function getRatingFromContent_vs($content) {
    if (preg_match('/<p class="uag-star-rating__title">([\d.]+)<\/p>/', $content, $matches)) {
        return floatval($matches[1]);
    }
    return null;
}





function formatValuePlaceholders_vs($value, $format) {
    
    // Check if the value is set and is numeric
    if (isset($value) && is_numeric($value)) {
        switch ($format) {
            case 'currency':
                $floatValue = (float)$value;
                return "$" . number_format($floatValue, 0);
            case 'integer':
                // Format as an integer with 0 decimals
                return number_format((int)$value, 0);
            case 'percent':
                // Format as a percentage with 2 decimals and append a % symbol
                // Explicitly cast decimals to integer
                return number_format($value, (int)2) . '%';
            case 'string':
                // Return the value as is, without formatting
                return $value;
            // Add more cases for different formats as needed
            case 'onedecimal':
                return number_format($value, (int)1);
            default:
                return $value; // Default case returns the raw value without formatting
        }
    } else {
        if (isset($value)) {
            return $value;
        }
        // Handle null or non-numeric values
        return handleEmptyValue_vs($format); // A separate function to determine what to return for empty values
    }
}

function handleEmptyValue_vs($format) {
    // Define default values for each format type for null/empty inputs
    switch ($format) {
        case 'currency':
            return '$0.00';
        case 'integer':
            return '0';
        case 'percent':
            return '0.00%';
        case 'onedecimal':
            return '0.0';
        // More cases as needed
        default:
            return ''; // Default for unspecified formats
    }
}

            
            




function replace_placeholders_with_db_data_first_vs($card_data) {




    global $wpdb;
    $timings = '';

    $monthly_spend = 2000;
    $annual_spend = $monthly_spend * 12;
    

    
    $results = calculateReward_vs($card_data);
// echo "Total Points: " . $results['totalPoints'];
// echo "Rewards Value Total: " . $results['rewards_value_total'];
// echo "Net Earn Rate: " . $results['net_earn_rate'];


    $proscons_result =  processProsCons_vs($card_data);

$net_after_fee = $results['rewards_value_total'] - $card_data['annual_fee'] ;
$totalPoints = $results['totalPoints'];
$isPercentageReward = $results['pointsordollars'];
if ($isPercentageReward !== true){
    $totalPoints = $results['totalPoints']/100;
}

$insurance_columns = [
    'baggage_delay_insurance',
    'emergency_medical_65',
    'emergency_medical_term',
    'event_cancel',
    'warranty',
    'stolen_baggage',
    'flight_delay',
    'hotel_burglary',
    'mobile_insurance',
    'personal_effects',
    'price_protection',
    'purchase_protection',
    'rental_accident',
    'rental_personal',
    'rental_theft_damage',
    'travel_accident',
    'trip_cancellation',
    'trip_interruption',
];

// Counter for non-null values
$insurance_nonNullCount = 0;

// Iterate over each column and check for non-null and non-empty string values
foreach ($insurance_columns as $column) {
    // Check if the value is set, is not null, and is not an empty string
    if (isset($card_data[$column]) && $card_data[$column] !== null && $card_data[$column] !== '') {
        $insurance_nonNullCount++;
    }
}

// Extracting specific values
$specific_factor_values = [
    'factor_score_fees' => $card_data['factor_score_fee'],
    'factor_score_interest' => $card_data['factor_score_interest'],
    'factor_score_rewards' => $card_data['factor_score_rewards'],
    'factor_score_insurance' => $card_data['factor_score_insurance'],
    'factor_score_perks' => $card_data['factor_score_perks'],
];

// Finding the two largest values
arsort($specific_factor_values); // Sort in descending order
$largest_keys = array_keys(array_slice($specific_factor_values, 0, 2)); // Get keys of the two largest values

// Extract the factor names from the keys
$top_factors = [];
foreach ($largest_keys as $key) {
    // Extracting the factor name from the key (e.g., 'factor_score_fee' becomes 'fee')
    $factor_name = str_replace('factor_score_', '', $key);
    $top_factors[] = $factor_name;
}

$properlink = 'www.dollarwise.ca' . ensureHttpColon_vs($card_data['ReviewLink']);

$properafflink = removeProtocol_vs($card_data['BuyLink']);


    
$first_replacements = array(
        "{{first_card.name}}" => formatValuePlaceholders_vs($card_data['card_name'], 'string'),
        "{{first_card.Photos}}" => $card_data['Photos'],
        "{{first_link}}" => $properlink,
        "{{first_afflink}}" => $properafflink,
        "{{first_insurance_count}}" => formatValuePlaceholders_vs($insurance_nonNullCount, 'integer'),
        "{{first_total_earn_rate}}" => formatValuePlaceholders_vs($results['net_earn_rate'], 'percent'),
        "{{first_card.max_reward}}" => "$" . number_format($card_data['max_reward']/100, 2),
        '{{first_score_1}}' => $top_factors[0],
        '{{first_score_2}}' => $top_factors[1],

        '{{first_class_factor_score_fees}}' => in_array('factor_score_fees', $largest_keys) ? 'highlight_factor' : '',
    '{{first_class_factor_score_interest}}' => in_array('factor_score_interest', $largest_keys) ? 'highlight_factor' : '',
    '{{first_class_factor_score_rewards}}' => in_array('factor_score_rewards', $largest_keys) ? 'highlight_factor' : '',
    '{{first_class_factor_score_insurance}}' => in_array('factor_score_insurance', $largest_keys) ? 'highlight_factor' : '',
    '{{first_class_factor_score_perks}}' => in_array('factor_score_perks', $largest_keys) ? 'highlight_factor' : '',

        "{{first_net_after_fee}}" => formatValuePlaceholders_vs($net_after_fee, 'currency'),

        "{{first_grocery_dollarrewards}}" => formatValuePlaceholders_vs($card_data['grocery_dollarrewards'], 'currency'),
        "{{first_other_dollarrewards}}" => formatValuePlaceholders_vs($card_data['other_dollarrewards'], 'currency'),
        "{{first_gas_dollarrewards}}" => formatValuePlaceholders_vs($card_data['gas_dollarrewards'], 'currency'),
        "{{first_drug_dollarrewards}}" => formatValuePlaceholders_vs($card_data['drug_dollarrewards'], 'currency'),
        "{{first_restaurant_dollarrewards}}" => formatValuePlaceholders_vs($card_data['restaurant_dollarrewards'], 'currency'),
        "{{first_bills_dollarrewards}}" => formatValuePlaceholders_vs($card_data['bills_dollarrewards'], 'currency'),
        "{{first_travel_dollarrewards}}" => formatValuePlaceholders_vs($card_data['travel_dollarrewards'], 'currency'),
        "{{first_store_dollarrewards}}" => formatValuePlaceholders_vs($card_data['store_dollarrewards'], 'currency'),

        "{{first_grocery_earnrate}}" => formatValuePlaceholders_vs($card_data['grocery_earnrate'], 'percent'),
        "{{first_other_earnrate}}" =>  formatValuePlaceholders_vs($card_data['other_earnrate'], 'percent'),
        "{{first_gas_earnrate}}" => formatValuePlaceholders_vs($card_data['gas_earnrate'], 'percent'),
        "{{first_drug_earnrate}}" => formatValuePlaceholders_vs($card_data['drug_earnrate'], 'percent'),
        "{{first_restaurant_earnrate}}" => formatValuePlaceholders_vs($card_data['restaurant_earnrate'], 'percent'),
        "{{first_bills_earnrate}}" => formatValuePlaceholders_vs($card_data['bills_earnrate'], 'percent'),
        "{{first_travel_earnrate}}" =>  formatValuePlaceholders_vs($card_data['travel_earnrate'], 'percent'),
        "{{first_store_earnrate}}" =>  formatValuePlaceholders_vs($card_data['store_earnrate'], 'percent'),

        "{{first_factor_score_fee}}" => formatValuePlaceholders_vs($card_data['factor_score_fee'], 'onedecimal'),
        "{{first_factor_score_interest}}" => formatValuePlaceholders_vs($card_data['factor_score_interest'], 'onedecimal'),
        "{{first_factor_score_rewards}}" => formatValuePlaceholders_vs($card_data['factor_score_rewards'], 'onedecimal'),
        "{{first_factor_score_insurance}}" => formatValuePlaceholders_vs($card_data['factor_score_insurance'], 'onedecimal'),
        "{{first_factor_score_approval}}" => formatValuePlaceholders_vs($card_data['factor_score_approval'], 'onedecimal'),
        "{{first_factor_score_perks}}" => formatValuePlaceholders_vs($card_data['factor_score_perks'], 'onedecimal'),
        "{{first_factor_score_acceptance}}" => formatValuePlaceholders_vs($card_data['factor_score_acceptance'], 'onedecimal'),
        

        "{{first_ranking}}" => $card_data['ranking'],
        "{{first_card.annualFee}}" => formatValuePlaceholders_vs($card_data['annual_fee'], 'currency'),
        "{{first_card.rewards}}" => formatValuePlaceholders_vs($results['rewards_value_total'], 'currency'),  // Placeholder; exact column is not clear
        "{{first_card.introOffer}}" => !empty($card_data['welcome_bonus']) ? $card_data['welcome_bonus'] : "N/A",
        "{{first_reward_bills}}" => $card_data['reward_bills'],
        "{{first_reward_drug}}" => $card_data['reward_drug'],
        "{{first_reward_gas}}" => $card_data['reward_gas'],
        "{{first_reward_grocery}}" => $card_data['reward_grocery'],
        "{{first_reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{first_reward_store}}" => $card_data['reward_store'],
        "{{first_reward_travel}}" => $card_data['reward_travel'],
        "{{first_reward_other}}" => $card_data['reward_other'],
        "{{first_transfer_airlines}}" => $card_data['transfer_airlines'],
        "{{first_ReviewText}}" => $card_data['ReviewText'],
        "{{first_issuer_short}}" => $card_data['issuer_short'],
        "{{monthlyspend}}" => formatValuePlaceholders_vs($monthly_spend, 'currency'),

        "{{annualspend}}" => formatValuePlaceholders_vs($annual_spend, 'currency'),

        "{{first_credit_score_low}}" => $card_data['credit_score_low'],
        "{{first_credit_score_high}}" => $card_data['credit_score_high'],
        "{{first_personal_income}}" => formatValuePlaceholders_vs($card_data['personal_income'], 'currency'),
        "{{first_household_income}}" => formatValuePlaceholders_vs($card_data['household_income'], 'currency'),
        "{{first_purchase_interest_rate}}" => $card_data['purchase_interest_rate'],
        "{{first_cash_advance_interest_rate}}" => $card_data['cash_advance_interest_rate'],
        "{{first_balance_transfer_interest_rate}}" => $card_data['balance_transfer_interest_rate'],
        "{{first_card_type}}" => $card_data['card_type'],
        "{{first_warranty}}" => $card_data['warranty'],
        "{{first_emergency_medical_term}}" => $card_data['emergency_medical_term'],
        "{{first_trip_cancellation}}" => formatValuePlaceholders_vs($card_data['trip_cancellation'], 'currency'),
        "{{first_baggage_delay_insurance}}" => formatValuePlaceholders_vs($card_data['baggage_delay_insurance'], 'currency'),
        "{{first_Redemption}}" => $card_data['Redemption'],
        "{{first_reward_bills}}" => $card_data['reward_bills'],
        "{{first_reward_drug}}" => $card_data['reward_drug'],
        "{{first_reward_gas}}" => $card_data['reward_gas'],
        "{{first_reward_grocery}}" => $card_data['reward_grocery'],
        "{{first_reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{first_reward_store}}" => $card_data['reward_store'],
        "{{first_reward_travel}}" => $card_data['reward_travel'],
        "{{first_reward_other}}" => $card_data['reward_other'],
        "{{first_transfer_airlines}}" => formatValuePlaceholders_vs($card_data['transfer_airlines']*$totalPoints, 'currency'),
        "{{first_Pros}}" => $proscons_result['pros'],
        "{{first_Cons}}" => $proscons_result['cons'],
        "{{first_fixed_points_travel}}" => formatValuePlaceholders_vs($card_data['fixed_points_travel']*$totalPoints, 'currency'),
        "{{first_transfer_hotel}}" => formatValuePlaceholders_vs($card_data['transfer_hotel']*$totalPoints, 'currency'),
        "{{first_redeem_travel}}" => formatValuePlaceholders_vs($card_data['redeem_travel']*$totalPoints, 'currency'),
        "{{first_statement_credit}}" => formatValuePlaceholders_vs($card_data['statement_credit']*$totalPoints, 'currency'),
        "{{first_ticketmaster}}" => formatValuePlaceholders_vs($card_data['ticketmaster']*$totalPoints, 'currency'),
        "{{first_charity}}" => formatValuePlaceholders_vs($card_data['charity']*$totalPoints, 'currency'),
        "{{first_gift_cards}}" => formatValuePlaceholders_vs($card_data['gift_cards']*$totalPoints, 'currency'),
        "{{first_amazon}}" => formatValuePlaceholders_vs($card_data['amazon']*$totalPoints, 'currency'),
        "{{first_merchandise}}" => formatValuePlaceholders_vs($card_data['merchandise']*$totalPoints, 'currency'),
        "{{first_investments}}" => formatValuePlaceholders_vs($card_data['investments']*$totalPoints, 'currency'),
        "{{first_experiences}}" => formatValuePlaceholders_vs($card_data['experiences']*$totalPoints, 'currency'),
        "{{first_car_rental}}" => formatValuePlaceholders_vs($card_data['car_rental']*$totalPoints, 'currency'),
        "{{first_vacation}}" => formatValuePlaceholders_vs($card_data['vacation']*$totalPoints, 'currency'),
        "{{first_attractions}}" => formatValuePlaceholders_vs($card_data['attractions']*$totalPoints, 'currency'),
        "{{first_cash_rewards}}" => formatValuePlaceholders_vs($card_data['cash_rewards']*$totalPoints, 'currency'),
        "{{first_grocery_rewards}}" => formatValuePlaceholders_vs($card_data['grocery_rewards']*$totalPoints, 'currency'),
        "{{first_restaurant_rewards}}" => formatValuePlaceholders_vs($card_data['restaurant_rewards']*$totalPoints, 'currency'),
        "{{first_movie_rewards}}" => formatValuePlaceholders_vs($card_data['movie_rewards']*$totalPoints, 'currency'),
        "{{first_apple_bestbuy}}" => formatValuePlaceholders_vs($card_data['apple_bestbuy']*$totalPoints, 'currency'),
        "{{first_flight_rewards}}" => formatValuePlaceholders_vs($card_data['flight_rewards']*$totalPoints, 'currency'),
        "{{first_airlines_rewards_chart}}" => formatValuePlaceholders_vs($card_data['airlines_rewards_chart']*$totalPoints, 'currency'),
        "{{first_cibc_financial_products}}" => formatValuePlaceholders_vs($card_data['cibc_financial_products']*$totalPoints, 'currency'),
        "{{first_air_travel_redemptions_schedule}}" => formatValuePlaceholders_vs($card_data['air_travel_redemptions_schedule']*$totalPoints, 'currency'),
        "{{first_rbc_travel}}" => formatValuePlaceholders_vs($card_data['rbc_travel']*$totalPoints, 'currency'),
        "{{first_transfer_westjet}}" => formatValuePlaceholders_vs($card_data['transfer_westjet']*$totalPoints, 'currency'),
        "{{first_transfer_bay}}" => formatValuePlaceholders_vs($card_data['transfer_bay']*$totalPoints, 'currency'),
        "{{first_rbc_financial_products_rewards}}" => formatValuePlaceholders_vs($card_data['rbc_financial_products_rewards']*$totalPoints, 'currency'),
        "{{first_aircanada_gift_card}}" => formatValuePlaceholders_vs($card_data['aircanada_gift_card']*$totalPoints, 'currency'),
        "{{first_air_canada_vacations}}" => formatValuePlaceholders_vs($card_data['air_canada_vacations']*$totalPoints, 'currency'),
        "{{first_electronics_gift_cards}}" => formatValuePlaceholders_vs($card_data['electronics_gift_cards']*$totalPoints, 'currency'),
        "{{first_cash_worldelite}}" => formatValuePlaceholders_vs($card_data['cash_worldelite']*$totalPoints, 'currency'),
        "{{first_cash_platinumplus}}" => formatValuePlaceholders_vs($card_data['cash_platinumplus']*$totalPoints, 'currency'),
        "{{first_banking_plans}}" => formatValuePlaceholders_vs($card_data['banking_plans']*$totalPoints, 'currency'),
        "{{first_desjardins_financial_products}}" => formatValuePlaceholders_vs($card_data['desjardins_financial_products']*$totalPoints, 'currency'),
        "{{first_expedia_td}}" => formatValuePlaceholders_vs($card_data['expedia_td']*$totalPoints, 'currency'),
        "{{first_education_rewards}}" => formatValuePlaceholders_vs($card_data['education_rewards']*$totalPoints, 'currency'),
        "{{first_hsbc_financial_products}}" => formatValuePlaceholders_vs($card_data['hsbc_financial_products']*$totalPoints, 'currency'),
        "{{first_walmart_rewards}}" => formatValuePlaceholders_vs($card_data['walmart_rewards']*$totalPoints, 'currency'),
        "{{first_triangle_rewards}}" => formatValuePlaceholders_vs($card_data['triangle_rewards']*$totalPoints, 'currency'),
        "{{first_meridian_travel}}" => formatValuePlaceholders_vs($card_data['meridian_travel']*$totalPoints, 'currency'),
        "{{first_direct_deposit_rewards}}" => formatValuePlaceholders_vs($card_data['direct_deposit_rewards']*$totalPoints, 'currency'),
        "{{first_costco_gift_cards}}" => formatValuePlaceholders_vs($card_data['costco_gift_cards']*$totalPoints, 'currency'),
        "{{first_wireless_rogers_rewards}}" => formatValuePlaceholders_vs($card_data['wireless_rogers_rewards']*$totalPoints, 'currency'),
        "{{first_1_roger_rewards}}" => formatValuePlaceholders_vs($card_data['1_roger_rewards']*$totalPoints, 'currency'),
        "{{first_other_roger_rewards}}" => formatValuePlaceholders_vs($card_data['other_roger_rewards']*$totalPoints, 'currency'),
        "{{first_other_1_roger_rewards}}" => formatValuePlaceholders_vs($card_data['other_1_roger_rewards']*$totalPoints, 'currency'),
        "{{first_purchase_protection}}" => $card_data['purchase_protection'],
        "{{first_travel_accident}}" => formatValuePlaceholders_vs($card_data['travel_accident'], 'currency'),
        "{{first_emergency_medical_65}}" => $card_data['emergency_medical_65'],
        "{{first_trip_interruption}}" => formatValuePlaceholders_vs($card_data['trip_interruption'], 'currency'),
        "{{first_flight_delay}}" => formatValuePlaceholders_vs($card_data['flight_delay'], 'currency'),
        "{{first_stolen_baggage}}" => formatValuePlaceholders_vs($card_data['stolen_baggage'],'currency'),
        "{{first_event_cancel}}" => formatValuePlaceholders_vs($card_data['event_cancel'],'currency'),
        "{{first_rental_theft_damage}}" => formatValuePlaceholders_vs($card_data['rental_theft_damage'],'currency'),
        "{{first_rental_personal}}" => formatValuePlaceholders_vs($card_data['rental_personal'],'currency'),
        "{{first_rental_accident}}" => formatValuePlaceholders_vs($card_data['rental_accident'],'currency'),
        "{{first_hotel_burglary}}" => formatValuePlaceholders_vs($card_data['hotel_burglary'],'currency'),
        "{{first_mobile_insurance}}" => formatValuePlaceholders_vs($card_data['mobile_insurance'],'currency'),
        "{{first_personal_effects}}" => formatValuePlaceholders_vs($card_data['personal_effects'],'currency'),
        "{{first_price_protection}}" => $card_data['price_protection'],
        "{{first_Foreign}}" => $card_data['Foreign'],
        "{{first_IncomeMin}}" => $card_data['IncomeMin'],
        "{{first_Features}}" => $card_data['Features'],
        "{{first_total_net_rewards}}" => formatValuePlaceholders_vs($results['rewards_value_total'], 'currency'),
        
        
        
        

    );

    //  // Filter out placeholders with empty or 0 values
    //  $replacements = array_filter($replacements, function($value) {
    //     return !empty($value) && $value !== '0' && $value !== '0.0' && $value !== '0.00';
    // });

    return $first_replacements;

}

function ensureHttpColon_vs($url) {
    // Use parse_url to extract the path component
    $parsedUrl = parse_url($url);
    return $parsedUrl['path'] ?? ''; // Return the path or an empty string if not present

}

function removeProtocol_vs($url) {
    // Remove both http:// and https://
    $url = str_replace('http://', '', $url);
    $url = str_replace('https://', '', $url);
    return $url;
}

function replace_placeholders_with_db_data_second_vs($card_data) {

    global $wpdb;
    $timings = '';

    $monthly_spend = 2000;
    $annual_spend = $monthly_spend * 12;  

    
    $results = calculateReward_vs($card_data);
// echo "Total Points: " . $results['totalPoints'];
// echo "Rewards Value Total: " . $results['rewards_value_total'];
// echo "Net Earn Rate: " . $results['net_earn_rate'];


    $proscons_result =  processProsCons_vs($card_data);

$net_after_fee = $results['rewards_value_total'] - $card_data['annual_fee'] ;
$totalPoints = $results['totalPoints'];
$isPercentageReward = $results['pointsordollars'];
if ($isPercentageReward !== true){
    $totalPoints = $results['totalPoints']/100;
}

$insurance_columns = [
    'baggage_delay_insurance',
    'emergency_medical_65',
    'emergency_medical_term',
    'event_cancel',
    'warranty',
    'stolen_baggage',
    'flight_delay',
    'hotel_burglary',
    'mobile_insurance',
    'personal_effects',
    'price_protection',
    'purchase_protection',
    'rental_accident',
    'rental_personal',
    'rental_theft_damage',
    'travel_accident',
    'trip_cancellation',
    'trip_interruption',
];

// Counter for non-null values
$insurance_nonNullCount = 0;

// Iterate over each column and check for non-null and non-empty string values
foreach ($insurance_columns as $column) {
    // Check if the value is set, is not null, and is not an empty string
    if (isset($card_data[$column]) && $card_data[$column] !== null && $card_data[$column] !== '') {
        $insurance_nonNullCount++;
    }
}

// Extracting specific values
$specific_factor_values = [
    'factor_score_fees' => $card_data['factor_score_fee'],
    'factor_score_interest' => $card_data['factor_score_interest'],
    'factor_score_rewards' => $card_data['factor_score_rewards'],
    'factor_score_insurance' => $card_data['factor_score_insurance'],
    'factor_score_perks' => $card_data['factor_score_perks'],
];

// Finding the two largest values
arsort($specific_factor_values); // Sort in descending order
$largest_keys = array_keys(array_slice($specific_factor_values, 0, 2)); // Get keys of the two largest values

// Extract the factor names from the keys
$top_factors = [];
foreach ($largest_keys as $key) {
    // Extracting the factor name from the key (e.g., 'factor_score_fee' becomes 'fee')
    $factor_name = str_replace('factor_score_', '', $key);
    $top_factors[] = $factor_name;
}

$properlink = 'www.dollarwise.ca' . ensureHttpColon_vs($card_data['ReviewLink']);

$properafflink = removeProtocol_vs($card_data['BuyLink']);


    $second_replacements = array(
        "{{second_card.name}}" => formatValuePlaceholders_vs($card_data['card_name'], 'string'),
        "{{second_card.Photos}}" => $card_data['Photos'],
        "{{second_link}}" => $properlink,
        "{{second_afflink}}" => $properafflink,
        "{{second_insurance_count}}" => formatValuePlaceholders_vs($insurance_nonNullCount, 'integer'),
        "{{second_total_earn_rate}}" => formatValuePlaceholders_vs($results['net_earn_rate'], 'percent'),
        "{{second_card.max_reward}}" => "$" . number_format($card_data['max_reward']/100, 2),
        '{{second_score_1}}' => $top_factors[0],
        '{{second_score_2}}' => $top_factors[1],

        '{{second_class_factor_score_fees}}' => in_array('factor_score_fees', $largest_keys) ? 'highlight_factor' : '',
    '{{second_class_factor_score_interest}}' => in_array('factor_score_interest', $largest_keys) ? 'highlight_factor' : '',
    '{{second_class_factor_score_rewards}}' => in_array('factor_score_rewards', $largest_keys) ? 'highlight_factor' : '',
    '{{second_class_factor_score_insurance}}' => in_array('factor_score_insurance', $largest_keys) ? 'highlight_factor' : '',
    '{{second_class_factor_score_perks}}' => in_array('factor_score_perks', $largest_keys) ? 'highlight_factor' : '',

        "{{second_net_after_fee}}" => formatValuePlaceholders_vs($net_after_fee, 'currency'),

        "{{second_grocery_dollarrewards}}" => formatValuePlaceholders_vs($card_data['grocery_dollarrewards'], 'currency'),
        "{{second_other_dollarrewards}}" => formatValuePlaceholders_vs($card_data['other_dollarrewards'], 'currency'),
        "{{second_gas_dollarrewards}}" => formatValuePlaceholders_vs($card_data['gas_dollarrewards'], 'currency'),
        "{{second_drug_dollarrewards}}" => formatValuePlaceholders_vs($card_data['drug_dollarrewards'], 'currency'),
        "{{second_restaurant_dollarrewards}}" => formatValuePlaceholders_vs($card_data['restaurant_dollarrewards'], 'currency'),
        "{{second_bills_dollarrewards}}" => formatValuePlaceholders_vs($card_data['bills_dollarrewards'], 'currency'),
        "{{second_travel_dollarrewards}}" => formatValuePlaceholders_vs($card_data['travel_dollarrewards'], 'currency'),
        "{{second_store_dollarrewards}}" => formatValuePlaceholders_vs($card_data['store_dollarrewards'], 'currency'),

        "{{second_grocery_earnrate}}" => formatValuePlaceholders_vs($card_data['grocery_earnrate'], 'percent'),
        "{{second_other_earnrate}}" =>  formatValuePlaceholders_vs($card_data['other_earnrate'], 'percent'),
        "{{second_gas_earnrate}}" => formatValuePlaceholders_vs($card_data['gas_earnrate'], 'percent'),
        "{{second_drug_earnrate}}" => formatValuePlaceholders_vs($card_data['drug_earnrate'], 'percent'),
        "{{second_restaurant_earnrate}}" => formatValuePlaceholders_vs($card_data['restaurant_earnrate'], 'percent'),
        "{{second_bills_earnrate}}" => formatValuePlaceholders_vs($card_data['bills_earnrate'], 'percent'),
        "{{second_travel_earnrate}}" =>  formatValuePlaceholders_vs($card_data['travel_earnrate'], 'percent'),
        "{{second_store_earnrate}}" =>  formatValuePlaceholders_vs($card_data['store_earnrate'], 'percent'),

        "{{second_factor_score_fee}}" => formatValuePlaceholders_vs($card_data['factor_score_fee'], 'onedecimal'),
        "{{second_factor_score_interest}}" => formatValuePlaceholders_vs($card_data['factor_score_interest'], 'onedecimal'),
        "{{second_factor_score_rewards}}" => formatValuePlaceholders_vs($card_data['factor_score_rewards'], 'onedecimal'),
        "{{second_factor_score_insurance}}" => formatValuePlaceholders_vs($card_data['factor_score_insurance'], 'onedecimal'),
        "{{second_factor_score_approval}}" => formatValuePlaceholders_vs($card_data['factor_score_approval'], 'onedecimal'),
        "{{second_factor_score_perks}}" => formatValuePlaceholders_vs($card_data['factor_score_perks'], 'onedecimal'),
        "{{second_factor_score_acceptance}}" => formatValuePlaceholders_vs($card_data['factor_score_acceptance'], 'onedecimal'),
        

        "{{second_ranking}}" => $card_data['ranking'],
        "{{second_card.annualFee}}" => formatValuePlaceholders_vs($card_data['annual_fee'], 'currency'),
        "{{second_card.rewards}}" => formatValuePlaceholders_vs($results['rewards_value_total'], 'currency'),  // Placeholder; exact column is not clear
        "{{second_card.introOffer}}" => !empty($card_data['welcome_bonus']) ? $card_data['welcome_bonus'] : "N/A",
        "{{second_reward_bills}}" => $card_data['reward_bills'],
        "{{second_reward_drug}}" => $card_data['reward_drug'],
        "{{second_reward_gas}}" => $card_data['reward_gas'],
        "{{second_reward_grocery}}" => $card_data['reward_grocery'],
        "{{second_reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{second_reward_store}}" => $card_data['reward_store'],
        "{{second_reward_travel}}" => $card_data['reward_travel'],
        "{{second_reward_other}}" => $card_data['reward_other'],
        "{{second_transfer_airlines}}" => $card_data['transfer_airlines'],
        "{{second_ReviewText}}" => $card_data['ReviewText'],
        "{{second_issuer_short}}" => $card_data['issuer_short'],
        "{{monthlyspend}}" => formatValuePlaceholders_vs($monthly_spend, 'currency'),

        "{{annualspend}}" => formatValuePlaceholders_vs($annual_spend, 'currency'),

        "{{second_credit_score_low}}" => $card_data['credit_score_low'],
        "{{second_credit_score_high}}" => $card_data['credit_score_high'],
        "{{second_personal_income}}" => formatValuePlaceholders_vs($card_data['personal_income'], 'currency'),
        "{{second_household_income}}" => formatValuePlaceholders_vs($card_data['household_income'], 'currency'),
        "{{second_purchase_interest_rate}}" => $card_data['purchase_interest_rate'],
        "{{second_cash_advance_interest_rate}}" => $card_data['cash_advance_interest_rate'],
        "{{second_balance_transfer_interest_rate}}" => $card_data['balance_transfer_interest_rate'],
        "{{second_card_type}}" => $card_data['card_type'],
        "{{second_warranty}}" => $card_data['warranty'],
        "{{second_emergency_medical_term}}" => $card_data['emergency_medical_term'],
        "{{second_trip_cancellation}}" => formatValuePlaceholders_vs($card_data['trip_cancellation'], 'currency'),
        "{{second_baggage_delay_insurance}}" => formatValuePlaceholders_vs($card_data['baggage_delay_insurance'], 'currency'),
        "{{second_Redemption}}" => $card_data['Redemption'],
        "{{second_reward_bills}}" => $card_data['reward_bills'],
        "{{second_reward_drug}}" => $card_data['reward_drug'],
        "{{second_reward_gas}}" => $card_data['reward_gas'],
        "{{second_reward_grocery}}" => $card_data['reward_grocery'],
        "{{second_reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{second_reward_store}}" => $card_data['reward_store'],
        "{{second_reward_travel}}" => $card_data['reward_travel'],
        "{{second_reward_other}}" => $card_data['reward_other'],
        "{{second_transfer_airlines}}" => formatValuePlaceholders_vs($card_data['transfer_airlines']*$totalPoints, 'currency'),
        "{{second_Pros}}" => $proscons_result['pros'],
        "{{second_Cons}}" => $proscons_result['cons'],
        "{{second_fixed_points_travel}}" => formatValuePlaceholders_vs($card_data['fixed_points_travel']*$totalPoints, 'currency'),
        "{{second_transfer_hotel}}" => formatValuePlaceholders_vs($card_data['transfer_hotel']*$totalPoints, 'currency'),
        "{{second_redeem_travel}}" => formatValuePlaceholders_vs($card_data['redeem_travel']*$totalPoints, 'currency'),
        "{{second_statement_credit}}" => formatValuePlaceholders_vs($card_data['statement_credit']*$totalPoints, 'currency'),
        "{{second_ticketmaster}}" => formatValuePlaceholders_vs($card_data['ticketmaster']*$totalPoints, 'currency'),
        "{{second_charity}}" => formatValuePlaceholders_vs($card_data['charity']*$totalPoints, 'currency'),
        "{{second_gift_cards}}" => formatValuePlaceholders_vs($card_data['gift_cards']*$totalPoints, 'currency'),
        "{{second_amazon}}" => formatValuePlaceholders_vs($card_data['amazon']*$totalPoints, 'currency'),
        "{{second_merchandise}}" => formatValuePlaceholders_vs($card_data['merchandise']*$totalPoints, 'currency'),
        "{{second_investments}}" => formatValuePlaceholders_vs($card_data['investments']*$totalPoints, 'currency'),
        "{{second_experiences}}" => formatValuePlaceholders_vs($card_data['experiences']*$totalPoints, 'currency'),
        "{{second_car_rental}}" => formatValuePlaceholders_vs($card_data['car_rental']*$totalPoints, 'currency'),
        "{{second_vacation}}" => formatValuePlaceholders_vs($card_data['vacation']*$totalPoints, 'currency'),
        "{{second_attractions}}" => formatValuePlaceholders_vs($card_data['attractions']*$totalPoints, 'currency'),
        "{{second_cash_rewards}}" => formatValuePlaceholders_vs($card_data['cash_rewards']*$totalPoints, 'currency'),
        "{{second_grocery_rewards}}" => formatValuePlaceholders_vs($card_data['grocery_rewards']*$totalPoints, 'currency'),
        "{{second_restaurant_rewards}}" => formatValuePlaceholders_vs($card_data['restaurant_rewards']*$totalPoints, 'currency'),
        "{{second_movie_rewards}}" => formatValuePlaceholders_vs($card_data['movie_rewards']*$totalPoints, 'currency'),
        "{{second_apple_bestbuy}}" => formatValuePlaceholders_vs($card_data['apple_bestbuy']*$totalPoints, 'currency'),
        "{{second_flight_rewards}}" => formatValuePlaceholders_vs($card_data['flight_rewards']*$totalPoints, 'currency'),
        "{{second_airlines_rewards_chart}}" => formatValuePlaceholders_vs($card_data['airlines_rewards_chart']*$totalPoints, 'currency'),
        "{{second_cibc_financial_products}}" => formatValuePlaceholders_vs($card_data['cibc_financial_products']*$totalPoints, 'currency'),
        "{{second_air_travel_redemptions_schedule}}" => formatValuePlaceholders_vs($card_data['air_travel_redemptions_schedule']*$totalPoints, 'currency'),
        "{{second_rbc_travel}}" => formatValuePlaceholders_vs($card_data['rbc_travel']*$totalPoints, 'currency'),
        "{{second_transfer_westjet}}" => formatValuePlaceholders_vs($card_data['transfer_westjet']*$totalPoints, 'currency'),
        "{{second_transfer_bay}}" => formatValuePlaceholders_vs($card_data['transfer_bay']*$totalPoints, 'currency'),
        "{{second_rbc_financial_products_rewards}}" => formatValuePlaceholders_vs($card_data['rbc_financial_products_rewards']*$totalPoints, 'currency'),
        "{{second_aircanada_gift_card}}" => formatValuePlaceholders_vs($card_data['aircanada_gift_card']*$totalPoints, 'currency'),
        "{{second_air_canada_vacations}}" => formatValuePlaceholders_vs($card_data['air_canada_vacations']*$totalPoints, 'currency'),
        "{{second_electronics_gift_cards}}" => formatValuePlaceholders_vs($card_data['electronics_gift_cards']*$totalPoints, 'currency'),
        "{{second_cash_worldelite}}" => formatValuePlaceholders_vs($card_data['cash_worldelite']*$totalPoints, 'currency'),
        "{{second_cash_platinumplus}}" => formatValuePlaceholders_vs($card_data['cash_platinumplus']*$totalPoints, 'currency'),
        "{{second_banking_plans}}" => formatValuePlaceholders_vs($card_data['banking_plans']*$totalPoints, 'currency'),
        "{{second_desjardins_financial_products}}" => formatValuePlaceholders_vs($card_data['desjardins_financial_products']*$totalPoints, 'currency'),
        "{{second_expedia_td}}" => formatValuePlaceholders_vs($card_data['expedia_td']*$totalPoints, 'currency'),
        "{{second_education_rewards}}" => formatValuePlaceholders_vs($card_data['education_rewards']*$totalPoints, 'currency'),
        "{{second_hsbc_financial_products}}" => formatValuePlaceholders_vs($card_data['hsbc_financial_products']*$totalPoints, 'currency'),
        "{{second_walmart_rewards}}" => formatValuePlaceholders_vs($card_data['walmart_rewards']*$totalPoints, 'currency'),
        "{{second_triangle_rewards}}" => formatValuePlaceholders_vs($card_data['triangle_rewards']*$totalPoints, 'currency'),
        "{{second_meridian_travel}}" => formatValuePlaceholders_vs($card_data['meridian_travel']*$totalPoints, 'currency'),
        "{{second_direct_deposit_rewards}}" => formatValuePlaceholders_vs($card_data['direct_deposit_rewards']*$totalPoints, 'currency'),
        "{{second_costco_gift_cards}}" => formatValuePlaceholders_vs($card_data['costco_gift_cards']*$totalPoints, 'currency'),
        "{{second_wireless_rogers_rewards}}" => formatValuePlaceholders_vs($card_data['wireless_rogers_rewards']*$totalPoints, 'currency'),
        "{{second_1_roger_rewards}}" => formatValuePlaceholders_vs($card_data['1_roger_rewards']*$totalPoints, 'currency'),
        "{{second_other_roger_rewards}}" => formatValuePlaceholders_vs($card_data['other_roger_rewards']*$totalPoints, 'currency'),
        "{{second_other_1_roger_rewards}}" => formatValuePlaceholders_vs($card_data['other_1_roger_rewards']*$totalPoints, 'currency'),
        "{{second_purchase_protection}}" => $card_data['purchase_protection'],
        "{{second_travel_accident}}" => formatValuePlaceholders_vs($card_data['travel_accident'], 'currency'),
        "{{second_emergency_medical_65}}" => $card_data['emergency_medical_65'],
        "{{second_trip_interruption}}" => formatValuePlaceholders_vs($card_data['trip_interruption'], 'currency'),
        "{{second_flight_delay}}" => formatValuePlaceholders_vs($card_data['flight_delay'], 'currency'),
        "{{second_stolen_baggage}}" => formatValuePlaceholders_vs($card_data['stolen_baggage'],'currency'),
        "{{second_event_cancel}}" => formatValuePlaceholders_vs($card_data['event_cancel'],'currency'),
        "{{second_rental_theft_damage}}" => formatValuePlaceholders_vs($card_data['rental_theft_damage'],'currency'),
        "{{second_rental_personal}}" => formatValuePlaceholders_vs($card_data['rental_personal'],'currency'),
        "{{second_rental_accident}}" => formatValuePlaceholders_vs($card_data['rental_accident'],'currency'),
        "{{second_hotel_burglary}}" => formatValuePlaceholders_vs($card_data['hotel_burglary'],'currency'),
        "{{second_mobile_insurance}}" => formatValuePlaceholders_vs($card_data['mobile_insurance'],'currency'),
        "{{second_personal_effects}}" => formatValuePlaceholders_vs($card_data['personal_effects'],'currency'),
        "{{second_price_protection}}" => $card_data['price_protection'],
        "{{second_Foreign}}" => $card_data['Foreign'],
        "{{second_IncomeMin}}" => $card_data['IncomeMin'],
        "{{second_Features}}" => $card_data['Features'],
        "{{second_total_net_rewards}}" => formatValuePlaceholders_vs($results['rewards_value_total'], 'currency'),
        
        
        
        

    );

    //  // Filter out placeholders with empty or 0 values
    //  $replacements = array_filter($replacements, function($value) {
    //     return !empty($value) && $value !== '0' && $value !== '0.0' && $value !== '0.00';
    // });

    return $second_replacements;

}

function calculateReward_vs($data) {
    global $annual_spend;
    $monthly_spend = 2000;
    $annual_spend = $monthly_spend * 12;

    $isPercentageReward = false;

foreach ($data as $key => $reward) {
    if (strpos($key, 'reward_') === 0 && strpos($reward, '%') !== false) {
        $isPercentageReward = true;
        break;
    }
}

    
    $spend = $annual_spend;  // Monthly spend to annual

    $categories = [
        'other' => array('spendPercent' => 0.25, 'pointMultiplier' => $data['reward_other']),
        'gas' => array('spendPercent' => 0.10, 'pointMultiplier' => $data['reward_gas']),
        'grocery' => array('spendPercent' => 0.25, 'pointMultiplier' => $data['reward_grocery']),
        'drug' => array('spendPercent' => 0.025, 'pointMultiplier' => $data['reward_drug']),
        'restaurant' => array('spendPercent' => 0.1, 'pointMultiplier' => $data['reward_restaurant']),
        'bills' => array('spendPercent' => 0.175, 'pointMultiplier' => $data['reward_bills']),
        'travel' => array('spendPercent' => 0.05, 'pointMultiplier' => $data['reward_travel']),
        'store' => array('spendPercent' => 0.05, 'pointMultiplier' => $data['reward_store'])
    ];

    $totalPoints = 0;
    preg_match('/\\d+\\.?\\d*/', $data['max_reward'], $match);
    $pointValue = isset($match[0]) ? (float)$match[0] : 0;

    $accumulatedSpendPercent = 0;  // Accumulated spend percentage for categories without a points multiplier

    foreach ($categories as $category => $values) {
        if ($category === 'other') continue;
    
        preg_match('/\\d+\\.?\\d*/', $values['pointMultiplier'], $match);
    
        if (strpos($values['pointMultiplier'], '%') !== false) {
            $categories[$category]['pointMultiplier'] = isset($match[0]) ? (float)$match[0] / 100 : 0;
        } else {
            $categories[$category]['pointMultiplier'] = isset($match[0]) ? (float)$match[0] : 0;
        }

    
    
        
    }
    
    
    

    // Handle categories with invalid or zero pointMultiplier
    foreach ($categories as $category => $values) {
        if ($values['pointMultiplier'] === 'NaN' || $values['pointMultiplier'] === 0) {
            $accumulatedSpendPercent += $values['spendPercent'];
            unset($categories[$category]);
        }
    }

    foreach ($categories as $category => $values) {
        if ($category === 'other') {
            $categories['other']['spendPercent'] += $accumulatedSpendPercent;  // Note: It should be $accumulatedSpendPercent, not $accumulatedSpend
            $otherSpend = $spend * $categories['other']['spendPercent'];
            
            preg_match('/\\d+\\.?\\d*/', $values['pointMultiplier'], $match);
        
            if (strpos($values['pointMultiplier'], '%') !== false) {
                $categories['other']['pointMultiplier'] = isset($match[0]) ? (float)$match[0] / 100 : 0;
            } else {
                $categories['other']['pointMultiplier'] = isset($match[0]) ? (float)$match[0] : 0;
            }
        
            $totalPoints += $otherSpend * $categories['other']['pointMultiplier'];
   
            
            continue;
        }
        
        
        $categorySpend = $spend * $values['spendPercent'];
        $pointsForCategory = $categorySpend * $values['pointMultiplier'];
        $totalPoints += $pointsForCategory;


        
   
        
    }

    if ($isPercentageReward) {
        $rewards_value_total = $totalPoints;
    } else {
        $rewards_value_total = $totalPoints *  ($data['max_reward']/100);
    }
    
    $net_earn_rate = ($rewards_value_total / $annual_spend) * 100;

    
    return [
        'totalPoints' => $totalPoints,
        'rewards_value_total' => $rewards_value_total,
        'net_earn_rate' => $net_earn_rate,
        'pointsordollars' => $isPercentageReward
    ];
}



function processProsCons_vs($data) {
    $prosCons = $data['ProsCons'];

    
    // Split the data into pros and cons using the <b>Cons</b> marker
    $parts = explode('<b>Cons</b>', $prosCons);
    
       // Strip the <b>Pros</b> marker from the beginning of the 'pros' section
    $pros = trim(str_replace('<b>Pros</b>', '', $parts[0]));
    $cons = trim($parts[1]);
    
    // $pros = truncateText($pros, 300);
    // $cons = truncateText($cons, 250);

    // // Apply the style to the 'ul' elements in the 'pros' and 'cons' strings
    $pros = str_replace('<ul>', '<ul style="margin: 0 !important;">', $pros);
    $cons = str_replace('<ul>', '<ul style="margin: 0 !important;">', $cons);

    // // Bold everything before the colon in each <li>
    // $pros = boldBeforeColon($pros);
    // $cons = boldBeforeColon(cons);

    return [
        'pros' => $pros,
        'cons' => $cons
    ];
}

add_shortcode('custom_template_shortcode', 'get_page_info_versus');
?>