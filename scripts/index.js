import { metric, imperial, switchableTemp, switchableRain } from './elements.js';

/* switch text displayed depending on options chosen for temperature & rainfall units */

metric.addEventListener('click', () => {
  switchableTemp.textContent = 'C';
  switchableRain.textContent = 'millimetres';
});

imperial.addEventListener('click', () => {
  switchableTemp.textContent = 'F';
  switchableRain.textContent = 'inches';
});