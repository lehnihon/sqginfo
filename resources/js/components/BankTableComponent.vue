<template>
    <div class="card my-2">
        <div class="card-header">Bancos</div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="bank in banks" v-bind:key="bank.id">
                                <th scope="row">{{bank.id}}</th>
                                <td>{{bank.name}}</td>
                                <td><button class="btn" @click="destroy(bank.id)">Deletar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data: () => ({
            banks:[]
        }),
        methods: {
            destroy(id){
                if(confirm("Tem certeza que quer deletar?")){
                    axios.delete(process.env.MIX_APP_URL+"/bank/"+id,{ headers: {'Authorization': "Bearer "+window.api_token}})
                        .then(response => {
                            this.getBanks();
                        }).catch(error =>{
                        }).finally(() => {
                        })
                }
            },
            getBanks(){
                axios.get(process.env.MIX_APP_URL+"/bank",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.banks = response.data
                    }).catch(error =>{
                        console.log(error)
                    })
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        },
        mounted(){
            this.getBanks()
        }
    }
</script>