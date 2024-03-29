function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

var emailSending = document.getElementById("emailSending");
function emailSubmit() {
  emailSending.textContent = "Sending email...";
  emailSending.style.display = "block";
}

if (getCookie("message-sent")) {
  emailSending.style.display = "block";
  emailSending.textContent = "email send succesfully...";
  setTimeout(() => {
    emailSending.style.display = "none";
    document.cookie =
      "message-sent=messageSentTrue; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
  }, 4000);
}
