document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("#search-table");
  if (table) {
    // Tambahkan atribut data-label ke setiap td
    const headers = Array.from(table.querySelectorAll("thead th")).map((th) =>
      th.textContent.trim()
    );
    table.querySelectorAll("tbody tr").forEach((row) => {
      Array.from(row.querySelectorAll("td")).forEach((td, index) => {
        td.setAttribute("data-label", headers[index] || "");
      });
    });

    const datatable = new simpleDatatables.DataTable(table, {
      perPage: 5, // Kurangi item per halaman untuk mobile
      perPageSelect: [5, 10, 15],
      labels: {
        placeholder: "Cari meja...",
        searchTitle: "Cari dalam tabel",
        pageTitle: "Halaman {page}",
        perPage: "item per halaman",
        noRows: "Data tidak ditemukan",
        info: "Menampilkan {start} sampai {end} dari {rows} data",
        noResults: "Tidak ada hasil yang cocok dengan pencarian Anda",
      },
    });

    // ... (kode styling Tailwind yang sudah ada)
  }
});
