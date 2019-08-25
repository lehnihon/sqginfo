<template>
    <div>
        <div v-if="msg" :class="msg_color" role="alert">
            {{msg}}
        </div>
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
                        <input type="password" v-model="user.password" placeholder="Senha" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <select v-model="user.bank_id" id="banks" class="form-control">
                            <option value="0">Selecione um Banco</option>
                            <option v-for="bank in banks" v-bind:key="bank.id" :value="bank.id">{{bank.name}}</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <input :disabled="disabled == 1" type="button" @click="store" class="btn btn-primary" value="Gravar">
                    </div>
                </div>
            </div>
        </div>

        <AccountTable :key="componentUpdate"></AccountTable>
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
            msg:'',
            msg_color:'alert alert-success',
            disabled:0,
            banks:[],
            componentUpdate:0,
            user:{
                name: '',
                email:'',
                password:'',
                bank_id:0
            }
        }),
        methods: {
            store(){
                this.disabled = 1;
                
                axios.post(process.env.MIX_APP_URL+"/account",this.user,{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.msg_color ="alert alert-success";
                        this.msg = "Conta cadastrada com sucesso!";
                        this.clearForm();
                        this.componentUpdate+=1;
                    }).catch(error =>{
                        this.msg_color ="alert alert-danger";
                        this.msg = "Erro ao cadastrar";
                    }).finally(() => {
                        this.disabled = 0;
                    })
            },
            getBanks(){
                axios.get(process.env.MIX_APP_URL+"/bank",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.banks = response.data
                    }).catch(error =>{
                        console.log(error);
                    })
            },
            clearForm(){
                this.user.name = '';
                this.user.email = '';
                this.user.password = '';
                this.user.bank_id = 0;
            }  
        },
        mounted(){
            this.getBanks()
        }
    }
</script>