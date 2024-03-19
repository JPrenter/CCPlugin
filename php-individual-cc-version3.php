<?php
function run_my_plugin_logic() {
    $current_post = get_queried_object();

    // Check if the current post is an object and has an ID attribute
    if ($current_post && isset($current_post->ID)) {
        // Check if the post belongs to the "credit-cards" category
        if (has_term('credit-cards', 'category', $current_post)) {
            // Check if the title contains the word "Review"
            if (strpos($current_post->post_title, 'Review') !== false) {


/*
Plugin Name: Custom Placeholder Replacer
Description: Replaces placeholders in the content with data from the database.
Version: 1.0
Author: Your Name
*/
global $wpdb;
global $averages_returned_database;
global $card_data;
global $card_name;

$card_name = get_post_meta(get_the_ID(), 'card_name', true);


$averages_returned_database = $wpdb->get_results("SELECT * FROM cc_data_test_averages",ARRAY_A);

$dataQuery = $wpdb->prepare("SELECT * FROM cc_data WHERE card_name = %s", $card_name);
$card_data = $wpdb->get_row($dataQuery, ARRAY_A);




function removeRowsWithEmptyCells($content) {
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
                $removeRow = false;
                foreach ($cells as $cell) {
                    $textContent = trim($cell->textContent);
                    if (empty($textContent) || $textContent == '0' || $textContent == '0.0' || $textContent == '0.00' || $textContent == '$0.00' || $textContent == '$0' || $textContent == '0%' || $textContent == '0.00%' || $textContent == '0.0%' || $textContent == '$0.0') {
                        $removeRow = true;
                        break;
                    }
                }
                if ($removeRow) {
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


function modify_block_content_based_on_placeholders($block_content, $block) {
    global $wpdb;
    global $post;
    
    static $starReplaced = false; // Static variable to track replacement status

    // Fetch all data
    $data = fetch_all_placeholder_data();

    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $data);

    // Only call removeRowsWithEmptyCells if the block content contains a <table> tag
    if (strpos($block_content, '<table') !== false) {
        $block_content = removeRowsWithEmptyCells($block_content);
    }

    // Replace star rating placeholder only if it hasn't been replaced already
    if (!$starReplaced && isset($data['{{ranking}}'])) {
        // Usage within your function

        $blockId = getBlockIdFromContent($block_content);
        $rating = getRatingFromContent($block_content);

        if ($blockId && $rating !== null) {
            $starCSS = generateStarCSS($blockId, $rating);
            // ... rest of your code
            echo "<style>{$starCSS}</style>";
        }
        
        
    }

    return $block_content;
}


function modify_block_content_averages($block_content, $block) {
    global $wpdb;
    global $post;
    
    static $starReplaced = false; // Static variable to track replacement status

    // Fetch all data
    $data = get_average_placeholders();

    // Replace all placeholders in the block content
    $block_content = strtr($block_content, $data);

    // Only call removeRowsWithEmptyCells if the block content contains a <table> tag
    if (strpos($block_content, '<table') !== false) {
        $block_content = removeRowsWithEmptyCells($block_content);
    }

    return $block_content;
}

function getBlockIdFromContent($content) {
    // This regex looks for the exact pattern you've described
    if (preg_match('/wp-block-uagb-star-rating\s+uagb-block-([a-f0-9]+)/', $content, $matches)) {
        return $matches[1];
    }
    return null;
}

function getRatingFromContent($content) {
    if (preg_match('/<p class="uag-star-rating__title">([\d.]+)<\/p>/', $content, $matches)) {
        return floatval($matches[1]);
    }
    return null;
}





function fetch_all_placeholder_data(){
    global $card_data;
    // Static variable to hold the data across multiple calls
    static $data = null;

    // If data is already fetched, simply return it
    if ($data !== null) {
        return $data;
    }

    global $wpdb;
    $timings = '';
    $card_name = get_post_meta(get_the_ID(), 'card_name', true);
    

    // Store the data in the static variable
    $data = replace_placeholders_with_db_data($card_data);

    return $data;
}

function findCardDecile($averages_returned_database, $attribute) {
    global $card_data;
    // Extract decile values for the attribute
    $deciles = [];
    for ($i = 1; $i <= 10; $i++) {
        $decile_key = "decile_$i";
        foreach ($averages_returned_database as $row) {
            if ($row['statistic_type'] === $decile_key) {
                $deciles[$i] = $row[$attribute];
            }
        }
    }



    // Determine the decile the card's attribute falls into
    $card_value = $card_data[$attribute];


    // Edge case: Check if the value is greater than or equal to the 10th decile
    if ($card_value >= $deciles[10]) {

        return 10;
    }

    // Check for other deciles
    for ($i = 1; $i <= 9; $i++) {
        if ($card_value >= $deciles[$i] && $card_value < $deciles[$i + 1]) {

            return $i;
        }
    }


    return null; // Unable to determine the decile
}


function generateStarCSS($blockId, $rating) {
    $ratingInt = intval($rating);
    $ratingFraction = ($rating - $ratingInt) * 100;
    $nextStar = $ratingInt + 1;

    $css = "
    .uagb-block-{$blockId} .uag-star:nth-child(-n+{$ratingInt}) {
        color: var(--ast-global-color-0);
    }
    .uagb-block-{$blockId} .uag-star:nth-child({$nextStar}) {
        position: relative;
        overflow: hidden;
    }
    .uagb-block-{$blockId} .uag-star:nth-child({$nextStar}):before {
        content: '★';
        color: var(--ast-global-color-0);
        position: absolute;
        left: 0;
        top: 0;
        width: {$ratingFraction}%;
        overflow: hidden;
    }
    ";

    return $css;
}

function get_average_placeholders(){
    global $averages_returned_database;
    // Static variable to hold the data across multiple calls
    static $averagedata = null;

    // If data is already fetched, simply return it
    if ($averagedata !== null) {
        return $averagedata;
    }   

    // Store the data in the static variable
    $averagedata = replace_averages($averages_returned_database);

    return $averagedata;
}

function replace_averages($averages_returned_database) {
    global $wpdb;
    global $card_data;

    $average_replacements = [];
    $relevant_columns = [
        'net_annual_rewards' => 'currency',
        'annual_rewards' => 'currency',
        'annual_fee' => 'currency', 
        'credit_score_low' => 'integer',
        'household_income' => 'currency',
        'personal_income' => 'currency', 
        'factor_score_perks' => 'onedecimal',
        'factor_score_insurance' => 'onedecimal',
        'factor_score_interest' => 'onedecimal',
        'restaurant_earnrate' => 'percent',
        'other_earnrate' => 'percent',
        'gas_earnrate' => 'percent',
        'grocery_earnrate' => 'percent',
        'drug_earnrate' => 'percent',
        'bills_earnrate' => 'percent',
        'travel_earnrate' => 'percent',
        'store_earnrate' => 'percent',
        'purchase_interest_rate' => 'percent',
        'cash_advance_interest_rate' => 'percent',
        'balance_transfer_interest_rate' => 'percent',
        'baggage_delay_insurance' => 'currency',
        'emergency_medical_65' => 'string',
        'emergency_medical_term' => 'string',
        'event_cancel' => 'currency',
        'warranty' => 'string',
        'stolen_baggage' => 'currency',
        'flight_delay' => 'currency',
        'hotel_burglary' => 'currency',
        'mobile_insurance' => 'currency',
        'personal_effects' => 'currency',
        'price_protection' => 'string',
        'purchase_protection' => 'string',
        'rental_accident' => 'currency',
        'rental_personal' => 'currency',
        'travel_accident' => 'currency',
        'trip_cancellation' => 'currency',
        'trip_interruption' => 'currency',
    ];

    // Define the statistic types you want to process
    $statistic_types = ['mean', 'median', 'count', 'mode'];

    // Add deciles to the list of statistic types
    for ($i = 1; $i <= 10; $i++) {
        array_push($statistic_types, "decile_$i");
    }

    // Iterate over each statistic type
    foreach ($statistic_types as $type) {
        // Filter the array to get rows where 'statistic_type' is the current type
        $filtered_rows = array_filter($averages_returned_database, function ($row) use ($type) {
            return $row['statistic_type'] === $type;
        });

        // If there are any rows after filtering, process each relevant column
        if (!empty($filtered_rows)) {
            $first_row = reset($filtered_rows); // Get the first row that matches

            // Iterate over each relevant column
            foreach ($relevant_columns as $column => $format) {
                $value = $first_row[$column] ?? null; // Check if the column exists in the row
                if ($value !== null) {
                    // Handle decile placeholders differently
                    if (strpos($type, 'decile_') === 0) {
                        $card_decile = findCardDecile($averages_returned_database, $column);

                        if ($card_decile > 5) {
                            // For deciles 6 to 10, indicate "top X%"
                            $top_percentage = (11 - $card_decile) * 10;
                            $decile_text = "top $top_percentage%";
                        } else {
                            // For deciles 1 to 5, indicate "bottom X%"
                            $bottom_percentage = $card_decile * 10;
                            $decile_text = "bottom $bottom_percentage%";
                        }
                        

                        $average_replacements["{{decile." . $column . "}}"] = $decile_text;
                    } else {
                        // Format the value using the specified format
                        $formattedValue = formatValuePlaceholders($value, $format);

                        // Create a unique placeholder for each statistic type and column
                        $placeholder = "{{averages." . $type . "_" . $column . "}}";
                        $average_replacements[$placeholder] = $formattedValue;
                    }
                }
            }
        }
    }

    if ((float)$card_data['purchase_interest_rate'] > (float)$average_replacements['{{averages.median_purchase_interest_rate}}']) {
        $difference = (float)$card_data['purchase_interest_rate'] - (float)$average_replacements['{{averages.median_purchase_interest_rate}}'];
        $average_replacements['{{purchase_interest_diff}}'] = $difference . '% more';
    }
    elseif ((float)$card_data['purchase_interest_rate'] < (float)$average_replacements['{{averages.median_purchase_interest_rate}}']) {
        $difference = (float)$average_replacements['{{averages.median_purchase_interest_rate}}'] - (float)$card_data['purchase_interest_rate'];
        $average_replacements['{{purchase_interest_diff}}'] = $difference . '% less';
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
    
    $total_non_null_count = 0;
    
    foreach ($insurance_columns as $column) {
    
        // Assuming $average_replacements is an associative array containing the counts
        // Add the count to the total count
        $total_non_null_count += $averages_returned_database[3][$column];
    }
    
    // Number of rows in the $card_data array
    $num_rows = $average_replacements['{{averages.count_purchase_interest_rate}}'];
    
    // Calculate the average
    $average_count_insurance = $total_non_null_count / 173;

    $average_replacements['{{averages.insurance_count}}'] = number_format($average_count_insurance, 0);

    

    
    
    return $average_replacements;
}


function formatValuePlaceholders($value, $format) {
    
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
        return handleEmptyValue($format); // A separate function to determine what to return for empty values
    }
}

function handleEmptyValue($format) {
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

            
            




function replace_placeholders_with_db_data($card_data) {




    global $wpdb;
    $timings = '';

    $monthly_spend = 2000;
    $annual_spend = $monthly_spend * 12;


    

    
    $results = calculateReward($card_data);
// echo "Total Points: " . $results['totalPoints'];
// echo "Rewards Value Total: " . $results['rewards_value_total'];
// echo "Net Earn Rate: " . $results['net_earn_rate'];


    $proscons_result =  processProsCons($card_data);

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


    
$replacements = array(
        "{{card.name}}" => formatValuePlaceholders($card_data['card_name'], 'string'),
        "{{insurance_count}}" => formatValuePlaceholders($insurance_nonNullCount, 'integer'),
        "{{total_earn_rate}}" => formatValuePlaceholders($results['net_earn_rate'], 'percent'),
        "{{card.max_reward}}" => "$" . number_format($card_data['max_reward']/100, 2),
        '{{score_1}}' => $top_factors[0],
        '{{score_2}}' => $top_factors[1],

        '{{class_factor_score_fees}}' => in_array('factor_score_fees', $largest_keys) ? 'highlight_factor' : '',
    '{{class_factor_score_interest}}' => in_array('factor_score_interest', $largest_keys) ? 'highlight_factor' : '',
    '{{class_factor_score_rewards}}' => in_array('factor_score_rewards', $largest_keys) ? 'highlight_factor' : '',
    '{{class_factor_score_insurance}}' => in_array('factor_score_insurance', $largest_keys) ? 'highlight_factor' : '',
    '{{class_factor_score_perks}}' => in_array('factor_score_perks', $largest_keys) ? 'highlight_factor' : '',

        "{{net_after_fee}}" => formatValuePlaceholders($net_after_fee, 'currency'),

        "{{grocery_dollarrewards}}" => formatValuePlaceholders($card_data['grocery_dollarrewards'], 'currency'),
        "{{other_dollarrewards}}" => formatValuePlaceholders($card_data['other_dollarrewards'], 'currency'),
        "{{gas_dollarrewards}}" => formatValuePlaceholders($card_data['gas_dollarrewards'], 'currency'),
        "{{drug_dollarrewards}}" => formatValuePlaceholders($card_data['drug_dollarrewards'], 'currency'),
        "{{restaurant_dollarrewards}}" => formatValuePlaceholders($card_data['restaurant_dollarrewards'], 'currency'),
        "{{bills_dollarrewards}}" => formatValuePlaceholders($card_data['bills_dollarrewards'], 'currency'),
        "{{travel_dollarrewards}}" => formatValuePlaceholders($card_data['travel_dollarrewards'], 'currency'),
        "{{store_dollarrewards}}" => formatValuePlaceholders($card_data['store_dollarrewards'], 'currency'),

        "{{grocery_earnrate}}" => formatValuePlaceholders($card_data['grocery_earnrate'], 'percent'),
        "{{other_earnrate}}" =>  formatValuePlaceholders($card_data['other_earnrate'], 'percent'),
        "{{gas_earnrate}}" => formatValuePlaceholders($card_data['gas_earnrate'], 'percent'),
        "{{drug_earnrate}}" => formatValuePlaceholders($card_data['drug_earnrate'], 'percent'),
        "{{restaurant_earnrate}}" => formatValuePlaceholders($card_data['restaurant_earnrate'], 'percent'),
        "{{bills_earnrate}}" => formatValuePlaceholders($card_data['bills_earnrate'], 'percent'),
        "{{travel_earnrate}}" =>  formatValuePlaceholders($card_data['travel_earnrate'], 'percent'),
        "{{store_earnrate}}" =>  formatValuePlaceholders($card_data['store_earnrate'], 'percent'),

        "{{factor_score_fee}}" => formatValuePlaceholders($card_data['factor_score_fee'], 'onedecimal'),
        "{{factor_score_interest}}" => formatValuePlaceholders($card_data['factor_score_interest'], 'onedecimal'),
        "{{factor_score_rewards}}" => formatValuePlaceholders($card_data['factor_score_rewards'], 'onedecimal'),
        "{{factor_score_insurance}}" => formatValuePlaceholders($card_data['factor_score_insurance'], 'onedecimal'),
        "{{factor_score_approval}}" => formatValuePlaceholders($card_data['factor_score_approval'], 'onedecimal'),
        "{{factor_score_perks}}" => formatValuePlaceholders($card_data['factor_score_perks'], 'onedecimal'),
        "{{factor_score_acceptance}}" => formatValuePlaceholders($card_data['factor_score_acceptance'], 'onedecimal'),
        

        "{{ranking}}" => $card_data['ranking'],
        "{{card.annualFee}}" => formatValuePlaceholders($card_data['annual_fee'], 'currency'),
        "{{card.rewards}}" => formatValuePlaceholders($results['rewards_value_total'], 'currency'),  // Placeholder; exact column is not clear
        "{{card.introOffer}}" => !empty($card_data['welcome_bonus']) ? $card_data['welcome_bonus'] : "N/A",
        "{{reward_bills}}" => $card_data['reward_bills'],
        "{{reward_drug}}" => $card_data['reward_drug'],
        "{{reward_gas}}" => $card_data['reward_gas'],
        "{{reward_grocery}}" => $card_data['reward_grocery'],
        "{{reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{reward_store}}" => $card_data['reward_store'],
        "{{reward_travel}}" => $card_data['reward_travel'],
        "{{reward_other}}" => $card_data['reward_other'],
        "{{transfer_airlines}}" => $card_data['transfer_airlines'],
        "{{ReviewText}}" => $card_data['ReviewText'],
        "{{issuer_short}}" => $card_data['issuer_short'],
        "{{monthlyspend}}" => formatValuePlaceholders($monthly_spend, 'currency'),

        "{{annualspend}}" => formatValuePlaceholders($annual_spend, 'currency'),

        "{{credit_score_low}}" => $card_data['credit_score_low'],
        "{{credit_score_high}}" => $card_data['credit_score_high'],
        "{{personal_income}}" => formatValuePlaceholders($card_data['personal_income'], 'currency'),
        "{{household_income}}" => formatValuePlaceholders($card_data['household_income'], 'currency'),
        "{{purchase_interest_rate}}" => $card_data['purchase_interest_rate'],
        "{{cash_advance_interest_rate}}" => $card_data['cash_advance_interest_rate'],
        "{{balance_transfer_interest_rate}}" => $card_data['balance_transfer_interest_rate'],
        "{{card_type}}" => $card_data['card_type'],
        "{{warranty}}" => $card_data['warranty'],
        "{{emergency_medical_term}}" => $card_data['emergency_medical_term'],
        "{{trip_cancellation}}" => formatValuePlaceholders($card_data['trip_cancellation'], 'currency'),
        "{{baggage_delay_insurance}}" => formatValuePlaceholders($card_data['baggage_delay_insurance'], 'currency'),
        "{{Redemption}}" => $card_data['Redemption'],
        "{{reward_bills}}" => $card_data['reward_bills'],
        "{{reward_drug}}" => $card_data['reward_drug'],
        "{{reward_gas}}" => $card_data['reward_gas'],
        "{{reward_grocery}}" => $card_data['reward_grocery'],
        "{{reward_restaurant}}" => $card_data['reward_restaurant'],
        "{{reward_store}}" => $card_data['reward_store'],
        "{{reward_travel}}" => $card_data['reward_travel'],
        "{{reward_other}}" => $card_data['reward_other'],
        "{{transfer_airlines}}" => formatValuePlaceholders($card_data['transfer_airlines']*$totalPoints, 'currency'),
        "{{Pros}}" => $proscons_result['pros'],
        "{{Cons}}" => $proscons_result['cons'],
        "{{fixed_points_travel}}" => formatValuePlaceholders($card_data['fixed_points_travel']*$totalPoints, 'currency'),
        "{{transfer_hotel}}" => formatValuePlaceholders($card_data['transfer_hotel']*$totalPoints, 'currency'),
        "{{redeem_travel}}" => formatValuePlaceholders($card_data['redeem_travel']*$totalPoints, 'currency'),
        "{{statement_credit}}" => formatValuePlaceholders($card_data['statement_credit']*$totalPoints, 'currency'),
        "{{ticketmaster}}" => formatValuePlaceholders($card_data['ticketmaster']*$totalPoints, 'currency'),
        "{{charity}}" => formatValuePlaceholders($card_data['charity']*$totalPoints, 'currency'),
        "{{gift_cards}}" => formatValuePlaceholders($card_data['gift_cards']*$totalPoints, 'currency'),
        "{{amazon}}" => formatValuePlaceholders($card_data['amazon']*$totalPoints, 'currency'),
        "{{merchandise}}" => formatValuePlaceholders($card_data['merchandise']*$totalPoints, 'currency'),
        "{{investments}}" => formatValuePlaceholders($card_data['investments']*$totalPoints, 'currency'),
        "{{experiences}}" => formatValuePlaceholders($card_data['experiences']*$totalPoints, 'currency'),
        "{{car_rental}}" => formatValuePlaceholders($card_data['car_rental']*$totalPoints, 'currency'),
        "{{vacation}}" => formatValuePlaceholders($card_data['vacation']*$totalPoints, 'currency'),
        "{{attractions}}" => formatValuePlaceholders($card_data['attractions']*$totalPoints, 'currency'),
        "{{cash_rewards}}" => formatValuePlaceholders($card_data['cash_rewards']*$totalPoints, 'currency'),
        "{{grocery_rewards}}" => formatValuePlaceholders($card_data['grocery_rewards']*$totalPoints, 'currency'),
        "{{restaurant_rewards}}" => formatValuePlaceholders($card_data['restaurant_rewards']*$totalPoints, 'currency'),
        "{{movie_rewards}}" => formatValuePlaceholders($card_data['movie_rewards']*$totalPoints, 'currency'),
        "{{apple_bestbuy}}" => formatValuePlaceholders($card_data['apple_bestbuy']*$totalPoints, 'currency'),
        "{{flight_rewards}}" => formatValuePlaceholders($card_data['flight_rewards']*$totalPoints, 'currency'),
        "{{airlines_rewards_chart}}" => formatValuePlaceholders($card_data['airlines_rewards_chart']*$totalPoints, 'currency'),
        "{{cibc_financial_products}}" => formatValuePlaceholders($card_data['cibc_financial_products']*$totalPoints, 'currency'),
        "{{air_travel_redemptions_schedule}}" => formatValuePlaceholders($card_data['air_travel_redemptions_schedule']*$totalPoints, 'currency'),
        "{{rbc_travel}}" => formatValuePlaceholders($card_data['rbc_travel']*$totalPoints, 'currency'),
        "{{transfer_westjet}}" => formatValuePlaceholders($card_data['transfer_westjet']*$totalPoints, 'currency'),
        "{{transfer_bay}}" => formatValuePlaceholders($card_data['transfer_bay']*$totalPoints, 'currency'),
        "{{rbc_financial_products_rewards}}" => formatValuePlaceholders($card_data['rbc_financial_products_rewards']*$totalPoints, 'currency'),
        "{{aircanada_gift_card}}" => formatValuePlaceholders($card_data['aircanada_gift_card']*$totalPoints, 'currency'),
        "{{air_canada_vacations}}" => formatValuePlaceholders($card_data['air_canada_vacations']*$totalPoints, 'currency'),
        "{{electronics_gift_cards}}" => formatValuePlaceholders($card_data['electronics_gift_cards']*$totalPoints, 'currency'),
        "{{cash_worldelite}}" => formatValuePlaceholders($card_data['cash_worldelite']*$totalPoints, 'currency'),
        "{{cash_platinumplus}}" => formatValuePlaceholders($card_data['cash_platinumplus']*$totalPoints, 'currency'),
        "{{banking_plans}}" => formatValuePlaceholders($card_data['banking_plans']*$totalPoints, 'currency'),
        "{{desjardins_financial_products}}" => formatValuePlaceholders($card_data['desjardins_financial_products']*$totalPoints, 'currency'),
        "{{expedia_td}}" => formatValuePlaceholders($card_data['expedia_td']*$totalPoints, 'currency'),
        "{{education_rewards}}" => formatValuePlaceholders($card_data['education_rewards']*$totalPoints, 'currency'),
        "{{hsbc_financial_products}}" => formatValuePlaceholders($card_data['hsbc_financial_products']*$totalPoints, 'currency'),
        "{{walmart_rewards}}" => formatValuePlaceholders($card_data['walmart_rewards']*$totalPoints, 'currency'),
        "{{triangle_rewards}}" => formatValuePlaceholders($card_data['triangle_rewards']*$totalPoints, 'currency'),
        "{{meridian_travel}}" => formatValuePlaceholders($card_data['meridian_travel']*$totalPoints, 'currency'),
        "{{direct_deposit_rewards}}" => formatValuePlaceholders($card_data['direct_deposit_rewards']*$totalPoints, 'currency'),
        "{{costco_gift_cards}}" => formatValuePlaceholders($card_data['costco_gift_cards']*$totalPoints, 'currency'),
        "{{wireless_rogers_rewards}}" => formatValuePlaceholders($card_data['wireless_rogers_rewards']*$totalPoints, 'currency'),
        "{{1_roger_rewards}}" => formatValuePlaceholders($card_data['1_roger_rewards']*$totalPoints, 'currency'),
        "{{other_roger_rewards}}" => formatValuePlaceholders($card_data['other_roger_rewards']*$totalPoints, 'currency'),
        "{{other_1_roger_rewards}}" => formatValuePlaceholders($card_data['other_1_roger_rewards']*$totalPoints, 'currency'),
        "{{purchase_protection}}" => $card_data['purchase_protection'],
        "{{travel_accident}}" => formatValuePlaceholders($card_data['travel_accident'], 'currency'),
        "{{emergency_medical_65}}" => $card_data['emergency_medical_65'],
        "{{trip_interruption}}" => formatValuePlaceholders($card_data['trip_interruption'], 'currency'),
        "{{flight_delay}}" => formatValuePlaceholders($card_data['flight_delay'], 'currency'),
        "{{stolen_baggage}}" => formatValuePlaceholders($card_data['stolen_baggage'],'currency'),
        "{{event_cancel}}" => formatValuePlaceholders($card_data['event_cancel'],'currency'),
        "{{rental_theft_damage}}" => formatValuePlaceholders($card_data['rental_theft_damage'],'currency'),
        "{{rental_personal}}" => formatValuePlaceholders($card_data['rental_personal'],'currency'),
        "{{rental_accident}}" => formatValuePlaceholders($card_data['rental_accident'],'currency'),
        "{{hotel_burglary}}" => formatValuePlaceholders($card_data['hotel_burglary'],'currency'),
        "{{mobile_insurance}}" => formatValuePlaceholders($card_data['mobile_insurance'],'currency'),
        "{{personal_effects}}" => formatValuePlaceholders($card_data['personal_effects'],'currency'),
        "{{price_protection}}" => $card_data['price_protection'],
        "{{Foreign}}" => $card_data['Foreign'],
        "{{IncomeMin}}" => $card_data['IncomeMin'],
        "{{Features}}" => $card_data['Features'],
        "{{total_net_rewards}}" => formatValuePlaceholders($results['rewards_value_total'], 'currency'),
        
        
        
        

    );

    //  // Filter out placeholders with empty or 0 values
    //  $replacements = array_filter($replacements, function($value) {
    //     return !empty($value) && $value !== '0' && $value !== '0.0' && $value !== '0.00';
    // });

    

    return $replacements;

}

function calculateReward($data) {
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



function processProsCons($data) {
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




add_filter('render_block', 'modify_block_content_based_on_placeholders', 10, 2);

add_filter('render_block', 'modify_block_content_averages', 10, 2);

}}}}

add_action('wp', 'run_my_plugin_logic');




?>