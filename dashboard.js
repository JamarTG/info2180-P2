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
      })
      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  }
});
