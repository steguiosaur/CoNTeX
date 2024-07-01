// modal variables
var modal = document.getElementById("create-vault-modal");
var btn = document.getElementById("add-vault-btn");
var createBtn = document.getElementById("create-vault");
var cancelBtn = document.getElementById("cancel-vault");

// open modal when Add Vault is pressed
btn.onclick = function () {
  modal.style.display = "block";
};

// close on all these remaining behaviors
cancelBtn.onclick = function () {
  modal.style.display = "none";
};

// createBtn.onclick = function () {
//   modal.style.display = "none";
// };
//
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
