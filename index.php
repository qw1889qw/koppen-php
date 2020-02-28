<?php

ini_set('display_errors', '1'); // delete once done

session_start();

require_once 'classes.php';
require_once 'functions.php';

/* process form inputs once submitted */

// when form submitted, transfer $_POST entries to $_SESSION
// when clear button clicked, empty out $_SESSION & redirect back to this page w/ a GET request (in index.js)

if (!empty($_POST)) {
  $_SESSION = $_POST;
  unset($_POST); // $_SESSION still retains values
  $list1 = new InputList($_SESSION);
  echo $list1->determine_koppen_classification();
}


/* echo '$_POST: <br>';
print_r($_POST);
echo '<br>$_SESSION: <br>';
print_r($_SESSION); */

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,700&display=swap" rel="stylesheet">
    <title>Köppen-PHP</title>
  </head>
  <body>
    <header>
      <h1 class="heading heading--largest">Köppen-PHP</h1>
      <h2 class="heading heading--second-largest">enter climate data & i'll figure out which Köppen climate classification your data corresponds to</h2>
    </header>
    <main>
      <form method="post" class="form">
        <fieldset class="fieldset fieldset--month">
          <legend>enter high & low temperatures by month (&deg;<span class="switchable switchable--temp">F</span>)</legend>
          <div class="form__div form__div--temp-grid">
            <p>
              <label for="high_temp_jan">January - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_jan" name="high_temp_jan" value="<?php show_if_set('high_temp_jan'); ?>" placeholder="January - high">
            </p>
            <p>
              <label for="low_temp_jan">January - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_jan" name="low_temp_jan" value="<?php show_if_set('low_temp_jan'); ?>" placeholder="January - low">
            </p>
            <p>
              <label for="high_temp_feb">February - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_feb" name="high_temp_feb" value="<?php show_if_set('high_temp_feb'); ?>" placeholder="February - high">
            </p>
            <p>
              <label for="low_temp_feb">February - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_feb" name="low_temp_feb" value="<?php show_if_set('low_temp_feb'); ?>" placeholder="February - low">
            </p>
            <p>
              <label for="high_temp_mar">March - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_mar" name="high_temp_mar" value="<?php show_if_set('high_temp_mar'); ?>" placeholder="March - high">
            </p>
            <p>
              <label for="low_temp_mar">March - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_mar" name="low_temp_mar" value="<?php show_if_set('low_temp_mar'); ?>" placeholder="March - low">
            </p>
            <p>
              <label for="high_temp_apr">April - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_apr" name="high_temp_apr" value="<?php show_if_set('high_temp_apr'); ?>" placeholder="April - high">
            </p>
            <p>
              <label for="low_temp_apr">April - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_apr" name="low_temp_apr" value="<?php show_if_set('low_temp_apr'); ?>" placeholder="April - low">
            </p>
            <p>
              <label for="high_temp_may">May - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_may" name="high_temp_may" value="<?php show_if_set('high_temp_may'); ?>" placeholder="May - high">
            </p>
            <p>
              <label for="low_temp_may">May - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_may" name="low_temp_may" value="<?php show_if_set('low_temp_may'); ?>" placeholder="May - low">
            </p>
            <p>
              <label for="high_temp_jun">June - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_jun" name="high_temp_jun" value="<?php show_if_set('high_temp_jun'); ?>" placeholder="June - high">
            </p>
            <p>
              <label for="low_temp_jun">June - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_jun" name="low_temp_jun" value="<?php show_if_set('low_temp_jun'); ?>" placeholder="June - low">
            </p>
            <p>
              <label for="high_temp_jul">July - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_jul" name="high_temp_jul" value="<?php show_if_set('high_temp_jul'); ?>" placeholder="July - high">
            </p>
            <p>
              <label for="low_temp_jul">July - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_jul" name="low_temp_jul" value="<?php show_if_set('low_temp_jul'); ?>" placeholder="July - low">
            </p>
            <p>
              <label for="high_temp_aug">August - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_aug" name="high_temp_aug" value="<?php show_if_set('high_temp_aug'); ?>" placeholder="August - high">
            </p>
            <p>
              <label for="low_temp_aug">August - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_aug" name="low_temp_aug" value="<?php show_if_set('low_temp_aug'); ?>" placeholder="August - low">
            </p>
            <p>
              <label for="high_temp_sep">September - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_sep" name="high_temp_sep" value="<?php show_if_set('high_temp_sep'); ?>" placeholder="September - high">
            </p>
            <p>
              <label for="low_temp_sep">September - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_sep" name="low_temp_sep" value="<?php show_if_set('low_temp_sep'); ?>" placeholder="September - low">
            </p>
            <p>
              <label for="high_temp_oct">October - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_oct" name="high_temp_oct" value="<?php show_if_set('high_temp_oct'); ?>" placeholder="October - high">
            </p>
            <p>
              <label for="low_temp_oct">October - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_oct" name="low_temp_oct" value="<?php show_if_set('low_temp_oct'); ?>" placeholder="October - low">
            </p>
            <p>
              <label for="high_temp_nov">November - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_nov" name="high_temp_nov" value="<?php show_if_set('high_temp_nov'); ?>" placeholder="November - high">
            </p>
            <p>
              <label for="low_temp_nov">November - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_nov" name="low_temp_nov" value="<?php show_if_set('low_temp_nov'); ?>" placeholder="November - low">
            </p>
            <p>
              <label for="high_temp_dec">December - high</label>
              <input required class="form__input" type="number" step="0.01" id="high_temp_dec" name="high_temp_dec" value="<?php show_if_set('high_temp_dec'); ?>" placeholder="December - high">
            </p>
            <p>
              <label for="low_temp_dec">December - low</label>
              <input required class="form__input" type="number" step="0.01" id="low_temp_dec" name="low_temp_dec" value="<?php show_if_set('low_temp_dec'); ?>" placeholder="December - low">
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset fieldset--rain">
          <legend>enter rainfall by month (<span class="switchable switchable--rain">inches</span>)</legend>
          <div class="form__div form__div--rain-grid">
            <p>
              <label for="rain_jan">January</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_jan" name="rain_jan" value="<?php show_if_set('rain_jan'); ?>"placeholder="January">
            </p>
            <p>
              <label for="rain_feb">February</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_feb" name="rain_feb" value="<?php show_if_set('rain_feb'); ?>"placeholder="February">
            </p>
            <p>
              <label for="rain_mar">March</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_mar" name="rain_mar" value="<?php show_if_set('rain_mar'); ?>"placeholder="March">
            </p>
            <p>
              <label for="rain_apr">April</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_apr" name="rain_apr" value="<?php show_if_set('rain_apr'); ?>"placeholder="April">
            </p>
            <p>
              <label for="rain_may">May</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_may" name="rain_may" value="<?php show_if_set('rain_may'); ?>"placeholder="May">
            </p>
            <p>
              <label for="rain_jun">June</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_jun" name="rain_jun" value="<?php show_if_set('rain_jun'); ?>"placeholder="June">
            </p>
            <p>
              <label for="rain_jul">July</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_jul" name="rain_jul" value="<?php show_if_set('rain_jul'); ?>"placeholder="July">
            </p>
            <p>
              <label for="rain_aug">August</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_aug" name="rain_aug" value="<?php show_if_set('rain_aug'); ?>"placeholder="August">
            </p>
            <p>
              <label for="rain_sep">September</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_sep" name="rain_sep" value="<?php show_if_set('rain_sep'); ?>"placeholder="September">
            </p>
            <p>
              <label for="rain_oct">October</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_oct" name="rain_oct" value="<?php show_if_set('rain_oct'); ?>"placeholder="October">
            </p>
            <p>
              <label for="rain_nov">November</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_nov" name="rain_nov" value="<?php show_if_set('rain_nov'); ?>"placeholder="November">
            </p>
            <p>
              <label for="rain_dec">December</label>
              <input required class="form__input" type="number" step="0.01" min="0" id="rain_dec" name="rain_dec" value="<?php show_if_set('rain_dec'); ?>"placeholder="December">
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend>metric or imperial units?</legend>
          <div class="side-by-side">
            <p class="one-side">
              <label for="unit_metric">metric</label>
              <input required class="form__input" type="radio" id="unit_metric" name="unit" value="metric" <?php determine_checked($list1, 'unit', 'metric'); ?>>
            </p>
            <p class="one-side">
              <label for="unit_imperial">imperial</label>
              <input required class="form__input" type="radio" id="unit_imperial" name="unit" value="imperial" <?php determine_checked_default($list1, 'unit', 'imperial'); ?>>
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend>0&deg; or -3&deg; isotherm?</legend>
          <div class="side-by-side">
            <p class="one-side">
              <label for="isotherm-zero">0&deg;</label>
              <input required class="form__input" type="radio" id="isotherm-zero" name="isotherm" value="zero" <?php determine_checked_default($list1, 'isotherm', 'zero'); ?>>
            </p>
            <p class="one-side">
              <label for="isotherm-neg-three">-3&deg;</label>
              <input required class="form__input" type="radio" id="isotherm-neg-three" name="isotherm" value="neg-three" <?php determine_checked($list1, 'isotherm', 'neg-three'); ?>>
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend>northern or southern hemisphere?</legend>
          <div class="side-by-side">
            <p class="one-side">
              <label for="hemisphere-north">north</label>
              <input required class="form__input" type="radio" id="hemisphere-north" name="hemisphere" value="north" <?php determine_checked_default($list1, 'hemisphere', 'north'); ?>>
            </p>
            <p class="one-side">
              <label for="hemisphere-south">south</label>
              <input required class="form__input" type="radio" id="hemisphere-south" name="hemisphere" value="south" <?php determine_checked($list1, 'hemisphere', 'south'); ?>>
            </p>
          </div>
        </fieldset>
        <div class="buttons">
          <button type="button" value="clear" class="form__button form__button--clear bottom-button">clear</button>
          <input type="submit" value="submit" class="form__input form__input--submit bottom-button">
        </div>
      </form>
    </main>
    <script src="scripts/index.js" type="module"></script>
  </body>
</html>