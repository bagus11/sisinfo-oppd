// Get layout type
var at = document.documentElement.getAttribute("data-layout");

if (at === "vertical") {
  document.addEventListener("DOMContentLoaded", function () {
    "use strict";
    
    const isSidebar = document.getElementsByClassName("side-mini-panel");
    if (isSidebar.length > 0) {
      // Get current URL and path
      const currentUrl = window.location.href;

      // Function to find matching element in sidebar nav
      function findMatchingElement() {
        const anchors = document.querySelectorAll("#sidebarnav a");
        for (let i = 0; i < anchors.length; i++) {
          if (anchors[i].href === currentUrl) {
            return anchors[i];
          }
        }
        return null; // Return null if no matching element is found
      }

      // Get the matching element and mark it as active
      const elements = findMatchingElement();
      if (elements) {
        elements.classList.add("active");
      }

      // Handling multilevel menu toggle
      document.querySelectorAll("#sidebarnav a").forEach(function (link) {
        link.addEventListener("click", function (e) {
          const isActive = this.classList.contains("active");
          const parentUl = this.closest("ul");

          if (!isActive) {
            // Hide all open submenus and reset active classes
            parentUl.querySelectorAll("ul").forEach(submenu => submenu.classList.remove("in"));
            parentUl.querySelectorAll("a").forEach(navLink => navLink.classList.remove("active"));

            // Open new submenu
            const submenu = this.nextElementSibling;
            if (submenu) {
              submenu.classList.add("in");
            }
            this.classList.add("active");
          } else {
            // Toggle current active menu
            this.classList.remove("active");
            const submenu = this.nextElementSibling;
            if (submenu) {
              submenu.classList.remove("in");
            }
          }
        });
      });

      // Prevent default action on multilevel menu headers
      document.querySelectorAll("#sidebarnav > li > a.has-arrow").forEach(link => {
        link.addEventListener("click", e => e.preventDefault());
      });

      // Auto-select the correct menu
      if (elements) {
        const closestNav = elements.closest("nav[class^=sidebar-nav]");
        const menuid = (closestNav && closestNav.id) || "menu-right-mini-1";
        const menu = menuid[menuid.length - 1];

        document.getElementById("menu-right-mini-" + menu)?.classList.add("d-block");
        document.getElementById("mini-" + menu)?.classList.add("selected");
      }

      // Expand menus for active sidebar items
      document.querySelectorAll("ul#sidebarnav ul li a.active").forEach(link => {
        link.closest("ul").classList.add("in");
        link.closest("ul").parentElement.classList.add("selected");
      });

      // Mini sidebar navigation click handling
      document.querySelectorAll(".mini-nav .mini-nav-item").forEach(item => {
        item.addEventListener("click", function () {
          const id = this.id;
          document.querySelectorAll(".mini-nav .mini-nav-item").forEach(navItem => navItem.classList.remove("selected"));
          this.classList.add("selected");
          document.querySelectorAll(".sidebarmenu nav").forEach(nav => nav.classList.remove("d-block"));
          document.getElementById("menu-right-" + id)?.classList.add("d-block");
          document.body.setAttribute("data-sidebartype", "full");
        });
      });
    }
  });
}

if (at === "horizontal") {
  // Similar function to find active element for horizontal layout
  function findMatchingElement() {
    const anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
    for (let i = 0; i < anchors.length; i++) {
      if (anchors[i].href === window.location.href) {
        return anchors[i];
      }
    }
    return null;
  }

  const elements = findMatchingElement();
  if (elements) {
    elements.classList.add("active");
  }

  document.querySelectorAll("#sidebarnavh ul#sidebarnav a.active").forEach(link => {
    link.closest("a").parentElement.classList.add("selected");
    link.closest("ul").parentElement.classList.add("selected");
  });
}

// Handle setting href based on the current URL
// Get the current URL
const currentURL = window.location.href;

// Find all menu items in the mini navigation
const miniNavItems = document.querySelectorAll(".mini-nav-item");

// Loop through each mini-nav item to match the current URL with the correct menu
miniNavItems.forEach((item) => {
  // Retrieve the menu ID from the mini-nav item (assumes 'mini-<id>' structure)
  const menuId = item.id.replace("mini-", "");

  // Locate the corresponding sidebar menu with the matching ID
  const sidebarMenu = document.getElementById("menu-right-mini-" + menuId);

  // Hide other menus that don’t match the current URL
  sidebarMenu?.classList.remove("d-block");
  item.classList.remove("selected");
  
  // Check if the sidebarMenu element exists and if the current URL includes the module's link
  if (sidebarMenu) {
    // Add classes to display the correct menu and highlight the selected menu item
    if (sidebarMenu.getAttribute('href') == window.location.href){
      sidebarMenu.classList.add("d-block");
      item.classList.add("selected");
    }  
  }
});