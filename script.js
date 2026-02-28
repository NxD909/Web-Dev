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
