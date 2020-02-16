import { metric, imperial, switchableTemp, switchableRain, clearButton } from './elements.js';
import { clearAllInputs } from './functions.js';

/* switch text displayed depending on options chosen for temperature & rainfall units */

metric.addEventListener('click', () => {
  switchableTemp.textContent = 'C';
  switchableRain.textContent = 'millimetres';
});

imperial.addEventListener('click', () => {
  switchableTemp.textContent = 'F';
  switchableRain.textContent = 'inches';
});

clearButton.addEventListener('click', () => {
  /* const inputs = document.querySelectorAll('input[type="number"]');
  inputs.forEach(input => {
    input.value = '';
  }); */
  clearAllInputs();
});