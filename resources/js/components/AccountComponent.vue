<template>
    <div>
        <div class="card">
            <div class="card-header">Cadastro de Conta</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <input type="text" v-model="user.name" placeholder="Nome" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" v-model="user.email" placeholder="E-mail" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <input type="button" @click="store" class="btn btn-primary" value="Gravar">
                    </div>
                </div>
            </div>
        </div>

        <AccountTable></AccountTable>
    </div>
</template>

<script>
    import axios from 'axios'
    import AccountTable from './AccountTableComponent.vue' 

    export default {
        components: {
            AccountTable
        },
        data: () => ({
            user:{
                name: '',
                email:''
            }
        }),
        methods: {
            store(){
                axios.get(process.env.MIX_APP_URL+"/account",{ headers: {'Authorization': "Bearer 3q9TgyjiDpNel6rWxVAn4BPAgTe6zptEpWYIh9rexVTcPHabUQMCzpPtnxkC"}})
                    .then(response => {
                        console.log(response.data)
                    }).catch(error =>{
                        console.log(error);
                    })
            }
        }
    }
</script>