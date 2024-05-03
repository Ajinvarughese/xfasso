var ham1 = document.getElementById("bar1");
var ham2 = document.getElementById("bar2");
var ham3 = document.getElementById("bar3");

var menu = document.getElementById("ham-menu");
var newNav = document.getElementById("new-nav-menu");
var main = document.getElementById("main");

menu.addEventListener("change", () => {
  if (menu.checked) {
    ham2.style.display = "none";

    ham1.style.cssText = `
            top:50%;
            transform: rotate(40deg);
        `;
    ham3.style.cssText = `
            top:50%;
            transform: rotate(140deg);
        `;
    menu.style.zIndex = "1";
    document.body.style.overflow = "hidden";
    document.body.classList.add("hide-scroll-bar");
    newNav.style.left = "0";
    document.getElementById("main").style.background =
      "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5))";
    document.getElementById("main").style.cursor = "pointer";

    document.getElementById("main").addEventListener("click", () => {
      document.body.style.overflow = "visible";
      ham2.style.display = "block";
      document.body.classList.remove("hide-scroll-bar");
      ham1.style.cssText = `
                    top:17%;
                    transform: rotate(0deg);
                `;
      ham3.style.cssText = `
                    top:39%;
                    transform: rotate(0deg);
                `;
      newNav.style.left = "-110%";
      menu.checked = false;

      document.getElementById("main").style.background = "";
      document.getElementById("main").style.cursor = "default";
    });
  } else {
    document.getElementById("main").style.cursor = "default";
    document.body.style.overflow = "visible";
    ham2.style.display = "block";
    document.body.classList.remove("hide-scroll-bar");
    ham1.style.cssText = `
            top:17%;
            transform: rotate(0deg);
        `;
    ham3.style.cssText = `
            top:39%;
            transform: rotate(0deg);
        `;
    newNav.style.left = "-110%";
    document.getElementById("main").style.background = "";
  }
});

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

function updateWindowWidth() {
  return window.innerWidth;
}
updateWindowWidth();

window.addEventListener("resize", updateWindowWidth);

window.addEventListener("resize", () => {
  if (updateWindowWidth() >= 901) {
    document.body.style.overflow = "visible";
    ham2.style.display = "block";
    document.body.classList.remove("hide-scroll-bar");
    ham1.style.cssText = `
            top:17%;
            transform: rotate(0deg);
        `;
    ham3.style.cssText = `
            top:39%;
            transform: rotate(0deg);
        `;
    newNav.style.left = "-110%";
    menu.checked = false;
    document.getElementById("main").style.cursor = "default";
    document.getElementById("main").style.background = "";
  }
});
   

var logoutBtn = document.getElementsByClassName("logout");

if (getCookie("XassureUser")) {
  for (var i = 0; i < logoutBtn.length; i++) {
    logoutBtn[i].innerHTML = "Logout";
  }
} else {
  for (var i = 0; i < logoutBtn.length; i++) {
    logoutBtn[i].innerHTML = "Sign Up";
  }
}

function logoutSignup() {
  if (getCookie("XassureUser")) {
    document.cookie =
      "XassureUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    window.location.href = "./";
  } else {
    window.location.href = "./signup/signup.html";
  }
}
