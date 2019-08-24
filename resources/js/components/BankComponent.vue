<template>
    <div class="row">
        <div class="col-12 form-group">
            <input type="text" v-model="name" placeholder="Nome" class="form-control">
        </div> 
    </div>
</template>

<script>
    export default {
        data: () => ({
            bank:{
                name: ''
            }
        }),
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>