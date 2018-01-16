<?php
Class pageObjects{


  public $cities = array(array('destination'=>'BEY Beirut, Lebanon', 'origin' => 'CAI Cairo, Egypt'),
  array('destination'=>'DOH Doha, Qatar', 'origin' => 'BEL Belem, Brazil'),
  array('destination'=>'DXB Dubai, United Arab Emirates', 'origin' => 'EBJ Esbjerg, Denmark'),
  array('destination'=>'AMM Amman, Jordan', 'origin' => 'MSY New Orleans, United States'),
  array('destination'=>'KWI Kuwait, Kuwait - Kuwait International Airport', 'origin' => 'PBM Paramaribo, Suriname'));


  public $origin_field = "#flights-search-origin-1";
  public $destination = "#flights-search-destination-1";
  public $date_picker = ".js-datepicker-input.form-control.col-md-5.date-mob.www-srchf__dat-wrpr__date-mob";
  public $next_month = ".pika-next";
  public $title_selector = "body";
  public $passengers_selector = ".js-pax-title";
  public $add_adult = '.tj-icon.tj-icon--add-c';
  public $search_button = "#flights-search-cta";
  public $aria = "//td[@aria-selected = 'true'][1]";
  public $ariaTwo = "//td[@aria-selected = 'true']";
  public $flightR = '#flights-results-change-modify-cta';
  public $s_origin = '#flights-search-origin-0';
  public $s_destination = "#flights-search-destination-0";
  public $t_day = "//p[contains(@class, 'picker-input__text-big')][1]";
  public $r_day = ".picker-input__text-big";
  public $travel_class = ".www-srchf__opt__drop__cabin.dropdown-toggle>p";
  public $passengers = ".www-srchf__opt__drop__pax.dropdown-toggle>p";
  public $f_results = "#flights-results-select-cta-btn-desktop-0";
  public $first_price = "#serch-result-item-group-0 .search-result-action-a .search-result-item__itinerary-price-detail .price-display:nth-child(2)";
  public $price_container = 'h2.pull-right';
  public $container_selector = "//h2[contains(@class, 'pull-right')]";
  public $passenger_fare = ".tj-rate__price";
  public $title_0 = '#flights-summary-travelers-form-title-0';
  public $title_1 = '#flights-summary-travelers-form-title-1';
  public $first_0 = '#flights-summary-travelers-form-first-name-0';
  public $middle_0 = '#flights-summary-travelers-form-middle-name-0';
  public $last_0 ='#flights-summary-travelers-form-last-name-0';
  public $first_1 = '#flights-summary-travelers-form-first-name-1';
  public $middle_1 = '#flights-summary-travelers-form-middle-name-1';
  public $last_1 ='#flights-summary-travelers-form-last-name-1';

  public function get_next_day()
  {
    return $next_day = '//td[@data-day="'.rand(1,28).'"]';
  }

}
