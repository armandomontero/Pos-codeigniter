window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        let options = {locale:'es-Es',
            searchable: true,
            labels: {
    placeholder: "Buscar...",
    searchTitle: "Search within table",
    pageTitle: "Page {page}",
    perPage: "registros por página",
    noRows: "No entries found",
    info: "Mostrando {start} hasta {end} de {rows} registros",
    noResults: "No existen registros",
}
        }
        new simpleDatatables.DataTable(datatablesSimple, options);
    }
});
