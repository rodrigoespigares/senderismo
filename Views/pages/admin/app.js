window.onload = () => {
    let a = document.querySelector('script[dataId]');
    const app = Vue.createApp({
        data() {
            return {
              user:[],
            }
          },
        methods: {
            realizarPeticion() {
                url= a.getAttribute("baseUrl")+"Admin/getDataUser&id="+a.getAttribute("dataid");

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición AJAX');
                        }
                        
                        return response.json();
                    })
                    .then(data => {
                        this.user.push(data.user);

                    })
                    .catch(error => {
                        console.error('Error al hacer la petición AJAX:', error);
                    });
            }
        },
        mounted() {
            this.realizarPeticion();
        },
    });
    
    app.mount('#editarUsuario');
}