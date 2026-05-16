let darkmode = localStorage.getItem("darkmode"); // اذا عندنا دارك مود ثيم موجودة بالتخزين رح يجيبه للمتغير هذا
const themeSwitch = document.getElementById("theme-switch");

const enableDarkmode = () => {
  document.body.classList.add("darkmode"); /*Adding class="darkmode"*/
  localStorage.setItem("darkmode", "active"); // local storage can store strings only so we are going to save the current state which is "active"
};

const disableDarkmode = () => {
  document.body.classList.remove("darkmode");
  localStorage.setItem("darkmode", null);
};

if (darkmode === "active") enableDarkmode();

themeSwitch.addEventListener("click", () => {
  darkmode = localStorage.getItem("darkmode");
  darkmode !== "active" ? enableDarkmode() : disableDarkmode();
});



// 1. Global Functions (Accessible by HTML onclick)
function switchLanguage(lang) {
  // Save preference
  localStorage.setItem("preferredLang", lang);

  if (lang === "en") {
    $("html").attr("lang", "en");
    $("html").attr("dir", "ltr");
    $("[data-lang='en'], [data-lang='en ltr']").show().removeAttr("disabled");
    $("[data-lang='ar']").hide().attr("disabled", true);
  } else {
    $("html").attr("lang", "ar");
    $("html").attr("dir", "rtl");
    $("[data-lang='ar']").show().removeAttr("disabled");
    $("[data-lang='en'], [data-lang='en ltr']").hide().attr("disabled", true);
  }
}

function toggleLanguage() {
  let currentLang = $("html").attr("lang");
  if (currentLang === "en") {
    switchLanguage("ar");
  } else {
    switchLanguage("en");
  }
}

// 2. Run immediately when the DOM is fully loaded
$(document).ready(function() {
  // Check local storage for saved language
  let savedLang = localStorage.getItem("preferredLang");

  if (savedLang) {
    switchLanguage(savedLang);
  } else {
    // Default fallback
    $("[data-lang='ar']").attr("disabled", true);
  }
});