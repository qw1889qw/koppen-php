<?php

class InputList {
  public function __construct($arr = []) {
    foreach ($arr as $input_key => $input_value) {
      $this->$input_key = $input_value;
    }
    // convert rainfall from strings to floats/doubles just to avoid any potential coercion issues
    foreach (self::$rain_array as $month) {
      $month_first = $month[0];
      $month_mm = $month[1];
      // if using imperial system, convert inches to mm for calculations
      if ($this->unit === 'imperial') {
        $this->$month_mm = (float) $this->$month_first * 25.4;
      } else {
        $this->$month_mm = (float) $this->$month_first;
      }
      // get total annual rainfall
      $this->total_rainfall_mm += $this->$month_mm;
      // get summer rainfall (Apr-Sep for northern hemisphere, Oct-Mar for southern)
      if ($this->hemisphere === 'north') {
        if (in_array($month_first, ['rain_apr', 'rain_may', 'rain_jun', 'rain_jul', 'rain_aug', 'rain_sep'])) {
          $this->summer_rain_measurements[] = $this->$month_mm;
          $this->summer_rainfall_mm += $this->$month_mm;
        } else {
          $this->winter_rain_measurements[] = $this->$month_mm;
        }
      } else {
        if (in_array($month_first, ['rain_oct', 'rain_nov', 'rain_dec', 'rain_jan', 'rain_feb', 'rain_mar'])) {
          $this->summer_rain_measurements[] = $this->$month_mm;
          $this->summer_rainfall_mm += $this->$month_mm;
        } else {
          $this->winter_rain_measurements[] = $this->$month_mm;
        }
      }
    }
    // get monthly average temperatures
    $this->get_avg_month_temps();
    // get annual average temperature in Fahrenheit & Celsius
    $this->avg_temp_array_c = [];
    foreach (self::$avg_array as $month_avg) {
      if ($this->unit === 'imperial') {
        $this->$month_avg = f_to_c($this->$month_avg);
      }
      if (in_array($month_avg, ['avg_temp_apr', 'avg_temp_may', 'avg_temp_jun', 'avg_temp_jul', 'avg_temp_aug', 'avg_temp_sep'])) {
        if ($this->hemisphere === 'north') {
          $this->summer_temp_measurements[] = $this->$month_avg;
        } else {
          $this->winter_temp_measurements[] = $this->$month_avg;
        }
      } else {
        if ($this->hemisphere === 'north') {
          $this->winter_temp_measurements[] = $this->$month_avg;
        } else {
          $this->summer_temp_measurements[] = $this->$month_avg;
        }
      }
      $this->avg_temp_array_c[] = $this->$month_avg;
    }
    $this->avg_annual_temp_c = array_sum($this->avg_temp_array_c) / 12;
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

  protected $summer_temp_measurements = []; // will be in Celsius
  protected $winter_temp_measurements = [];
  protected $summer_rain_measurements = []; // will be in mm
  protected $winter_rain_measurements = [];

  protected $tropical_threshold = 0;
  protected $dry_threshold = 0;

  protected $avg_annual_temp_c = 0;

  // A (tropical) climates

  public function is_tropical() {
    // tropical climates have average temps for every month above 18 degrees C
    foreach (self::$avg_array as $avg_month_temp) {
      if ($this->$avg_month_temp < 18) { // $this->$avg_month_temp is a double
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
      return 'W';
    }
    return 'S';
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
      return $element >= 10;
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
  public function is_s_w_or_f() { // note: this also works for D climates
    // Cw climates have >=10x rainfall in wettest summer month as in driest winter month
    // test w before s (e.g. Kunming, Yunnan, China satisfies both Csb & Cwb criteria but it's classified as Cwb)
    $wettest_summer_month_rainfall = max($this->summer_rain_measurements);
    $driest_winter_month_rainfall = min($this->winter_rain_measurements);
    // strval() is to prevent issues w/ limited precision that come from comparing floats
    if (($wettest_summer_month_rainfall >= 10 * $driest_winter_month_rainfall) || strval($wettest_summer_month_rainfall) === strval(10 * $driest_winter_month_rainfall)) {
      return 'w';
    }
    // Cs climates have >=3x rainfall in wettest winter month as in driest summer month & driest summer month gets <30mm rain
    $wettest_winter_month_rainfall = max($this->winter_rain_measurements);
    $driest_summer_month_rainfall = min($this->summer_rain_measurements);
    // strval() is to prevent issues w/ limited precision that come from comparing floats
    if ((($wettest_winter_month_rainfall >= 3 * $driest_summer_month_rainfall) || strval($wettest_winter_month_rainfall) === strval(3 * $driest_summer_month_rainfall)) && ($driest_summer_month_rainfall < 30)) {
      return 's';
    }
    // Cf climates don't satisfy Cs or Cw criteria
    return 'f';
  }
  public function is_temperate_continental_a_b_c_or_d() { // note: this works for both C & D climates (though you can't have C*d climates, only D*d climates)
    $ten_deg_count = 0;
    $twenty_two_deg_count = 0;
    $neg_thirty_eight_deg_count = 0;
    foreach ($this->avg_temp_array_c as $month_avg) {
      if ($month_avg >= 22) {
        $twenty_two_deg_count++;
        $ten_deg_count++;
      } elseif ($month_avg >= 10) {
        $ten_deg_count++;
      }
      if ($month_avg < -38) {
        $neg_thirty_eight_deg_count++;
      }
    }
    // Csa/Cwa/Cfa/Dsa/Dwa/Dfa: at least 1 month avg. temp >=22 deg C, at least 4 months avg. temp >=10 deg C
    if ($twenty_two_deg_count >= 1 && $ten_deg_count >= 4) {
      return 'a';
    }
    // Csb/Cwb/Cfb/Dsb/Dwb/Dfb: all months avg. temp <22 deg C, at least 4 months avg. temp >=10 deg C
    if ($twenty_two_deg_count === 0 && $ten_deg_count >= 4) {
      return 'b';
    }
    // Csc/Cwc/Cfc/Dsc/Dwc/Dfc: 1-3 months avg. temp >=10 deg C
    // Dsd/Dwd/Dfd: at least 1 month avg. temp <-38 deg C, 1-3 months avg. temp >= 10 deg C
    if ($ten_deg_count >= 1 && $ten_deg_count <= 3) {
      if ($this->is_continental()) {
        if ($neg_thirty_eight_deg_count > 0) {
          return 'd';
        }
      }
      return 'c';
    }
    return 'a'; // default to Csa/Cwa/Cfa/Dsa/Dwa/Dfa just in case
  }

  // D (continental) climates
  public function is_continental() {
    // if not at least 1 month averaging below freezing or -3 deg C (depending on isotherm) & at least 1 month averaging above 10 deg C, it's not continental
    $num_months_above_10_c = count(array_filter($this->avg_temp_array_c, function($element) {
      return $element >= 10;
    }));
    $num_months_below_0_c = count(array_filter($this->avg_temp_array_c, function($element) {
      return $element < 0;
    }));
    $num_months_below_neg3_c = count(array_filter($this->avg_temp_array_c, function($element) {
      return $element < -3;
    }));
    if ($this->isotherm === 'zero') {
      if ($num_months_above_10_c === 0 || $num_months_below_0_c === 0) {
        return false;
      }
      return true;
    } else {
      if ($num_months_above_10_c === 0 || $num_months_below_neg3_c === 0) {
        return false;
      }
      return true;
    }
  }

  // E (polar climates)
  public function is_polar() {
    // every month in a polar climate averages below 10 deg C
    $ten_deg_count = 0;
    foreach ($this->avg_temp_array_c as $month_avg) {
      if ($month_avg >= 10) {
        $ten_deg_count++;
      }
    }
    if ($ten_deg_count > 0) {
      return false;
    }
    return true;
  }
  public function is_et_or_ef() {
    $above_zero_deg_count = 0;
    foreach ($this->avg_temp_array_c as $month_avg) {
      if ($month_avg >= 0) {
        $above_zero_deg_count++;
      }
    }
    if ($above_zero_deg_count > 0) {
      return 'T';
    }
    return 'F';
  }

  // putting it all together
  public function determine_koppen_classification() {
    $classification = '';
    // first letter
    // B climates take priority over A climates; e.g. even though Honolulu has all 12 months averaging above 18 deg C, it meets B criteria so it's BSh instead of Aw/As
    if ($this->is_dry()) {
      $classification .= 'B';
    } elseif ($this->is_tropical()) {
      $classification .= 'A';
    } elseif ($this->is_temperate()) {
      $classification .= 'C';
    } elseif ($this->is_continental()) {
      $classification .= 'D';
    } elseif ($this->is_polar()) {
      $classification .= 'E';
    }
    // second letter of A climates
    if ($classification === 'A') {
      if ($this->is_af()) {
        $classification .= 'f';
      } elseif ($this->is_am_or_aw_as() === 'am') {
        $classification .= 'm';
      } elseif ($this->is_am_or_aw_as() === 'aw/as') {
        $classification .= 'w/As';
      }
      return $classification;
    }
    // second letter of B climates
    if ($classification === 'B') {
      $classification .= $this->is_bw_or_bs();
    }
    // third letter of B climates
    if ($classification === 'BW' || $classification === 'BS') {
      if ($this->is_dry_hot_or_cold() === 'h') {
        $classification .= 'h';
      } else {
        $classification .= 'k';
      }
      return $classification;
    }
    // second letter of C & D climates
    if ($classification === 'C' || $classification === 'D') {
      $classification .= $this->is_s_w_or_f();
    }
    // third letter of C & D climates
    if (in_array($classification, ['Cs', 'Cw', 'Cf', 'Ds', 'Dw', 'Df'])) {
      $classification .= $this->is_temperate_continental_a_b_c_or_d();
      return $classification;
    }
    // second letter of E climates
    if ($classification === 'E') {
      $classification .= $this->is_et_or_ef();
      return $classification;
    }
  }
}