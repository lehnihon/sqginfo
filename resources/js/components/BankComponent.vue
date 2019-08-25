<template>
    <div>
        <div v-if="msg" :class="msg_color" role="alert" v-html="msg">
        </div>
        <div class="card">
            <div class="card-header">Cadastro do Banco</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <input type="text" v-model="bank.name" placeholder="Nome" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <input :disabled="disabled == 1" type="button" @click="store" class="btn btn-primary" value="Gravar">
                    </div>
                </div>
            </div>
        </div>

        <BankTable :key="componentUpdate"></BankTable>
    </div>
</template>

<script>
    import axios from 'axios'
    import BankTable from './BankTableComponent.vue' 

    export default {
        components: {
            BankTable
        },
        data: () => ({
            msg:'',
            msg_color:'alert alert-success',
            disabled:0,
            banks:[],
            componentUpdate:0,
            bank:{
                name: ''
            }
        }),
        methods: {
            store(){
                this.disabled = 1;
                if(!this.formValidate()){
                    axios.post(process.env.MIX_APP_URL+"/bank",this.bank,{ headers: {'Authorization': "Bearer "+window.api_token}})
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
            getBanks(){
                axios.get(process.env.MIX_APP_URL+"/bank",{ headers: {'Authorization': "Bearer "+window.api_token}})
                    .then(response => {
                        this.banks = response.data
                    }).catch(error =>{
                        console.log(error);
                    })
            },
            formValidate(){
                let msg_error = '';
                if(this.bank.name == ''){
                    msg_error+="Nome é obrigatório <br>";
                }
                return msg_error;
            },
            clearForm(){
                this.bank.name = '';
            }  
        },
        mounted(){
        }
    }
</script>