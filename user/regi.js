// Event listeners for form field validation

const fullNameInput = document.getElementById('fullName');
const loginEmailInput = document.getElementById('loginEmail');
const signupEmailInput = document.getElementById('signupEmail');
const loginPasswordInput = document.getElementById('loginPassword');
const signupPasswordInput = document.getElementById('signupPassword');
// const phoneNumberInput = document.getElementById('phoneNumber');

fullNameInput.addEventListener('input', handleFullNameChange);
loginEmailInput.addEventListener('input', handleLoginEmailChange);
signupEmailInput.addEventListener('input', handleSignupEmailChange);
loginPasswordInput.addEventListener('input', handleLoginPasswordChange);
signupPasswordInput.addEventListener('input', handleSignupPasswordChange);
// phoneNumberInput.addEventListener('input', handlePhoneNumberChange);

// Validation message elements

const fullNameMessage = document.getElementById('fname');
const loginEmailMessage = document.getElementById('LoginMassage');
const signupEmailMessage = document.getElementById('signupmessage');
const loginPasswordMessage = document.getElementById('passwordMessage');
const signupPasswordMessage = document.getElementById('rpass');
// const phoneNumberMessage = document.getElementById('phoneMessage');

// Validation functions

function validateFullName(fullName) {
  return fullName.trim() !== '';
}

function validateEmail(email) {
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailRegex.test(email.trim());
}

function validatePassword(password) {
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{6,}$/;
  return passwordRegex.test(password.trim());
}

// function validatePhoneNumber(phoneNumber) {
//   return phoneNumber.trim().length === 10 && !isNaN(phoneNumber);
// }

// Event handler functions for updating validation messages

function handleFullNameChange(event) {
  const fullName = event.target.value;
  if (validateFullName(fullName)) {
    fullNameMessage.textContent = '';
  } else {
    fullNameMessage.textContent = 'Enter your full name';
  }
}

function handleLoginEmailChange(event) {
  const email = event.target.value;
  if (validateEmail(email)) {
    loginEmailMessage.textContent = '';
  } else {
    loginEmailMessage.textContent = 'Check your email';
  }
}

function handleSignupEmailChange(event) {
  const email = event.target.value;
  if (validateEmail(email)) {
    signupEmailMessage.textContent = '';
  } else {
    signupEmailMessage.textContent = 'Check your email';
  }
}

function handleLoginPasswordChange(event) {
  const password = event.target.value;
  if (password === '') {
    loginPasswordMessage.textContent = '';
  } else if (!validatePassword(password)) {
    loginPasswordMessage.textContent = 'Password must be at least 6 characters long and contain a combination of special characters, lowercase, uppercase, and alphanumeric characters.';
  } else {
    loginPasswordMessage.textContent = '';
  }
}

function handleSignupPasswordChange(event) {
  const password = event.target.value;
  if (password === '') {
    signupPasswordMessage.textContent = '';
  } else if (!validatePassword(password)) {
    signupPasswordMessage.textContent = 'Password must be at least 6 characters long and contain a combination of special characters, lowercase, uppercase, and alphanumeric characters.';
  } else {
    signupPasswordMessage.textContent = '';
  }
}

// button bahaviour 
var btn24 = document.getElementById('btn24');
btn24.addEventListener('click', function() {
  window.location.href = '../Profile/profile.php';
});



// function handlePhoneNumberChange(event) {
//   const phoneNumber = event.target.value;
//   if (validatePhoneNumber(phoneNumber)) {
//     phoneNumberMessage.textContent = '';
//   } else {
//     phoneNumberMessage.textContent = 'Enter your phone number';
//   }
// }

// (Optional) Function to handle form submission (assuming validation logic is implemented elsewhere)
