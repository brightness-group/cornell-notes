const demo = {
    setFolders(data) {
        return localStorage.setItem('folders', JSON.stringify(data));
    },

    getFolders() {
        return JSON.parse(localStorage.getItem('folders'));
    },

    removeFolder() {
        let now = new Date().getTime();
        let setupTime = localStorage.getItem('setupTime');

        if (setupTime == null) {
            localStorage.setItem('setupTime', now)
        } else {
            if (now - setupTime > 8 * 60 * 60 * 1000) {
                localStorage.clear()
                localStorage.setItem('setupTime', now);
            }
        }
    }
}

export default demo;
