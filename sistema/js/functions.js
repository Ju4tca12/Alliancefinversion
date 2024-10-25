let searchClicked = false;

function resetSearch() {
    if (!searchClicked) {
        document.getElementById('searchInput').value = '';
    }
}

document.querySelector('.search-button').addEventListener('click', function() {
    searchClicked = true;
});

document.querySelector('.reset-button').addEventListener('click', function() {
    searchClicked = false;
});

//nuevas funciones sitema