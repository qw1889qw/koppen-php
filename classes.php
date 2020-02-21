<?php

class InputList {
  public function __construct($arr = []) {
    foreach ($arr as $input_key => $input_value) {
      $this->$input_key = $input_value;
    }
    // convert rainfall from strings to floats/doubles just to avoid any potential coercion issues
    foreach (self::$rain_array as $month) {
      $month_in = $month[0];
      $this->$month_in = (float) $this->$month_in;
      // if using imperial system, convert inches to mm for Am/Aw/As calculations
      $month_mm = $month[1];
      $this->$month_mm = $this->$month_in * 25.4;
      // get total annual rainfall
      $this->total_rainfall_mm += $this->$month_mm;
      // get summer rainfall (Apr-Sep for northern hemisphere, Oct-Mar for southern)
      if ($this->hemisphere === 'north') {
        if (in_array($month_in, ['rain_apr', 'rain_may', 'rain_jun', 'rain_jul', 'rain_aug', 'rain_sep'])) {
          $this->summer_rainfall_mm += $this->$month_mm;
        }
      } else {
        if (in_array($month_in, ['rain_oct', 'rain_nov', 'rain_dec', 'rain_jan', 'rain_feb', 'rain_mar'])) {
          $this->summer_rainfall_mm += $this->$month_mm;
        }
      }
    }
    // get monthly average temperatures
    $this->get_avg_month_temps();
    // get annual average temperature in Fahrenheit & Celsius
    $this->avg_temp_array = [];
    $this->avg_temp_array_c = [];
    foreach (self::$avg_array as $month_avg) {
      $this->avg_temp_array[] = $this->$month_avg;
      $this->avg_temp_array_c[] = ($this->$month_avg - 32) / 1.8;
    }
    $this->avg_annual_temp_f = array_sum($this->avg_temp_array) / 12;
    $this->avg_annual_temp_c = ($this->avg_annual_temp_f - 32) / 1.8;
  }
  public function get_avg_month_temps() {
    $this->avg_temp_jan = mean($this->high_temp_jan, $this->low_temp_jan);
    $this->avg_temp_feb = mean($this->high_temp_feb, $this->low_temp_feb);
    $this->avg_temp_mar = mean($this->high_temp_mar, $this->low_temp_mar);
    $this->avg_temp_apr = mean($this->high_temp_apr, $this->low_temp_apr);
    $this->avg_temp_may = mean($this->high_temp_may, $this->low_temp_may);
    $this->avg_temp_jun = mean($this->high_temp_jun, $this->low_temp_jun);
    $this->avg_temp_jul = mean($this->high_temp_jul, $this->low_temp_jul);
    $this->avg_temp_aug = mean($this->high_temp_aug, $this->low_temp_aug);
    $this->avg_temp_sep = mean($this->high_temp_sep, $this->low_temp_sep);
    $this->avg_temp_oct = mean($this->high_temp_oct, $this->low_temp_oct);
    $this->avg_temp_nov = mean($this->high_temp_nov, $this->low_temp_nov);
    $this->avg_temp_dec = mean($this->high_temp_dec, $this->low_temp_dec);
  }
  public function print_self() {
    print_r($this);
  }
  protected static $avg_array = ['avg_temp_jan', 'avg_temp_feb', 'avg_temp_mar',
                                 'avg_temp_apr', 'avg_temp_may', 'avg_temp_jun',
                                 'avg_temp_jul', 'avg_temp_aug', 'avg_temp_sep',
                                 'avg_temp_oct', 'avg_temp_nov', 'avg_temp_dec'];
  protected static $rain_array = [
    ['rain_jan', 'rain_jan_mm'], ['rain_feb', 'rain_feb_mm'],
    ['rain_mar', 'rain_mar_mm'], ['rain_apr', 'rain_apr_mm'],
    ['rain_may', 'rain_may_mm'], ['rain_jun', 'rain_jun_mm'],
    ['rain_jul', 'rain_jul_mm'], ['rain_aug', 'rain_aug_mm'],
    ['rain_sep', 'rain_sep_mm'], ['rain_oct', 'rain_oct_mm'],
    ['rain_nov', 'rain_nov_mm'], ['rain_dec', 'rain_dec_mm']
  ];

