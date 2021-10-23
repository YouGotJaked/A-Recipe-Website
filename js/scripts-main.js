var starOff = "&#9734";
var starOn = "&#9733";
var checkMark = "&#10003";
var xMark = "&#10007";

/** https://stackoverflow.com/a/4793630 */
function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

/** https://stackoverflow.com/a/7394787 */
function decodeHtml(html) {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

function toggleStar(currentValue, starElement, recipeId) {
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", starElement.getAttribute("action"));
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  
  let fav = 0;
  if (currentValue == decodeHtml(starOn)) {
    starElement.innerHTML = starOff;
  } else {
    starElement.innerHTML = starOn;
    fav = 1;
  }
  starElement.setAttribute("fav", fav);
  
  xhttp.send("function=set_favorite&recipe_id="+recipeId+"&fav="+fav);
}

function isFavorite(action, recipeId, callback) {
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", action);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.onload = function() {
    callback(parseInt(this.responseText));
  }
  xhttp.send("function=is_favorite&recipe_id="+recipeId);
}

function onRecipeLoad() {
  const recipeTitle = document.getElementById("recipeTitle");
  const favoriteStar = document.getElementById("favoriteStar");

  // exit if neither exist
  if (recipeTitle === null || favoriteStar === null) {
    return;
  }

  // https://stackoverflow.com/a/16825593
  const action = favoriteStar.getAttribute("action");
  const recipeId = recipeTitle.getAttribute("recipe-id"); 
  isFavorite(action, recipeId, favorited => {
    favoriteStar.innerHTML = (favorited==true) ? starOn : starOff;
  });

  favoriteStar.addEventListener("click", (event) => {
    toggleStar(event.target.innerHTML, favoriteStar, recipeId);
  });
}

function checkEmailExists(action, email, callback) {
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", action);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.onload = function() {
    callback(parseInt(this.responseText));
  }
  xhttp.send("function=user_exists&email="+email);
}

// https://stackoverflow.com/a/46181
function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function onEmailFill() {
  const signUpForm = document.forms[0];
  const emailInput = signUpForm.querySelector('input[name="email"]');
  const submitBtn = document.getElementById("signupsubmit");
  const msgSpan = document.getElementById("emailExists");
  
  // only check if input is a valid email address
  if (!validateEmail(emailInput.value)) {
    return;
  }
  
  checkEmailExists(emailInput.getAttribute("action"), emailInput.value, exists => {
    if (exists) {
      msgSpan.innerHTML = "An account already exists with this email.";
      submitBtn.disabled = true;
    } else {
      msgSpan.innerHTML = "";
      submitBtn.disabled = false;
    }
  });
}

function checkPasswordMatch() {
  const signUpForm = document.forms[0];
  const pwd = signUpForm.querySelector('input[name="password"]');
  const confirmPwd = signUpForm.querySelector('input[name="confirmPassword"]');
  const submitBtn = document.getElementById("signupsubmit");
  const pwdMatch = document.getElementById("pwdMatch");
  
  if (pwd.value === confirmPwd.value) {
    submitBtn.disabled = false;
    pwdMatch.innerHTML = checkMark;
    pwdMatch.style.color = "green";
  } else {
    submitBtn.disabled = true;
    pwdMatch.innerHTML = xMark;
    pwdMatch.style.color = "red";
  }
}
