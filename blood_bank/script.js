function searchDonor() {
  const type = document.getElementById('searchBlood').value;
  const resultDiv = document.getElementById('result');

  if (!type) {
    resultDiv.innerHTML = '<p>Please enter a blood type.</p>';
    return false;
  }

  // Simulate search logic
  resultDiv.innerHTML = `<p>Searching for donors with blood type <strong>${type}</strong>...</p>`;
  setTimeout(() => {
    resultDiv.innerHTML = `<p>Donor(s) with blood type ${type} found!</p>`;
  }, 1000);

  return false;
}
