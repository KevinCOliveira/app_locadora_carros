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
                            <button type="submit" class="btn btn-primary btn-sm float-right">Adicinonar</button>
                        </template>
                    </card-component>
            </div>
        </div>
    </div>
</template>

<script>
    
 
</script>
