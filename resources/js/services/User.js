const user = {
    logout() {
        axios.post('/logout').then(response => {
            window.location.replace('/login');
        })
    }
}

export default user;
