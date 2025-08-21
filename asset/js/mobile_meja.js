document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("#search-table");
  if (!table) return;

  const headers = Array.from(table.querySelectorAll("thead th")).map((th) =>
    th.textContent.trim()
  );

  table.querySelectorAll("tbody tr").forEach((row) => {
    row.querySelectorAll("th, td").forEach((cell, i) => {
      if (headers[i]) {
        cell.setAttribute("data-label", headers[i]);
      }
    });
  });
});
