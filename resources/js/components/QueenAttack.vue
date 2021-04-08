<template>
   <main class="container-fluid page page-problem">
   <div class=" button-back" v-on:click="$router.push('/')">
&#8592;
     </div>
     
<div class="container">

     <div class=" row">

<h1 class="title title-top col-sm-12">
Queen Attack
</h1>
<div class="col-sm-12">


<div class="alert alert-danger" v-if="error!=''" role="alert">
  {{error}}
</div>
<div  class="row align-items-center ">
<div class="form-group col-lg-6 col-sm-12">

<textarea v-model="input" name="" id="input-3" cols="30" rows="10" class="form-control"></textarea>
</div>

<div class="col-lg-6 col-sm-12" >
<div class="button button-calculate" v-on:click="getResult()">Calculate</div>
</div>
</div>

</div>

<div class="col-sm-12">
 

  <pre id="output-1" class="output" >
  {{result==""?"Result":result}}
  </pre>
 
</div>
     </div>
</div>

 </main>
</template>

<script>
export default {
  data(){ 
    return {
        input:"",
        result:"",
        error: ""

    }},
    methods: {
        getResult: function() {
          this.error="";
          this.result="";
            axios.post("api/queenattack",{
             text: this.input
            }).then(response => {
              this.result = response.data.result
            }
            ).catch(error => this.error = error.response.data.error);
        }
    }
}
</script>

<style>

</style>