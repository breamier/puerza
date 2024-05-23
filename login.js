// Get the form element
const loginForm = document.getElementById('Loginform');

// Add an event listener to the form
loginForm.addEventListener('submit', function(event) {
  // Get the email and password input elements
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');

  // Check if the email and password fields are not empty
  if (emailInput.value.trim() === '') {
    alert('Please enter your email');
    event.preventDefault(); // Prevent the form from submitting
  } else if (passwordInput.value.trim() === '') {
    alert('Please enter your password');
    event.preventDefault(); // Prevent the form from submitting
  }
});