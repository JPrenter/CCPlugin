<?php

$vstemp_template = <<<HTML
<!-- Your HTML template here -->
<style>
    #primary {
    padding: 0 0 !important;
    margin: 0 !important;
    }
</style>


<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"var:preset|spacing|50","margin":{"top":"0","bottom":"0"}}},"layout":{"inherit":true,"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","right":"0px","bottom":"0px","left":"0px"},"margin":{"top":"0","bottom":"0"},"blockGap":{"top":"0","left":"0"}},"color":{"text":"#515e5f"},"elements":{"link":{"color":{"text":"#515e5f"}}}},"className":"post-disclosure-breadcrumbs"} -->
<div class="wp-block-columns is-not-stacked-on-mobile post-disclosure-breadcrumbs has-text-color has-link-color" style="color:#515e5f;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--20);padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:column {"verticalAlignment":"top","width":"60%","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-top" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;flex-basis:60%"><!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"12px"}}} -->
<p class="has-text-align-left" style="font-size:12px"><a href="https://www.dollarwise.ca/credit-cards/" data-type="page" data-id="3804">TD</a> > <a href="https://www.dollarwise.ca/best-scotiabank-credit-cards/" data-type="page" data-id="7914">Scotiabank</a> > <a href="https://www.dollarwise.ca/best-aeroplan-credit-cards/" data-type="page" data-id="7918">Aeroplan</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"40%","style":{"spacing":{"padding":{"right":"0","left":"0"}}}} -->
<div class="wp-block-column is-vertically-aligned-top" style="padding-right:0;padding-left:0;flex-basis:40%"><!-- wp:paragraph {"align":"right","style":{"typography":{"fontSize":"12px"}}} -->
<p class="has-text-align-right" style="font-size:12px"><a href="https://www.dollarwise.ca/about#disclosure/" data-type="page" data-id="1393">Advertising disclosure</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td><strong>Annual Fee</strong></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{first_card.annualFee}}</strong></mark></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{second_card.annualFee}}</strong></mark></td></tr><tr><td><strong>Annual Rewards</strong></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{first_card.rewards}}</strong></mark></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{second_card.rewards}}</strong></mark></mark></td></tr><tr><td><strong>Intro Offer</strong></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{first_card.introOffer}}</strong></mark></td><td class="has-text-align-center" data-align="center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-ast-global-color-0-color"><strong>{{second_card.introOffer}}</strong></mark></mark></td></tr><tr><td><strong>Why it's Good</strong></td><td class="has-text-align-center" data-align="center">{{first_Pros}}</td><td class="has-text-align-center" data-align="center">{{second_Pros}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph {"style":{"color":{"background":"#f8f8f8","text":"#929a9b"},"elements":{"link":{"color":{"text":"#929a9b"}}}},"fontSize":"small"} -->
<p class="has-text-color has-background has-link-color has-small-font-size" style="color:#929a9b;background-color:#f8f8f8">Editorial Note: DollarWise may earn a commission on sales made from partner links on this page.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Performance test results</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>At DollarWise, for each credit card <strong>we test 7 different factors </strong>including the rewards, value for money, perks, insurance, strengths and weaknesses of the card.<a href="https://www.dollarwise.ca/blog/american-express-cobalt-review/" target="_blank" rel="noreferrer noopener"></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>You can <a href="http://credit-card-testing-methodology">see our full t</a><a href="/credit-card-testing-methodology">e</a><a href="https://www.dollarwise.ca/credit-card-testing-methodology/" data-type="link" data-id="https://www.dollarwise.ca/credit-card-testing-methodology/">sting methodology here</a> to learn why we're the most trusted source for credit card reviews.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Reward rates</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>To compare the <strong>{{first_card.name}}</strong> vs the <strong>{{second_card.name}}</strong>, let's look at the rates at which you earn rewards for different spending categories <strong>per dollar you spend</strong>:</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Bills</td><td class="has-text-align-center" data-align="center">{{first_reward_bills}}</td><td class="has-text-align-center" data-align="center">{{second_reward_bills}}</td></tr><tr><td>Pharmacy</td><td class="has-text-align-center" data-align="center">{{first_reward_drug}}</td><td class="has-text-align-center" data-align="center">{{second_reward_drug}}</td></tr><tr><td>Gas</td><td class="has-text-align-center" data-align="center">{{first_reward_gas}}</td><td class="has-text-align-center" data-align="center">{{second_reward_gas}}</td></tr><tr><td>Groceries</td><td class="has-text-align-center" data-align="center">{{first_reward_grocery}}</td><td class="has-text-align-center" data-align="center">{{second_reward_grocery}}</td></tr><tr><td>Restaurants</td><td class="has-text-align-center" data-align="center">{{first_reward_restaurant}}</td><td class="has-text-align-center" data-align="center">{{second_reward_restaurant}}</td></tr><tr><td>Specific Stores</td><td class="has-text-align-center" data-align="center">{{first_reward_store}}</td><td class="has-text-align-center" data-align="center">{{second_reward_store}}</td></tr><tr><td>Travel</td><td class="has-text-align-center" data-align="center">{{first_reward_travel}}</td><td class="has-text-align-center" data-align="center">{{second_reward_travel}}</td></tr><tr><td>Other Spend</td><td class="has-text-align-center" data-align="center">{{first_reward_other}}</td><td class="has-text-align-center" data-align="center">{{second_reward_other}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Comparing annual rewards</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We estimate that spending {{monthlyspend}} per month with the {{first_card.name}} would earn <strong>{{first_card.rewards}} in rewards </strong>over the year and with the {{second_card.name}} you would earn <strong>{{second_card.rewards}} in rewards</strong>.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Our performance testing research uses an accurate estimation of the average Canadian households spending patterns to predict the rewards a card will earn.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Our study investigating the value of the rewards found that the value of the rewards is worth up to {{first_card.max_reward}} per point for {{first_card.name}} and up to {{second_card.max_reward}} per point for {{second_card.name}}, <strong>depending on how you redeem</strong>.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>With these values, we can compare the {{first_card.name}} vs {{second_card.name}} based on the amount earned by spend category:</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Bills</td><td class="has-text-align-center" data-align="center">{{first_bills_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_bills_dollarrewards}}</td></tr><tr><td>Pharmacy</td><td class="has-text-align-center" data-align="center">{{first_drug_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_drug_dollarrewards}}</td></tr><tr><td>Gas</td><td class="has-text-align-center" data-align="center">{{first_gas_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_gas_dollarrewards}}</td></tr><tr><td>Groceries</td><td class="has-text-align-center" data-align="center">{{first_grocery_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_grocery_dollarrewards}}</td></tr><tr><td>Restaurants</td><td class="has-text-align-center" data-align="center">{{first_restaurant_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_restaurant_dollarrewards}}</td></tr><tr><td>Specific Stores</td><td class="has-text-align-center" data-align="center">{{first_store_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_store_dollarrewards}}</td></tr><tr><td>Travel</td><td class="has-text-align-center" data-align="center">{{first_travel_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_travel_dollarrewards}}</td></tr><tr><td>Other Spend</td><td class="has-text-align-center" data-align="center">{{first_other_dollarrewards}}</td><td class="has-text-align-center" data-align="center">{{second_other_dollarrewards}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>The {{first_card.name}} earns {{first_card.rewards}} in rewards<strong> </strong>over the year compared to the {{second_card.name}} which earns {{second_card.rewards}} in rewards.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"background":"#4fb9650d"}},"className":"tax-canada-fact-box"} -->
<p class="tax-canada-fact-box has-background" style="background-color:#4fb9650d">{{rewards_difference}}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For comparison, the average credit card in our database earns {{averages.mean_annual_rewards}} in rewards for the same spend that the {{rewards_avg_text}}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>{{better_rewards_text}}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The more that you spend on your credit card each month, the larger the difference in the rewards value earned between these two cards. So, for higher spenders the {{winner_rewards}} has an advantage.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We can also compare these cards by looking at the earn rate by category.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>This earn rate is the percentage return that you would get when you spend, assuming you redeem at the predicted maximum value.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For example, if a card earned 5 points per dollar on gas and each point is worth up to $0.02, then the earn rate is 5 points multiplied by $0.02 each, divided by the dollar you spent.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>In this example, that's a 10% earn rate on gas.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Bills</td><td class="has-text-align-center" data-align="center">{{first_bills_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_bills_earnrate}}</td></tr><tr><td>Pharmacy</td><td class="has-text-align-center" data-align="center">{{first_drug_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_drug_earnrate}}</td></tr><tr><td>Gas</td><td class="has-text-align-center" data-align="center">{{first_gas_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_gas_earnrate}}</td></tr><tr><td>Groceries</td><td class="has-text-align-center" data-align="center">{{first_grocery_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_grocery_earnrate}}</td></tr><tr><td>Restaurants</td><td class="has-text-align-center" data-align="center">{{first_restaurant_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_restaurant_earnrate}}</td></tr><tr><td>Specific Stores</td><td class="has-text-align-center" data-align="center">{{first_store_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_store_earnrate}}</td></tr><tr><td>Travel</td><td class="has-text-align-center" data-align="center">{{first_travel_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_travel_earnrate}}</td></tr><tr><td>Other Spend</td><td class="has-text-align-center" data-align="center">{{first_other_earnrate}}</td><td class="has-text-align-center" data-align="center">{{second_other_earnrate}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>The {{first_card.name}} earns {{first_bills_earnrate}} for every dollar spent on bills, compared to the {{second_card.name}} which earns {{second_bills_earnrate}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For spend at your pharmacy the {{second_card.name}} earns {{second_drug_earnrate}} while the {{first_card.name}} earns {{first_bills_earnrate}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>On gas, you'll earn {{first_gas_earnrate}} with the {{first_card.name}} and {{second_gas_earnrate}} with the {{second_card.name}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For an annual spend of {{annualspend}}, we estimated annual rewards value at up to {{first_card.rewards}} for the {{first_card.name}} and {{second_card.rewards}} for the {{second_card.name}}.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Fees: {{second_card.name}} vs {{first_card.name}}</h2>
<!-- /wp:heading -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Annual Fee</td><td class="has-text-align-center" data-align="center">{{first_card.annualFee}}</td><td class="has-text-align-center" data-align="center">{{second_card.annualFee}}</td></tr><tr><td>Net Rewards</td><td class="has-text-align-center" data-align="center">{{first_net_after_fee}}</td><td class="has-text-align-center" data-align="center">{{second_net_after_fee}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>The {{first_card.name}} has a {{first_card.annualFee}} annual fee, whereas the {{second_card.name}} has a {{second_card.annualFee}} annual fee.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For comparison, the average card charges {{averages.mean_annual_fee}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>After deducting the annual fees, we predicted net annual rewards of {{first_net_after_fee}} for the {{first_card.name}} and net annual rewards of {{second_net_after_fee}} for the {{second_card.name}}.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Perks</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We manually reviewed the perks of the {{first_card.name}} vs the {{second_card.name}} to determine how they compare.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The {{first_card.name}} scored a {{first_factor_score_perks}} out of 5 for perks, in comparison the {{second_card.name}} scored a {{second_factor_score_perks}} out of 5 for perks.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The average card scores {{averages.mean_factor_score_perks}} out of 5 for perks.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Interest Rates</h2>
<!-- /wp:heading -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Purchase</td><td class="has-text-align-center" data-align="center">{{first_purchase_interest_rate}}%</td><td class="has-text-align-center" data-align="center">{{second_purchase_interest_rate}}%</td></tr><tr><td>Cash Advance</td><td class="has-text-align-center" data-align="center">{{first_cash_advance_interest_rate}}%</td><td class="has-text-align-center" data-align="center">{{second_cash_advance_interest_rate}}%</td></tr><tr><td>Balance Transfer</td><td class="has-text-align-center" data-align="center">{{first_balance_transfer_interest_rate}}%</td><td class="has-text-align-center" data-align="center">{{second_balance_transfer_interest_rate}}%</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>The average credit card has a purchase interest rate of {{averages.mean_purchase_interest_rate}}%, whereas the {{first_card.name}} charges {{first_purchase_interest_rate}}% and the {{second_card.name}} charges {{second_purchase_interest_rate}}%.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Comparing these purchase interest rates, we can see that {{interest_diff}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>For cash advances it costs {{first_cash_advance_interest_rate}}% and {{second_cash_advance_interest_rate}}%, respectively.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Insurance coverage</h2>
<!-- /wp:heading -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Extended Warranty<strong></strong></td><td class="has-text-align-center" data-align="center">{{first_warranty}}</td><td class="has-text-align-center" data-align="center">{{second_warranty}}</td></tr><tr><td>Purchase Protection</td><td class="has-text-align-center" data-align="center">{{first_purchase_protection}}</td><td class="has-text-align-center" data-align="center">{{second_purchase_protection}}</td></tr><tr><td>Travel Accident</td><td class="has-text-align-center" data-align="center">{{first_travel_accident}}</td><td class="has-text-align-center" data-align="center">{{second_travel_accident}}</td></tr><tr><td>Emergency Medical Term</td><td class="has-text-align-center" data-align="center">{{first_emergency_medical_term}}</td><td class="has-text-align-center" data-align="center">{{second_emergency_medical_term}}</td></tr><tr><td>Emergency Medical over 65</td><td class="has-text-align-center" data-align="center">{{first_emergency_medical_65}}</td><td class="has-text-align-center" data-align="center">{{second_emergency_medical_65}}</td></tr><tr><td>Trip Cancellation</td><td class="has-text-align-center" data-align="center">{{first_trip_cancellation}}</td><td class="has-text-align-center" data-align="center">{{second_trip_cancellation}}</td></tr><tr><td>Trip Interruption</td><td class="has-text-align-center" data-align="center">{{first_trip_interruption}}</td><td class="has-text-align-center" data-align="center">{{second_trip_interruption}}</td></tr><tr><td>Flight Delay</td><td class="has-text-align-center" data-align="center">{{first_flight_delay}}</td><td class="has-text-align-center" data-align="center">{{second_flight_delay}}</td></tr><tr><td>Baggage Delay</td><td class="has-text-align-center" data-align="center">{{first_baggage_delay_insurance}}</td><td class="has-text-align-center" data-align="center">{{second_baggage_delay_insurance}}</td></tr><tr><td>Lost or Stolen Baggage</td><td class="has-text-align-center" data-align="center">{{first_stolen_baggage}}</td><td class="has-text-align-center" data-align="center">{{second_stolen_baggage}}</td></tr><tr><td>Event Cancellation</td><td class="has-text-align-center" data-align="center">{{first_event_cancel}}</td><td class="has-text-align-center" data-align="center">{{second_event_cancel}}</td></tr><tr><td>Rental Car Theft &amp; Damage</td><td class="has-text-align-center" data-align="center">{{first_rental_theft_damage}}</td><td class="has-text-align-center" data-align="center">{{second_rental_theft_damage}}</td></tr><tr><td>Rental Car Personal Effects</td><td class="has-text-align-center" data-align="center">{{first_rental_personal}}</td><td class="has-text-align-center" data-align="center">{{second_rental_personal}}</td></tr><tr><td>Rental Car Accident</td><td class="has-text-align-center" data-align="center">{{first_rental_accident}}</td><td class="has-text-align-center" data-align="center">{{second_rental_accident}}</td></tr><tr><td>Hotel Burglary</td><td class="has-text-align-center" data-align="center">{{first_hotel_burglary}}</td><td class="has-text-align-center" data-align="center">{{second_hotel_burglary}}</td></tr><tr><td>Mobile Phone Insurance</td><td class="has-text-align-center" data-align="center">{{first_mobile_insurance}}</td><td class="has-text-align-center" data-align="center">{{second_mobile_insurance}}</td></tr><tr><td>Personal Effects Insurance</td><td class="has-text-align-center" data-align="center">{{first_personal_effects}}</td><td class="has-text-align-center" data-align="center">{{second_personal_effects}}</td></tr><tr><td>Price Protection Insurance</td><td class="has-text-align-center" data-align="center">{{first_price_protection}}</td><td class="has-text-align-center" data-align="center">{{second_price_protection}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>We scored the {{first_card.name}} a {{first_factor_score_insurance}} out of 5 for insurance, compared to the {{second_card.name}} which scored a {{second_factor_score_insurance}} out of 5.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The {{first_card.name}} offers {{first_insurance_count}} types of insurance, whereas the {{second_card.name}} has {{second_insurance_count}}.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Approval and qualifying</h2>
<!-- /wp:heading -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Estimated Credit Score</td><td class="has-text-align-center" data-align="center">{{first_credit_score_low}} - {{first_credit_score_high}}</td><td class="has-text-align-center" data-align="center">{{second_credit_score_low}} - {{second_credit_score_high}}</td></tr><tr><td>Personal Income</td><td class="has-text-align-center" data-align="center">{{first_personal_income}}</td><td class="has-text-align-center" data-align="center">{{second_personal_income}}</td></tr><tr><td>Household Income</td><td class="has-text-align-center" data-align="center">{{first_household_income}}</td><td class="has-text-align-center" data-align="center">{{second_household_income}}</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>We scored the {{first_card.name}} a {{first_factor_score_approval}} out of 5 for approval and the {{second_card.name}} a {{second_factor_score_approval}}.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We predict that you will require a credit score of at least {{first_credit_score_low}} to qualify for the {{first_card.name}}, while the {{second_card.name}} requires {{second_credit_score_low}} to qualify.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"isStackedOnMobile":false} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><a href="https://{{first_link}}"><strong>{{first_card.name}}</strong></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6599" style="width: 150px;" src="{{first_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{first_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong><a href="https://{{second_link}}">{{second_card.name}}</a></strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><img class="wp-image-6511" style="width: 150px;" src="{{second_card.Photos}}" alt=""></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"center"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"ast-global-color-0","width":100,"style":{"border":{"radius":"5px"}},"className":"is-style-fill","fontSize":"medium"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size"><a class="wp-block-button__link has-ast-global-color-0-background-color has-background wp-element-button" href="https://{{second_afflink}}" style="border-radius:5px" rel="">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:table {"hasFixedLayout":true,"className":"comparison-table"} -->
<figure class="wp-block-table comparison-table"><table class="has-fixed-layout"><tbody><tr><td>Annual Fee</td><td class="has-text-align-center" data-align="center">{{first_card.annualFee}}</td><td class="has-text-align-center" data-align="center">{{second_card.annualFee}}</td></tr><tr><td>Extra Card Fee</td><td class="has-text-align-center" data-align="center">{{first_card.annualFee}}</td><td class="has-text-align-center" data-align="center">{{second_card.annualFee}}</td></tr><tr><td>Card type</td><td class="has-text-align-center" data-align="center">{{first_card_type}}</td><td class="has-text-align-center" data-align="center">{{second_card_type}}</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:group -->
HTML;
?>