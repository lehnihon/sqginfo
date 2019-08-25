<template>
    <div class="card my-2">
        <div class="card-header">Contas</div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" v-bind:key="user.id">
                                <th scope="row">{{user.id}}</th>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>R${{formatPrice(user.amount)}}</td>
                                <td><button class="btn" @click="destroy(user.id)">Deletar</button></td>
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
            users:[]
        }),
        methods: {
            destroy(id){
                if(confirm("Tem certeza que quer deletar?")){
                    axios.delete(process.env.MIX_APP_URL+"/account/"+id,{ headers: {'Authorization': "Bearer "+window.api_token}})
                        .then(response => {
                            this.getUsers();
                        }).catch(error =>{
                            alert('Erro ao deletar');
                        }).finally(() => {
                        })
                }
            },
            getUsers(){
                axios.get(process.env.MIX_APP_URL+"/account",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.users = response.data
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
            this.getUsers()
        }
    }
</script>