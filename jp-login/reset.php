<?php
require __DIR__ . '/../jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require APP_ROOT . '/jp-includes/app/functions.php';
include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $changePassword_str;
$bodyClass = 'login theme-background noindex';

$helpBlock = '';

if (isset($_GET['error'])) {
  if ($_GET['error'] == 'empty') {
    $email_err = $helpBlock = $writeEmail_str;
  } elseif ($_GET['error'] == 'nomatch') {
    $email_err = $helpBlock = $noUsers_str;
  }
} else {
  $helpBlock = $awaitInstructions_str;
}

include APP_ROOT . '/views/templates/header.php';

?>
<div id="main-content">
  <div class="wrapper">
    <div class="logo-container">
      <a href="<?php echo BASE_URL; ?>" title="<?php echo $siteName; ?>"><?php echo $logo; ?></a>
    </div>
    <?php
      if (isset($_GET['reset'])) {
        if ($_GET['reset'] == 'success') {
          echo '<p class="forgotten-password">' . $checkYourInbox . '</p>';
        }
      } else {

        ?>
        <form action="/jp-includes/reset-request.php" method="post" id="reset-form">
          <?php if ($reCAPTCHASwitch === 'checked') { ?>
          <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
          <input type="hidden" name="reset-password">
          <?php } ?>
          <div class="form-group<?php echo (!empty($email_err)) ? ' has-error' : ''; ?>">
            <input placeholder="<?php echo $email_str; ?>" type="email" name="email" class="form-control">
            <span class="help-block<?php echo (!empty($email_err)) ? ' has-error' : ''; ?>"><?php echo $helpBlock; ?></span>
          </div>
          <div class="form-group">
            <input type="button" id="reset-button" name="reset-request-submit" class="btn semi-link theme-background background-hover" value="<?php echo $send_str; ?>">
            <?php if ($reCAPTCHASwitch === 'checked') { ?>
            <div class="recaptcha-privacy"><p><?php echo $recaptchaLogin_str; ?></p></div>
            <?php } ?>
          </div>
        </form>
        <?php if ($reCAPTCHASwitch === 'checked') { ?>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&explicit&hl=<?php echo $lang; ?>&render=<?php echo $reCAPTCHA_siteKey; ?>" nonce="<?php echo NONCE ?>" async defer></script>
        <script nonce="<?php echo NONCE; ?>">
        var request=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");var requestString,resetForm=document.getElementById("reset-form"),recaptchaResponse=document.getElementById("recaptchaResponse"),resetBtn=document.getElementById("reset-button");if(resetForm){var onloadCallback=function(){grecaptcha.execute("<?php echo $reCAPTCHA_siteKey; ?>",{action:"reset"}).then(function(a){recaptchaResponse.value=a})};resetBtn.addEventListener("click",function(a){a.preventDefault(),requestString="recaptcha_response="+recaptchaResponse.value,request.onreadystatechange=function(){4===this.readyState&&(200<=this.status&&300>this.status?resetForm.submit():400<=this.status&&600>this.status&&(this.responseText?(resetForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter\">"+this.responseText+"</p>"),console.log(this.responseText)):resetForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter\"><?php echo $thereWasAnError_str; ?></p>")))},request.open("POST","/jp-includes/recaptcha.php",!0),request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8"),request.send(requestString)},!1)}
        </script>
      <?php } else { ?>
        <script nonce="<?php echo NONCE; ?>">
        var resetForm=document.getElementById("reset-form");resetBtn=document.getElementById("reset-button"),resetForm&&resetBtn.addEventListener("click",function(){resetForm.submit()},!1);
        </script>
      <?php }
      } ?>
  </div>
</div>
<?php include APP_ROOT . '/views/templates/footer.php'; ?>
