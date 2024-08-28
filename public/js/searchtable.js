document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener('keyup', searchTable);
    }
});

function searchTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toUpperCase();
    const table = document.querySelector("table");
    const trs = table.querySelectorAll("tbody tr");

    trs.forEach((tr) => {
        let showRow = false;
        const tds = tr.querySelectorAll("td");

        tds.forEach((td) => {
            if (td.textContent.toUpperCase().includes(filter)) {
                showRow = true;
            }
        });

        tr.style.display = showRow ? "" : "none";
    });
}
