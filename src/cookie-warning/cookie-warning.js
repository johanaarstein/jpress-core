//VARS FOR TRANSLATIONS
var moreInfo_str;
var iAccept_str;
var cookiesSettings_str;
var functionality_str;
var performance_str;
var showLess_str;
var soMe_str;
var privacy_str;
var jpCW_str1;
var jpCW_str2;
var jpCW_str3;
var jpCW_str4;
var jpCW_str5;

//TRANSLATIONS
if (document.documentElement.lang === 'no') {
  moreInfo_str = 'Vis mer';
  iAccept_str = 'Ja, jeg godtar';
  cookiesSettings_str = 'Dine inn&shy;stillinger for informasjons&shy;kapsler';
  functionality_str = 'Funksjonell';
  performance_str = 'Ytelse';
  showLess_str = 'Vis mindre';
  soMe_str = 'Sosiale medier og reklame';
  privacy_str = 'personvern';
  jpCW_str1 = 'Vi bruker informsjons&shy;kapsler for ytelsesformål, sosiale medier og annonsering.';
  jpCW_str2 = 'Full&shy;stendig informasjon for vilkår for person&shy;vern og informasjons&shy;kapsler';
  jpCW_str3 = 'Disse informasjons&shy;kapslene er nød&shy;vendig for nett&shy;sidens grunnleggende funksjoner og vil derfor alltid være aktivert. Dette inkluderer informasjons&shy;kapsler som gjør at du blir husket når du besøker nett&shy;siden innenfor én enkelt økt eller, hvis du ber om det, fra økt til økt. Disse informasjons&shy;kapslene muliggjør gjennom&shy;føring av aktiviteter og handlinger på nett&shy;stedet som du ønsker å gjennomføre, som for eksempel handle&shy;vogn- og betalings&shy;prosessen. I tillegg har informasjons&shy;kapslene funksjoner i til&shy;knytning til ivare&shy;takelse av nett&shy;stedets sikkerhet og drift i samsvar med gjeldende regler.';
  jpCW_str4 = 'Disse informasjons&shy;kapslene bidrar til at vi kan forbedre nett&shy;stedets funksjoner ved å spore atferden på dette nett&shy;stedet. I noen tilfeller øker disse informasjons&shy;kapslene hastigheten som vi kan behandle henvendelsene dine på, ved at de husker innstillingene du har valgt for nettstedet. Hvis du deaktiverer informasjons&shy;kapslene, kan det medføre dårlig til&shy;passede anbefalinger og langsom ytelse på nettstedet.';
  jpCW_str5 = 'Informasjons&shy;kapsler på sosiale medier gir deg mulighet for å koble deg til det sosiale nett&shy;verket ditt og dele innhold fra nett&shy;stedet vårt via sosiale medier. Informasjonskapsler på annonser (fra tredjeparter) samler informasjon som bidrar til at vi kan tilpasse annonseringen bedre i forhold til dine interesser, både innenfor og utenfor dette nett&shy;stedet. I noen til&shy;feller kan disse informasjons&shy;kapslene innebære behandling av dine person&shy;opplysninger. Hvis du vil ha mer informasjon om denne behandlingen av person&shy;opplysninger, kan du se våre <a href="/no/' + privacy_str +'/" target="_blank">Vilkår for personvern og informasjons&shy;kapsler</a>. Dersom du deaktiverer disse informasjons&shy;kapslene, kan det medføre at du ser annonser som ikke er like relevante for deg, eller at det ikke er mulig å koble til like effektivt med Facebook, Google eller andre nettverk, og/eller at du ikke får delt inn&shy;hold på sosiale medier.';
} else if (document.documentElement.lang === 'en') {
  moreInfo_str = 'Show more';
  iAccept_str = 'Yes, I accept';
  cookiesSettings_str = 'Your Cookie Settings';
  functionality_str = 'Fuctionality';
  performance_str = 'Performance';
  showLess_str = 'Show less';
  soMe_str = 'Social media and advertisement';
  privacy_str = 'privacy';
  jpCW_str1 = 'We use cookies for perfomance enhancement, social media and advertisement.';
  jpCW_str2 = 'Complete information of terms for privacy and cookies';
  jpCW_str3 = 'These cookies are necessary for the basic functions of the website and will therefore always be enabled. This includes cookies that allow you to remember when you visit the website within a single session or, if requested, from session to session. These cookies enable the execution of activities and actions on the site that you want to complete, such as the shopping cart and payment process. In addition, cookies have functions related to safeguarding the site\'s security and operation in accordance with current regulations.';
  jpCW_str4 = 'These cookies help us improve the site\'s features by tracking the behavior of this site. In some cases, these cookies increase the speed at which we can process your inquiries by remembering the settings you have chosen for your site. Disabling cookies may result in poorly tailored recommendations and slow site performance.';
  jpCW_str5 = 'Social media cookies allow you to connect to your social network and share content from our site via social media. Advertising cookies (from third parties) collect information that helps us better tailor your advertising to your interests, both inside and outside this site. In some cases, these cookies may involve the processing of your personal information. For more information about this privacy policy, please see our <a href="/' + privacy_str +'/" target="_blank"> Privacy and Cookie Terms </a>. Disabling these cookies may cause you to see ads that are not as relevant to you, or that it is not possible to connect as effectively with Facebook, Google or other networks, and / or that you may not share content on Social Media.';
}

