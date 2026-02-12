/******************************
 * COMPONENT LOADER (React-like)
 ******************************/
function loadComponent(id, file, callback) {
  fetch(file)
    .then(res => res.text())
    .then(html => {
      const target = document.getElementById(id);
      if (!target) return;
      target.innerHTML = html;
      if (callback) callback();
    })
    .catch(err => console.error("Component load error:", err));
}

/******************************
 * SLIDER DOTS
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  const dots = document.querySelectorAll(".slider-dots span");
  let dotIndex = 0;

  if (dots.length) {
    setInterval(() => {
      dots.forEach(d => d.classList.remove("active"));
      dots[dotIndex].classList.add("active");
      dotIndex = (dotIndex + 1) % dots.length;
    }, 3000);
  }
});

/******************************
 * PRODUCT FILTER TABS
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".tab");
  const productCards = document.querySelectorAll(".product-card");
  const productSlider = document.getElementById("productSlider");

  if (!tabs.length || !productCards.length) return;

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      const filter = tab.dataset.filter;

      productCards.forEach(card => {
        card.style.display =
          filter === "all" || card.classList.contains(filter)
            ? "block"
            : "none";
      });

      productSlider?.scrollTo({ left: 0, behavior: "smooth" });
    });
  });
});

/******************************
 * PRODUCT SLIDER ARROWS
 ******************************/
function scrollProducts(direction) {
  const productSlider = document.getElementById("productSlider");
  if (!productSlider) return;

  productSlider.scrollBy({
    left: direction * 320,
    behavior: "smooth"
  });
}

/******************************
 * TOP SELLING MACHINES SLIDER
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  const tsmSlider = document.getElementById("tsmSlider");
  const tsmPrev = document.querySelector(".tsm-prev");
  const tsmNext = document.querySelector(".tsm-next");

  if (!tsmSlider || !tsmPrev || !tsmNext) return;

  tsmPrev.addEventListener("click", () => {
    tsmSlider.scrollBy({ left: -320, behavior: "smooth" });
  });

  tsmNext.addEventListener("click", () => {
    tsmSlider.scrollBy({ left: 320, behavior: "smooth" });
  });
});

/******************************
 * TESTIMONIAL SLIDER
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".testimonial-track");
  const cards = document.querySelectorAll(".testimonial-card");
  const prev = document.getElementById("prev");
  const next = document.getElementById("next");

  if (!track || !cards.length || !prev || !next) return;

  let index = 0;
  const cardWidth = cards[0].offsetWidth + 30;

  next.addEventListener("click", () => {
    if (index < cards.length - 1) {
      index++;
      track.style.transform = `translateX(-${index * cardWidth}px)`;
    }
  });

  prev.addEventListener("click", () => {
    if (index > 0) {
      index--;
      track.style.transform = `translateX(-${index * cardWidth}px)`;
    }
  });
});

/******************************
 * BLOG SLIDER
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  const blogTrack = document.querySelector(".blog-track");
  const blogCards = document.querySelectorAll(".blog-card");
  const blogPrev = document.getElementById("blog-prev");
  const blogNext = document.getElementById("blog-next");

  if (!blogTrack || !blogCards.length || !blogPrev || !blogNext) return;

  let blogIndex = 0;
  const blogCardWidth = blogCards[0].offsetWidth + 30;

  blogNext.addEventListener("click", () => {
    if (blogIndex < blogCards.length - 1) {
      blogIndex++;
      blogTrack.style.transform =
        `translateX(-${blogIndex * blogCardWidth}px)`;
    }
  });

  blogPrev.addEventListener("click", () => {
    if (blogIndex > 0) {
      blogIndex--;
      blogTrack.style.transform =
        `translateX(-${blogIndex * blogCardWidth}px)`;
    }
  });
});

/******************************
 * NAVBAR INIT (after component load)
 ******************************/
function initNavbar() {
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.querySelector(".nav-menu");
  const closeMenu = document.getElementById("closeMenu");
  const submenuToggles = document.querySelectorAll(".has-submenu > a");

  if (!hamburger || !navMenu) return;

  hamburger.addEventListener("click", () => {
    navMenu.classList.add("active");
  });

  closeMenu?.addEventListener("click", () => {
    navMenu.classList.remove("active");
  });

  document.addEventListener("click", (e) => {
    if (
      navMenu.classList.contains("active") &&
      !navMenu.contains(e.target) &&
      !hamburger.contains(e.target)
    ) {
      navMenu.classList.remove("active");
    }
  });

  submenuToggles.forEach(toggle => {
    toggle.addEventListener("click", (e) => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        toggle.parentElement.classList.toggle("active");
      }
    });
  });
}

/******************************
 * LOAD HEADER & FOOTER (React Mount)
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  loadComponent("navbar", "compontents/navbar.html", initNavbar);
loadComponent("footer", "compontents/footer.html");

});
