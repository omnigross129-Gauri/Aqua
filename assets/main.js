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

  // Sticky Header Logic
  window.addEventListener("scroll", () => {
    const navbar = document.querySelector(".aqua-navbar");
    if (navbar) {
      if (window.scrollY > 150) { // Adjust threshold as needed
        navbar.classList.add("sticky");
      } else {
        navbar.classList.remove("sticky");
      }
    }
  });
}




  // const selector = document.querySelector(".language");
  // const dropdown = document.querySelector(".language-dropdown");

  // selector.addEventListener("click", () => {
  //   dropdown.style.display =
  //     dropdown.style.display === "block" ? "none" : "block";
  // });

  // dropdown.querySelectorAll("li").forEach(item => {
  //   item.addEventListener("click", () => {
  //     selector.innerHTML = item.innerHTML + '<i class="fa-solid fa-chevron-down"></i>';
  //     dropdown.style.display = "none";
  //   });
  // });

  // document.addEventListener("click", (e) => {
  //   if (!e.target.closest(".language-selector")) {
  //     dropdown.style.display = "none";
  //   }
  // });

  // document.querySelectorAll(".has-dropdown > a").forEach(link => {
  //   link.addEventListener("click", e => {
  //     e.preventDefault();
  //     link.parentElement.classList.toggle("open");
  //   });
  // });

 
  
  // const slides = document.querySelectorAll(".hero-container");
  // let currentSlide = 0;
  // const slideInterval = 4000; // 4 seconds

  // function showSlide(index) {
  //   slides.forEach((slide, i) => {
  //     slide.classList.toggle("active", i === index);
  //   });
  // }

  // function nextSlide() {
  //   currentSlide = (currentSlide + 1) % slides.length;
  //   showSlide(currentSlide);
  // }

  // // Start auto slider
  // setInterval(nextSlide, slideInterval);


  // const slider = document.querySelector(".hero-slides");

  // // Duplicate slides for infinite loop
  // slider.innerHTML += slider.innerHTML;

  document.addEventListener("DOMContentLoaded", function () {

  const slides = document.querySelectorAll(".hero-container");

  if (!slides.length) return;

  let currentSlide = 0;
  const slideInterval = 4000;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove("active");
    });

    slides[index].classList.add("active");
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  showSlide(currentSlide);
  setInterval(nextSlide, slideInterval);

});


  
  
 
  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".contact-tabs button");
    const formSection = document.getElementById("contactForm");

    tabs.forEach(tab => {
      tab.addEventListener("click", function () {
        // active tab style
        tabs.forEach(t => t.classList.remove("active"));
        this.classList.add("active");

        // show form
        formSection.style.display = "grid";
      });
    });
  });

  
  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".contact-tabs button");
    const image = document.querySelector(".contact-image img");
    const select = document.querySelector("select");

    tabs.forEach(tab => {
      tab.addEventListener("click", function () {
        tabs.forEach(t => t.classList.remove("active"));
        this.classList.add("active");

        const text = this.innerText;

        // change dropdown value
        select.value = text;

        // change image (optional)
        image.src = `assets/images/${text.toLowerCase().replace(/[^a-z]/g, "")}.webp`;
      });
    });
  });


  console.log("Script loaded"); // DEBUG LINE

  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab-btn");
    const form = document.getElementById("contactForm");

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        alert("Tab clicked: " + this.innerText); // DEBUG ALERT

        // active state
        tabs.forEach(t => t.classList.remove("active"));
        this.classList.add("active");

        // show form
        form.style.display = "grid";
      });
    });
  });

  
  
  function openForm(btn) {
    // remove active from all tabs
    document
      .querySelectorAll(".contact-tabs button")
      .forEach(b => b.classList.remove("active"));

    // activate clicked tab
    btn.classList.add("active");

    // show form ONLY on click
    const form = document.getElementById("contactForm");
form.style.display = "grid";
form.style.visibility = "visible";
form.style.opacity = "1";

  }

  
  function openForm(btn) {
    // DEBUG (you should see this)
    console.log("Tab clicked");

    // show form
   const form = document.getElementById("contactForm");
form.style.display = "grid";
form.style.visibility = "visible";
form.style.opacity = "1";


    // active tab styling
    document
      .querySelectorAll(".contact-tabs button")
      .forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
  }


  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab-btn");
    const requirementSelect = document.querySelector(
      ".contact-form select"
    );

    tabs.forEach((tab) => {
      tab.addEventListener("click", function () {

        // remove active from all tabs
        tabs.forEach(t => t.classList.remove("active"));

        // add active to clicked tab
        this.classList.add("active");

        // OPTIONAL: change Requirement dropdown value
        if (requirementSelect) {
          requirementSelect.value = this.innerText;
        }

        console.log("Clicked:", this.innerText);
      });
    });
  });


  document.addEventListener("DOMContentLoaded", function () {

  const tabs = document.querySelectorAll(".contact-tabs button");
  const image = document.getElementById("contactTabImage");

  const imageMap = {
    "General Inquiry": "assets/images/general-inquiry.webp",
    "Product/Pricing": "assets/images/product-pricing.webp",
    "Technical Service": "assets/images/technical-service.webp",
    "Dealer Partnership": "assets/images/dealer-partnership.webp"
  };

  if (!tabs.length || !image) return;

  tabs.forEach(tab => {
    tab.addEventListener("click", function () {

      // Remove active
      tabs.forEach(t => t.classList.remove("active"));
      this.classList.add("active");

      const text = this.innerText.trim();

      if (imageMap[text]) {
        image.src = imageMap[text];
      } else {
        console.error("Image not found for:", text);
      }

    });
  });

});


  
 
  function changeImage(button, imagePath) {

  const img = document.getElementById("contactTabImage");

  if (!img) {
    console.error("Image not found");
    return;
  }

  // Change image
  img.src = imagePath;

  // Active tab style
  document
    .querySelectorAll(".contact-tabs button")
    .forEach(btn => btn.classList.remove("active"));

  button.classList.add("active");
}














  /******************************
 * LOAD HEADER & FOOTER (React Mount)
 ******************************/
document.addEventListener("DOMContentLoaded", () => {
  loadComponent("navbar", "compontents/navbar.html", initNavbar);
loadComponent("footer", "compontents/footer.html");

});