// Check for HTML5 support
function supportsHtml5Storage() {
  try {
    return 'localStorage' in window && window.localStorage !== null;
  }
  catch (e) {
    return false;
  }
}

function isLocalStorageNameSupported() {
  var testKey = 'test';
  var storage = window.sessionStorage;

  try {
    storage.setItem(testKey, '1');
    storage.removeItem(testKey);
    return true;
  }
  catch (error) {
    return false;
  }
}

// Sempro Cookie Warning
function jpressCookieWarning() {
  this.defaultPreferences = {
    functionality: true,
    performance: true,
    social: true
  };

  this.preferences = {
    functionality: true,
    performance: null,
    social: null
  };

  this.hasRun = {
    functionality: false,
    performance: false,
    social: false
  };

  if (document.documentElement.lang === 'en') {
    this.privacyUrl = '/' + privacy_str + '/';
  } else if (document.documentElement.lang === 'no') {
    this.privacyUrl = '/no/' + privacy_str + '/';
  }

  if (supportsHtml5Storage() && isLocalStorageNameSupported()) {
    if (localStorage.getItem('jpressCookie')) {
      this.preferences = JSON.parse(localStorage.getItem('jpressCookie'));
    }
  }
}

jpressCookieWarning.prototype.render = function () {
  const btnMoreInfo = document.createElement('button');
  btnMoreInfo.type = 'button';
  btnMoreInfo.id = 'btnMoreInfo';
  btnMoreInfo.classList.add('white-background');
  btnMoreInfo.classList.add('background-hover');
  btnMoreInfo.onclick = () => {
    jpressCookieWarning.open().readMore();
    return false;
  };
  btnMoreInfo.innerText = moreInfo_str;
  const btnAcceptAll = document.createElement('button');
  btnAcceptAll.type = 'button';
  btnAcceptAll.id = 'btnAcceptAll';
  btnAcceptAll.classList.add('theme-background');
  btnAcceptAll.classList.add('background-hover');
  btnAcceptAll.classList.add('secondary-border');
  btnAcceptAll.onclick = () => {
    jpressCookieWarning.acceptAll();
    return false;
  };
  btnAcceptAll.innerText = iAccept_str;

  const tplIntro = document.createElement('div');
  tplIntro.id = 'tplIntro';
  const jpcw_content = document.createElement('div');
  jpcw_content.classList.add('jp-cw__content');
  const jpcw_contentText = document.createElement('div');
  jpcw_contentText.classList.add('jp-cw__content-text');
  jpcw_contentText.innerHTML = '<p>' + jpCW_str1 + ' <a href="' + this.privacyUrl + '" target="_blank">' + jpCW_str2 + '.</a></p>';
  const jpcw_buttons = document.createElement('div');
  jpcw_buttons.classList.add('jp-cw__buttons');
  tplIntro.appendChild(jpcw_content);
  jpcw_content.appendChild(jpcw_contentText);
  jpcw_content.appendChild(jpcw_buttons);
  jpcw_buttons.appendChild(btnMoreInfo);
  jpcw_buttons.appendChild(btnAcceptAll);
  // var tplIntro =
  //   '<div id="tplIntro">' +
  //     '<div class="jp-cw__content">' +
  //       '<div class="jp-cw__content-text">' +
  //         '<p>' + jpCW_str1 + '<br><a href="' + this.privacyUrl + '" target="_blank">' + jpCW_str2 + '</a>.</p>' +
  //       '</div>' +
  //       '<div class="jp-cw__buttons">' +
  //         btnMoreInfo + btnAcceptAll +
  //       '</div>' +
  //     '</div>' +
  //   '</div>';

  const btnSave = document.createElement('button');
  btnSave.type = 'button';
  btnSave.id = 'btnSave';
  btnSave.classList.add('theme-background');
  btnSave.classList.add('background-hover');
  btnSave.classList.add('secondary-border');
  btnSave.onclick = () => {
    jpressCookieWarning.accept();
    return false;
  };
  btnSave.innerText = iAccept_str;
  const btnBack = document.createElement('button');
  btnBack.type = 'button';
  btnBack.id = 'btnBack';
  btnBack.classList.add('white-background');
  btnBack.classList.add('background-hover');
  btnBack.onclick = () => {
    jpressCookieWarning.back();
    return false;
  };
  btnBack.innerText = showLess_str;

  const tplPreferences = document.createElement('div');
  const jp_cwTitle = document.createElement('p');
  const jp_cwContent = document.createElement('div');
  const jp_cwButtons = document.createElement('div');
  tplPreferences.id = 'tplPreferences';
  tplPreferences.style.display = 'none';
  jp_cwTitle.classList.add('jp-cw__title');
  jp_cwTitle.innerHTML = cookiesSettings_str;
  jp_cwContent.classList.add('jp-cw__content');
  jp_cwButtons.classList.add('jp-cw__buttons');
  jp_cwContent.innerHTML =
  '<div>' +
    '<label class="functionality">' + functionality_str + '</label>' +
    '<p>' + jpCW_str3 + '</p>' +
  '</div>' +
  '<div>' +
    '<input type="checkbox" '+ (this.preferences.performance || this.defaultPreferences.performance && this.preferences.performance === null? 'checked="checked"' : '' ) +' name="performance" id="performance"><label for="performance">' + performance_str + '</label>' +
    '<p>' + jpCW_str4 + '</p>' +
  '</div>' +
  '<div>' +
    '<input type="checkbox" '+ (this.preferences.social || this.defaultPreferences.social && this.preferences.social === null? 'checked="checked"' : '' ) +' name="social" id="social"><label for="social">' + soMe_str + '</label>' +
    '<p>' + jpCW_str5 + '</p>' +
  '</div>';
  jp_cwButtons.appendChild(btnBack);
  jp_cwButtons.appendChild(btnSave);
  tplPreferences.appendChild(jp_cwTitle);
  tplPreferences.appendChild(jp_cwContent);
  tplPreferences.appendChild(jp_cwButtons);
  // var tplPreferences =
  //   '<div id="tplPreferences" style="display: none">' +
  //     '<p class="jp-cw__title">' + cookiesSettings_str + '</p>' +
  //     '<div class="jp-cw__content">' +
  //       '<div>' +
  //         '<img class="jp-cw__checkmark" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIxNzkyIiB2aWV3Qm94PSIwIDAgMTc5MiAxNzkyIiB3aWR0aD0iMTc5MiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTY3MSA1NjZxMCA0MC0yOCA2OGwtNzI0IDcyNC0xMzYgMTM2cS0yOCAyOC02OCAyOHQtNjgtMjhsLTEzNi0xMzYtMzYyLTM2MnEtMjgtMjgtMjgtNjh0MjgtNjhsMTM2LTEzNnEyOC0yOCA2OC0yOHQ2OCAyOGwyOTQgMjk1IDY1Ni02NTdxMjgtMjggNjgtMjh0NjggMjhsMTM2IDEzNnEyOCAyOCAyOCA2OHoiLz48L3N2Zz4=" alt="" /><label>' + functionality_str + '</label>' +
  //         '<p>' + jpCW_str3 + '</p>' +
  //       '</div>' +
  //       '<div>' +
  //         '<input type="checkbox" '+ (this.preferences.performance || this.defaultPreferences.performance && this.preferences.performance === null? 'checked="checked"' : '' ) +' name="performance" id="performance"><label for="performance">' + performance_str + '</label>' +
  //         '<p>' + jpCW_str4 + '</p>' +
  //       '</div>' +
  //       '<div>' +
  //         '<input type="checkbox" '+ (this.preferences.social || this.defaultPreferences.social && this.preferences.social === null? 'checked="checked"' : '' ) +' name="social" id="social"><label for="social">' + soMe_str + '</label>' +
  //         '<p>' + jpCW_str5 + '</p>' +
  //       '</div>' +
  //       '<div class="jp-cw__buttons">' +
  //         btnSave + btnBack +
  //       '</div>' +
  //     '</div>' +
  //   '</div>';

    const html = document.createElement('div');
    const jp_cw = document.createElement('div');
    const jp_cw_wrapper = document.createElement('div');
    const jp_cw_body = document.createElement('div');
    html.id = 'jp-cw-mask';
    jp_cw.id = 'jp-cw';
    jp_cw_wrapper.classList.add('jp-cw__wrapper');
    jp_cw_wrapper.classList.add('theme-background');
    jp_cw_body.classList.add('jp-cw__body');
    html.appendChild(jp_cw);
    jp_cw.appendChild(jp_cw_wrapper);
    jp_cw_wrapper.appendChild(jp_cw_body);
    jp_cw_body.appendChild(tplIntro);
    jp_cw_body.appendChild(tplPreferences);

  // var html =
  //   '<div id="jp-cw-mask">' +
  //     '<div id="jp-cw">' +
  //       '<div class="jp-cw__wrapper">' +
  //         '<div class="jp-cw__body">' +
  //           tplIntro +
  //           tplPreferences +
  //         '</div>' +
  //       '</div>' +
  //     '</div>' +
  //   '</div>';

  // document.body.insertAdjacentHTML('beforeend', html);
  document.body.appendChild(html);
};

