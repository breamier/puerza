function Signup() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  if (email && password) {
      let users = JSON.parse(localStorage.getItem("users")) || [];

      const userExists = users.some(u => u.email === email);

      if (userExists) {
          alert("Email already registered");
      } else {
          users.push({ email, password });
          localStorage.setItem("users", JSON.stringify(users));
          alert("Signup successful!");
      }
  } else {
      alert("Please enter email and password");
  }
}

document.getElementById("login1").addEventListener("click", Signup);

// Get the necessary elements
const menuBtn = document.getElementById('menu-btn');
const menuContainer = document.getElementById('menu-container');

// Toggle the menu when the menu button is clicked
menuBtn.addEventListener('click', () => {
  menuContainer.classList.toggle('show');
});

// Close the menu when clicking outside the menu container
window.addEventListener('click', (event) => {
  if (!event.target.matches('#menu-btn') && !event.target.closest('#menu-container')) {
      menuContainer.classList.remove('show');
  }
});
