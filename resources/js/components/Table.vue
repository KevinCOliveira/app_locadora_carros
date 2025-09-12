<template>
    <div>
        {{ titulos }}
        <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col" v-for>#</th>
                                            <th scope="col">First</th>
                                            <th scope="col">Last</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="m in dados" :key="m.id">
                                            <th scope="row">{{ m.id }}</th>
                                            <td>{{ m.nome }}</td>
                                            <td><img :src="'/storage/'+m.imagem" width="30" heigth="30"></td>                        
                                            </tr>
                                        </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props:['dados','titulos']
    }
</script> 