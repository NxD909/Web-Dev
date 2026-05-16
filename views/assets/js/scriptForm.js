document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("messageForm");

  form.addEventListener("submit", function (e) {
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    if (
      name.value.trim() === "" ||
      email.value.trim() === "" ||
      message.value === ""
    ) {
      alert("يرجى تعبئة جميع الحقول المطلوبة.");
      e.preventDefault();
    } else {
      alert("تم إرسال الرسالة بنجاح!");
    }
  });
});
