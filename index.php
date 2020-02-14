<?php

session_start();

/* process form inputs once submitted */

// when form submitted, transfer $_POST entries to $_SESSION
// when clear button clicked, empty out $_SESSION & redirect back to this page w/ a GET request (in index.js)

if (!empty($_POST)) {
  $_SESSION = $_POST;
  unset($_POST); // $_SESSION still retains values
}

/* echo '$_POST: <br>';
print_r($_POST);
echo '<br>$_SESSION: <br>';
print_r($_SESSION); */

function show_if_set($value) {
  echo $_SESSION[$value] ?? '';
}

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
              <label for="high-temp-jan">January - high</label>
              <input required class="form__input" type="number" id="high-temp-jan" name="high-temp-jan" value="<?php show_if_set('high-temp-jan'); ?>" placeholder="January - high">
            </p>
            <p>
              <label for="low-temp-jan">January - low</label>
              <input required class="form__input" type="number" id="low-temp-jan" name="low-temp-jan" value="<?php show_if_set('low-temp-jan'); ?>" placeholder="January - low">
            </p>
            <p>
              <label for="high-temp-feb">February - high</label>
              <input required class="form__input" type="number" id="high-temp-feb" name="high-temp-feb" value="<?php show_if_set('high-temp-feb'); ?>" placeholder="February - high">
            </p>
            <p>
              <label for="low-temp-feb">February - low</label>
              <input required class="form__input" type="number" id="low-temp-feb" name="low-temp-feb" value="<?php show_if_set('low-temp-feb'); ?>" placeholder="February - low">
            </p>
            <p>
              <label for="high-temp-mar">March - high</label>
              <input required class="form__input" type="number" id="high-temp-mar" name="high-temp-mar" value="<?php show_if_set('high-temp-mar'); ?>" placeholder="March - high">
            </p>
            <p>
              <label for="low-temp-mar">March - low</label>
              <input required class="form__input" type="number" id="low-temp-mar" name="low-temp-mar" value="<?php show_if_set('low-temp-mar'); ?>" placeholder="March - low">
            </p>
            <p>
              <label for="high-temp-apr">April - high</label>
              <input required class="form__input" type="number" id="high-temp-apr" name="high-temp-apr" value="<?php show_if_set('high-temp-apr'); ?>" placeholder="April - high">
            </p>
            <p>
              <label for="low-temp-apr">April - low</label>
              <input required class="form__input" type="number" id="low-temp-apr" name="low-temp-apr" value="<?php show_if_set('low-temp-apr'); ?>" placeholder="April - low">
            </p>
            <p>
              <label for="high-temp-may">May - high</label>
              <input required class="form__input" type="number" id="high-temp-may" name="high-temp-may" value="<?php show_if_set('high-temp-may'); ?>" placeholder="May - high">
            </p>
            <p>
              <label for="low-temp-may">May - low</label>
              <input required class="form__input" type="number" id="low-temp-may" name="low-temp-may" value="<?php show_if_set('low-temp-may'); ?>" placeholder="May - low">
            </p>
            <p>
              <label for="high-temp-jun">June - high</label>
              <input required class="form__input" type="number" id="high-temp-jun" name="high-temp-jun" value="<?php show_if_set('high-temp-jun'); ?>" placeholder="June - high">
            </p>
            <p>
              <label for="low-temp-jun">June - low</label>
              <input required class="form__input" type="number" id="low-temp-jun" name="low-temp-jun" value="<?php show_if_set('low-temp-jun'); ?>" placeholder="June - low">
            </p>
            <p>
              <label for="high-temp-jul">July - high</label>
              <input required class="form__input" type="number" id="high-temp-jul" name="high-temp-jul" value="<?php show_if_set('high-temp-jul'); ?>" placeholder="July - high">
            </p>
            <p>
              <label for="low-temp-jul">July - low</label>
              <input required class="form__input" type="number" id="low-temp-jul" name="low-temp-jul" value="<?php show_if_set('low-temp-jul'); ?>" placeholder="July - low">
            </p>
            <p>
              <label for="high-temp-aug">August - high</label>
              <input required class="form__input" type="number" id="high-temp-aug" name="high-temp-aug" value="<?php show_if_set('high-temp-aug'); ?>" placeholder="August - high">
            </p>
            <p>
              <label for="low-temp-aug">August - low</label>
              <input required class="form__input" type="number" id="low-temp-aug" name="low-temp-aug" value="<?php show_if_set('low-temp-aug'); ?>" placeholder="August - low">
            </p>
            <p>
              <label for="high-temp-sep">September - high</label>
              <input required class="form__input" type="number" id="high-temp-sep" name="high-temp-sep" value="<?php show_if_set('high-temp-sep'); ?>" placeholder="September - high">
            </p>
            <p>
              <label for="low-temp-sep">September - low</label>
              <input required class="form__input" type="number" id="low-temp-sep" name="low-temp-sep" value="<?php show_if_set('low-temp-sep'); ?>" placeholder="September - low">
            </p>
            <p>
              <label for="high-temp-oct">October - high</label>
              <input required class="form__input" type="number" id="high-temp-oct" name="high-temp-oct" value="<?php show_if_set('high-temp-oct'); ?>" placeholder="October - high">
            </p>
            <p>
              <label for="low-temp-oct">October - low</label>
              <input required class="form__input" type="number" id="low-temp-oct" name="low-temp-oct" value="<?php show_if_set('low-temp-oct'); ?>" placeholder="October - low">
            </p>
            <p>
              <label for="high-temp-nov">November - high</label>
              <input required class="form__input" type="number" id="high-temp-nov" name="high-temp-nov" value="<?php show_if_set('high-temp-nov'); ?>" placeholder="November - high">
            </p>
            <p>
              <label for="low-temp-nov">November - low</label>
              <input required class="form__input" type="number" id="low-temp-nov" name="low-temp-nov" value="<?php show_if_set('low-temp-nov'); ?>" placeholder="November - low">
            </p>
            <p>
              <label for="high-temp-dec">December - high</label>
              <input required class="form__input" type="number" id="high-temp-dec" name="high-temp-dec" value="<?php show_if_set('high-temp-dec'); ?>" placeholder="December - high">
            </p>
            <p>
              <label for="low-temp-dec">December - low</label>
              <input required class="form__input" type="number" id="low-temp-dec" name="low-temp-dec" value="<?php show_if_set('low-temp-dec'); ?>" placeholder="December - low">
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset fieldset--rain">
          <legend>enter rainfall by month (<span class="switchable switchable--rain">inches</span>)</legend>
          <div class="form__div form__div--rain-grid">
            <p>
              <label for="rain-jan">January</label>
              <input required class="form__input" type="number" id="rain-jan" name="rain-jan" value="<?php show_if_set('rain-jan'); ?>"placeholder="January">
            </p>
            <p>
              <label for="rain-feb">February</label>
              <input required class="form__input" type="number" id="rain-feb" name="rain-feb" value="<?php show_if_set('rain-feb'); ?>"placeholder="February">
            </p>
            <p>
              <label for="rain-mar">March</label>
              <input required class="form__input" type="number" id="rain-mar" name="rain-mar" value="<?php show_if_set('rain-mar'); ?>"placeholder="March">
            </p>
            <p>
              <label for="rain-apr">April</label>
              <input required class="form__input" type="number" id="rain-apr" name="rain-apr" value="<?php show_if_set('rain-apr'); ?>"placeholder="April">
            </p>
            <p>
              <label for="rain-may">May</label>
              <input required class="form__input" type="number" id="rain-may" name="rain-may" value="<?php show_if_set('rain-may'); ?>"placeholder="May">
            </p>
            <p>
              <label for="rain-jun">June</label>
              <input required class="form__input" type="number" id="rain-jun" name="rain-jun" value="<?php show_if_set('rain-jun'); ?>"placeholder="June">
            </p>
            <p>
              <label for="rain-jul">July</label>
              <input required class="form__input" type="number" id="rain-jul" name="rain-jul" value="<?php show_if_set('rain-jul'); ?>"placeholder="July">
            </p>
            <p>
              <label for="rain-aug">August</label>
              <input required class="form__input" type="number" id="rain-aug" name="rain-aug" value="<?php show_if_set('rain-aug'); ?>"placeholder="August">
            </p>
            <p>
              <label for="rain-sep">September</label>
              <input required class="form__input" type="number" id="rain-sep" name="rain-sep" value="<?php show_if_set('rain-sep'); ?>"placeholder="September">
            </p>
            <p>
              <label for="rain-oct">October</label>
              <input required class="form__input" type="number" id="rain-oct" name="rain-oct" value="<?php show_if_set('rain-oct'); ?>"placeholder="October">
            </p>
            <p>
              <label for="rain-nov">November</label>
              <input required class="form__input" type="number" id="rain-nov" name="rain-nov" value="<?php show_if_set('rain-nov'); ?>"placeholder="November">
            </p>
            <p>
              <label for="rain-dec">December</label>
              <input required class="form__input" type="number" id="rain-dec" name="rain-dec" value="<?php show_if_set('rain-dec'); ?>"placeholder="December">
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend>metric or imperial units?</legend>
          <div class="side-by-side">
            <p class="one-side">
              <label for="unit-metric">metric</label>
              <input required class="form__input" type="radio" id="unit-metric" name="unit" value="metric">
            </p>
            <p class="one-side">
              <label for="unit-imperial">imperial</label>
              <input required class="form__input" type="radio" id="unit-imperial" name="unit" value="imperial" checked>
            </p>
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend>0&deg; or -3&deg; isotherm?</legend>
          <div class="side-by-side">
            <p class="one-side">
              <label for="isotherm-zero">0&deg;</label>
              <input required class="form__input" type="radio" id="isotherm-zero" name="isotherm" value="zero" checked>
            </p>
            <p class="one-side">
              <label for="isotherm-neg-three">-3&deg;</label>
              <input required class="form__input" type="radio" id="isotherm-neg-three" name="isotherm" value="neg-three">
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