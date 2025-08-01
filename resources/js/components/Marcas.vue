<template>
    
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Inicio do card de busca -->
                    <card-component titulo="Busca de marcas">
                        <template v-slot:conteudo>
                            <div class="form-row">
                                <div class="col mb-3">

                                    <input-container-component titulo="ID" id="input" id-help="idHelp" texto-ajuda="Opcional. informe o ID da marca">
                                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                    </input-container-component>
                                </div> 
                                <div class="col mb-3">
                                    <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. informe o Nome da marca">
                                        <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                    </input-container-component>
                                </div>  
                            </div>
                        </template>
                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                        </template>
                        
                    </card-component>
                <!-- fim do card de busca -->

                <!-- Inicio do card de listagem -->
                    <card-component titulo="Relação de marcas">
                        <template v-slot:conteudo>
                            <table-component></table-component>
                        </template>
                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalMarca">Adicionar</button>
                        </template>
                    </card-component>
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar marca"> 
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomehelp" texto-ajuda="Informe o Nome da marca">
                                                <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomehelp" placeholder="Nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                                                <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
    
    </div>
</template>

<script>
    export default{
        data(){
            return {
                urlBase:'http://localhost:8000/api/v1/marca',
                nomeMarca:'',
                arquivoImagem:[]
            }
        },
        methods: {
            carregarImagem(e){
                 this.arquivoImagem = e.target.files
            },
            salvar(){
                console.log(this.nomeMarca, this.arquivoImagem[0])
                
                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers:{
                        'Content-Type' : 'multipart/form-data',
                        'Accept' : 'application/Json',
                        'Authorization' : 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTc1NDA2NzUxNiwiZXhwIjoxNzU0MDc0NzE2LCJuYmYiOjE3NTQwNjc1MTYsImp0aSI6ImpBYlZ5ekdFY0gzb1NuUWsiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.6KSDQMCZRgBlsrzHaI--USemFHB5aFfvzmHzhufj6Hw'
                    }

                }

                axios.post(this.urlBase,formData,config)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }
        }
    }
 
</script>
