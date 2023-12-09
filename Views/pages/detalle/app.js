window.onload = () => {
    let a = document.querySelector('script[dataId]');
    const app = Vue.createApp({
        data() {
            return {
              comentarios:[],
              ruta:[],
            }
          },
        methods: {
            realizarPeticion() {
                url= a.getAttribute("baseUrl")+"/Base/getDataAndCommit&id="+a.getAttribute("dataid");
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición AJAX');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.comentarios.push (data.comentarios);
                        this.ruta.push(data.ruta);

                    })
                    .catch(error => {
                        console.error('Error al hacer la petición AJAX:', error);
                    });
            }
        },
        mounted() {
            this.realizarPeticion();
        }
    });
    
    app.mount('#comentarios');
}