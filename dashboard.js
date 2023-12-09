document.addEventListener("DOMContentLoaded", function () {
  fetchTable("All");

  const tabLinks = document.querySelectorAll(".tab-link");
  const tableContainer = document.querySelector("#table-container");

  tabLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const filter = this.getAttribute("data-filter");
      fetchTable(filter);
    });
  });

  function fetchTable(filter) {
    fetch(`filter.php?filter=${filter}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text();
      })
      .then((data) => {
        tableContainer.innerHTML = data;
        attachViewLinkListeners();
      })

      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  }

  const addContactBtn = document.querySelector(".add-contact-btn");

  addContactBtn.addEventListener("click", function (event) {
    event.preventDefault();

    fetch("new_contact.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text();
      })
      .then((data) => {
        const contentContainer = document.getElementById("main-content");
        contentContainer.innerHTML = data;
      })
      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  });

  function attachViewLinkListeners() {
    const viewLinks = document.querySelectorAll(".view-link");
    viewLinks.forEach((link) => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const contactId = this.getAttribute("id");
        fetchFullContactDetails(contactId);
      });
    });
  }

  function fetchFullContactDetails(contactId) {

    fetch(`full_contact_details.php?id=${contactId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text();
      })
      .then((data) => {
        const mainContent = document.getElementById("main-content");
        mainContent.innerHTML = data;
        attachViewLinkListeners();
      })
      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  }
  
});
