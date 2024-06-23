// smooth scroll to content
document.querySelector(".read-more a").addEventListener("click", function (e) {
  e.preventDefault();
  const targetSection = document.querySelector(this.getAttribute("href"));
  window.scrollTo({
    top: targetSection.offsetTop,
    behavior: "smooth",
  });
});

// return to top button
let scrollToTopBtn = document.getElementById("scroll-top-btn");

window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollToTopBtn.style.display = "block";
  } else {
    scrollToTopBtn.style.display = "none";
  }
}

scrollToTopBtn.onclick = function () {
  scrollToTop();
};

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
