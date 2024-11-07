function autoload() {
    let reloadCount = localStorage.getItem('reloadCount') || 0;
    if (reloadCount < 2) {
        localStorage.setItem('reloadCount', ++reloadCount);
        window.location.href = window.location.href;
    } else {
        localStorage.removeItem('reloadCount');
    }
}