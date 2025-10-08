<template>
    <div>
        <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col" v-for="t, key in titulos" :key="key" >{{t.titulo}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="obj in dadosFiltrados" :key="chave">
                                                <td>{{ objeto }}</td>
                                            </tr>
                                            
                                            <!-- <tr v-for="obj in dados" :key="obj.id">
                                                <td v-if="titulos.includes(chave)" v-for="valor, chave in obj" :key="chave">
                                                    <span v-if="chave == 'imagem' "> 
                                                        <img :src="'/storage/'+valor" width="30" height="30">
                                                    </span>
                                                    <span v-else>
                                                        {{ valor }}
                                                    </span>
                                                </td>                   
                                            </tr> -->
                                        </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props:['dados','titulos'],
        computed: {
            dadosFiltrados(){
                let campos = Object.keys(this.titulos)
                //console.log(this.titulos)

                //console.log(this.dados)

                this.dados.map((item,chave) => {
                   // console.log(chave, item)
                    let itemFiltrado = {}
                    campos.forEach(campo => {
                        //console.log(campo)
                        itemFiltrado[campo] = item[campo]
                        console.log(chave, item, campo)
                    })
                })
                return  '' //retorno array de objetos para ser representado
            }
        
            }
    }
</script> 