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
        attachContactTypeListeners();
        attachAssignToMeListeners();
        const form = mainContent.querySelector(".notes");

        form.addEventListener("submit", function (event) {
          event.preventDefault();

          const formData = new FormData(form);
          console.log(form);
          fetch("handle_note_submission.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Network response was not ok.");
              }
              return response.text();
            })

            .catch((error) => {
              console.error("There was an error!", error);
            });
        });
      })
      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  }

  async function attachContactTypeListeners() {
    const switchBtn = document.querySelector(".switchBtn");

    switchBtn.addEventListener("click", async (event) => {
      try {
        const response = await fetch("update_contact_type.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ id: event.target.id }),
        });

        console.log("response", response);

        if (!response.ok) {
          throw new Error("Failed to update contact type");
        }

        const data = await response.text();

        console.log(data);
      } catch (error) {
        console.error(error.message);
      }
    });
  }

  async function attachAssignToMeListeners() {
    const assignBtn = document.querySelector(".assignBtn");

    assignBtn.addEventListener("click", async (event) => {
      try {
        const response = await fetch("assign_to_me.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ id: event.target.id }),
        });

        if (!response.ok) {
          throw new Error("Failed to update contact type");
        }
      } catch (error) {
        console.error(error.message);
      }
    });
  }
});