jpressCookieWarning.prototype.init = function () {
  var isPrivacyUrl = window.location.pathname === this.privacyUrl || window.location.href === this.privacyUrl;

  if (supportsHtml5Storage() && isLocalStorageNameSupported()) {
    if(localStorage.getItem('jpressCookie')) {
      this.execScripts();
    } else if(!isPrivacyUrl) {
      this.open();
    }
  }

  return this;
};

jpressCookieWarning.prototype.execScripts = function () {
  for (var option in this.preferences) {
    if(!this.preferences.hasOwnProperty(option) || this.preferences[option] === false) continue;
    // Make sure to only run once
    if (this.hasRun[option] === false) {
      // Check if functions are defined. "semproPerformance" etc..
      var funcName = 'sempro' + option.charAt(0).toUpperCase() + option.slice(1);

      // Check if GTM window.dataLayer is defined; dispatch events
      typeof window.dataLayer !== 'undefined' ?
        dataLayer.push({event: funcName}) :
        console.warn && console.warn('GTM dataLayer not set!');

      if (typeof window[funcName] === 'function') {
        setTimeout(function (funcName) {
          window[funcName]();
        }(funcName), 1);
      }

      this.hasRun[option] = true;
    }
  }
};

jpressCookieWarning.prototype.save = function (options) {
  if (supportsHtml5Storage() && isLocalStorageNameSupported()) {
    if (options) {
      localStorage.setItem('jpressCookie', JSON.stringify(options));
      this.preferences = options;
    } else {
      var inputs = document.querySelectorAll('#tplPreferences input[type="checkbox"]');
      for(var i=0;i<inputs.length;i++) {
        if(inputs[i].name !== '') {
          this.preferences[inputs[i].name] = !!inputs[i].checked;
        }
      }
      localStorage.setItem('jpressCookie', JSON.stringify(this.preferences));
    }
  }

  this.execScripts();
};

