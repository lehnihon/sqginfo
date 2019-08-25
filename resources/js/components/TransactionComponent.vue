<template>
    <div>
        <div v-if="msg" :class="msg_color" role="alert" v-html="msg">
        </div>
        <div class="card">
            <div class="card-header">{{headerTransaction}}</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <textarea v-model="transaction.description" id="" cols="30" rows="5" placeholder="Descrição" class="form-control"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" v-model="transaction.value" placeholder="Valor" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <select v-model="transaction.user_id" class="form-control">
                            <option value="">Selecione uma Conta</option>
                            <option v-for="account in accounts" v-bind:key="account.id" :value="account.id">{{account.name}}</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <select v-model="transaction.status" class="form-control">
                            <option value="">Selecione um Status</option>
                            <option value="P">Pago</option>
                            <option value="R">Recebido</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <input v-if="!transaction.id" :disabled="disabled == 1" type="button" @click="store" class="btn btn-primary" value="Gravar">
                        <input v-else :disabled="disabled == 1" type="button" @click="update" class="btn btn-primary" value="Atualizar">
                    </div>
                </div>
            </div>
        </div>

        <TransactionTable @clicked="editTransaction" :key="componentUpdate"></TransactionTable>
    </div>
</template>

<script>
    import axios from 'axios'
    import TransactionTable from './TransactionTableComponent.vue' 

    export default {
        components: {
            TransactionTable
        },
        data: () => ({
            headerTransaction:'Cadastro de Transação',
            msg:'',
            msg_color:'alert alert-success',
            disabled:0,
            accounts:[],
            componentUpdate:0,
            transaction:{
                id: 0,
                description: '',
                value:'',
                user_id:'',
                status:''
            }
        }),
        methods: {
            store(){
                this.disabled = 1;
                if(!this.formValidate()){
                    axios.post(process.env.MIX_APP_URL+"/transaction",this.transaction,{ headers: {'Authorization': "Bearer "+window.api_token}})
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
                }else{
                    this.msg_color ="alert alert-warning";
                    this.msg = this.formValidate();
                    this.disabled = 0;
                }
            },
            update(){
                this.disabled = 1;
                if(!this.formValidate()){
                    axios.put(process.env.MIX_APP_URL+"/transaction",this.transaction,{ headers: {'Authorization': "Bearer "+window.api_token}})
                        .then(response => {
                            this.msg_color ="alert alert-success";
                            this.msg = "Conta atualizada com sucesso!";
                            this.clearForm();
                            this.componentUpdate+=1;
                        }).catch(error =>{
                            this.msg_color ="alert alert-danger";
                            this.msg = "Erro ao atualizar";
                        }).finally(() => {
                            this.disabled = 0;
                        })
                }else{
                    this.msg_color ="alert alert-warning";
                    this.msg = this.formValidate();
                    this.disabled = 0;
                }
            },
            getAccounts(){
                axios.get(process.env.MIX_APP_URL+"/account",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.accounts = response.data
                    }).catch(error =>{
                        console.log(error);
                    })
            },
            formValidate(){
                let msg_error = '';
                if(this.transaction.description == ''){
                    msg_error+="Descrição é obrigatório <br>";
                }
                if(this.transaction.value == ''){
                    msg_error+="Valor é obrigatório <br>";
                }
                if(this.transaction.user_id == ''){
                    msg_error+="Selecione uma conta <br>";
                }
                return msg_error;
            },
            clearForm(){
                this.transaction.description = '';
                this.transaction.value = '';
                this.transaction.user_id  = 0;
                this.transaction.status  = 0;
            },
            editTransaction(transaction) {
                this.transaction = transaction
                this.btnMsg ="Atualizar"
                this.headerTransaction = "Atualização de Transação: #"+transaction.id
            }
        },
        mounted(){
            this.getAccounts()
        }
    }
</script>