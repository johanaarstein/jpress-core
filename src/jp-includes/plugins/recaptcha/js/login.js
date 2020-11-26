let request;
if (window.XMLHttpRequest) {
  request = new XMLHttpRequest();
} else {
  request = new ActiveXObject("Microsoft.XMLHTTP");
}

let requestString;
let onloadCallback;
const loginForm = document.getElementById('login-form');
const errorMessage = document.getElementById('error-message');
const recaptchaResponse = document.getElementById('recaptchaResponse');
const loginBtn = document.getElementById('login-button');
if (loginForm) {
  onloadCallback = function() {
    grecaptcha.execute(reCAPTCHA_siteKey, {
      action: "login"
    }).then(function(a) {
      recaptchaResponse.value = a;
    });
  };
  loginBtn.addEventListener('click', function(a) {
    a.preventDefault();
    requestString = 'recaptcha_response=' + recaptchaResponse.value;
    request.open('POST', '/jp-includes/plugins/recaptcha/recaptcha.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    request.onreadystatechange = function() {
      if (this.readyState === 4) {
        if (this.status >= 200 && this.status < 300) {
          loginForm.submit();
        } else if (this.status >= 400 && this.status < 600) {
          if (this.responseText !== '') {
            errorMessage.innerText = this.responseText;
            console.log(this.responseText);
          } else {
            errorMessage.innerText = error_str;
          }
        }
      }
    };
    request.send(requestString);
  }, false);
}