  protected $total_rainfall_mm = 0;
  protected $summer_rainfall_mm = 0;
  public function get_total_rainfall_mm() {
    return $this->total_rainfall_mm;
  }
  protected $tropical_threshold = 0;
  protected $dry_threshold = 0;

  protected $avg_annual_temp_f = 0;
  protected $avg_annual_temp_c = 0;

  // A (tropical) climates

  public function is_tropical() {
    // tropical climates have average temps for every month above 64.4 degrees F
    foreach (self::$avg_array as $avg_month_temp) {
      if ($this->$avg_month_temp < 64.4) { // $this->$avg_month_temp is a double
        return false;
      }
    }
    return true;
  }
  public function is_af() {
    foreach (self::$rain_array as $month_rain) {
      if ($this->{$month_rain[1]} < 60) {
        return false;
      }
    }
    return true;
  }
  public function is_am_or_aw_as() {
    // get rainfall threshold to distinguish between Am & Aw/As
    $this->tropical_threshold = 100 - ($this->total_rainfall_mm / 25);
    // find rainfall for least rainy month; if this is greater than $tropical_threshold, it's Am, otherwise Aw/As
    $rain_array_mm = array_map('get_second_element', self::$rain_array);
    $each_rainfall_mm = [];
    foreach ($rain_array_mm as $month_mm) {
      $each_rainfall_mm[] = $this->$month_mm;
    }
    $min_rainfall = min($each_rainfall_mm);
    if ($min_rainfall >= $this->tropical_threshold) {
      return 'am';
    }
    return 'aw/as';
  }

  // B (dry) climates

  public function is_dry() {
    // get rainfall threshold to distinguish between BW & BS
    $summer_rainfall_ratio = $this->summer_rainfall_mm / $this->total_rainfall_mm;
    // 280 if >=70% rainfall during summer; 140 if 30-70%; 0 if <30%
    if ($summer_rainfall_ratio >= .7) {
      $amount_to_add = 280;
    } elseif ($summer_rainfall_ratio >= .3 && $summer_rainfall_ratio < .7) {
      $amount_to_add = 140;
    } else {
      $amount_to_add = 0;
    }
    $this->dry_threshold = ($this->avg_annual_temp_c * 20) + $amount_to_add;
    if ($this->total_rainfall_mm > $this->dry_threshold) {
      return false;
    }
    return true;
  }
  public function is_bw_or_bs() {
    // if total rainfall less than 50% of threshold, it's BW; otherwise, it's BS */
    if ($this->total_rainfall_mm < ($this->dry_threshold / 2)) {
      return 'bw';
    }
    return 'bs';
  }
  public function is_dry_hot_or_cold() {
    // if average annual temp at least 18 degrees C, it's hot; otherwise, it's cold
    if ($this->avg_annual_temp_c >= 18) {
      return 'h';
    }
    return 'k';
  }

  // C (temperate) climates
  public function is_temperate() {
    // if not all months average above 0 or -3 deg C (depending on isotherm) or no months average above 10 deg C, it's not temperate
    $num_months_above_10_c = count(array_filter($this->avg_temp_array_c, function($element) {
      return $element > 10;
    }));
    if ($this->isotherm === 'zero') {
      $num_months_below_0_c = count(array_filter($this->avg_temp_array_c, function($element) {
        return $element < 0;
      }));
      if ($num_months_above_10_c === 0 || $num_months_below_0_c > 0) {
        return false;
      }
      return true;
    } else {
      $num_months_below_neg_3_c = count(array_filter($this->avg_temp_array_c, function($element) {
        return $element < -3;
      }));
      if ($num_months_above_10_c === 0 || $num_months_below_neg_3_c > 0) {
        return false;
      }
      return true;
    }
  }
  public function is_cs_cw_or_cf() {
    // Cs climates have at >3x rainfall in wettest winter month as in driest summer month & driest summer month gets <30mm rain
    if ($this->hemisphere === 'north') {
      // ...
    } else {
      // ...
    }
  }
}