jpressCookieWarning.prototype.readMore = function () {
  document.getElementById('tplIntro').style.display = 'none';
  document.getElementById('tplPreferences').style.display = 'block';
  document.querySelectorAll('#jp-cw .jp-cw__wrapper')[0].style.maxWidth = '700px';
  document.getElementById('jp-cw').classList.add('jp-cw--read-more');
};

jpressCookieWarning.prototype.accept = function () {
  this.save();
  this.close();
};

jpressCookieWarning.prototype.acceptAll = function () {
  this.save({
    functionality: true,
    performance: true,
    social: true
  });
  this.close();
};

jpressCookieWarning.prototype.back = function () {
  this.close();
  this.open();
};

jpressCookieWarning.prototype.open = function () {
  if (!document.getElementById('jp-cw-mask')) {
    this.render();
  }
  document.getElementsByTagName('html')[0].style.overflow = 'hidden';
  return this;
};

jpressCookieWarning.prototype.close = function () {
  var el = document.getElementById('jp-cw-mask');
  el.parentNode.removeChild(el);
  document.getElementsByTagName('html')[0].style.overflow = '';
};


window.jpressCookieWarning = new jpressCookieWarning();
document.addEventListener('DOMContentLoaded', function () {
  return window.jpressCookieWarning.init();
}, true);

// npx babel cookie-warning/cookie-warning.js --out-file cookie-warning/cookie-warning.min.js
