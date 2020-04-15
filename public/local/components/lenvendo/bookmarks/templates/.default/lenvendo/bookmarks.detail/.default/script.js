function deleteBookmark() {
    let password = prompt('Введите, пожалуйста, пароль для удаления закладки');
    if (password != null) {
        let bookmark = document.getElementById('bookmark');
        let url = bookmark.dataset.url;
        window.location.assign(url + '?delete&password=' + password);
    }
}
