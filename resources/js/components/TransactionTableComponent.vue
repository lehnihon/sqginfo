<template>
    <div class="card my-2">
        <div class="card-header">Transações</div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Conta</th>
                                <th scope="col">Data</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions" v-bind:key="transaction.id">
                                <th scope="row">{{transaction.id}}</th>
                                <td>R${{formatPrice(transaction.value)}}</td>
                                <td>{{transaction.status}}</td>
                                <td>{{transaction.user.name}}</td>
                                <td>{{formatDate(transaction.created_at)}}</td>
                                <td>
                                    <button v-if="!transaction.status" class="btn" @click="edit(transaction)">Editar</button>
                                    <button class="btn" @click="destroy(transaction.id)">Deletar</button>
                                </td>
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
            transactions:[],
            transaction:{
                description: '',
                value:'',
                user_id:0,
                status:0
            }
        }),
        methods: {
            destroy(id){
                if(confirm("Tem certeza que quer deletar?")){
                    axios.delete(process.env.MIX_APP_URL+"/transaction/"+id,{ headers: {'Authorization': "Bearer "+window.api_token}})
                        .then(response => {
                            this.getTransactions();
                        }).catch(error =>{
                        }).finally(() => {
                        })
                }
            },
            edit(transaction){
               this.$emit('clicked', transaction)
            },
            getTransactions(){
                axios.get(process.env.MIX_APP_URL+"/transaction",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.transactions = response.data
                    }).catch(error =>{
                        console.log(error)
                    })
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            formatDate(dt) {
                if(dt == null){
                    return '';
                }
                var bits = dt.split(/\D/);
                var date = new Date(bits[0], bits[1], bits[2], bits[3], bits[4]);
                return date.getDate() + '/' + date.getMonth() + '/' +  date.getFullYear();
            },
        },
        mounted(){
            this.getTransactions()
        }
    }
</script>