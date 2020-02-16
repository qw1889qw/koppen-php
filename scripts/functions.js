export function clearAllInputs() {
  const xhr = new XMLHttpRequest;
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      location.replace(location.href); // input-clearing script was executed, now reload page w/ GET request
    }
  }
  xhr.open('GET', 'clear.php');
  xhr.send();
}