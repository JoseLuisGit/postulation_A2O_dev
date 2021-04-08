<template>
<main id="main">
<section class="container-fluid page page-problem">
        <div class=" button-back" v-on:click="$router.push('/')">
&#8592;
     </div>



<div class="container ">

     <div class=" row">

<h1 class="title title-top col-sm-12">
String Value
</h1>
<div class="col-sm-12">


<div class="alert alert-danger" v-if="error!=''" role="alert">
  {{error}}
</div>
<div  class="row align-items-center ">
<div class="form-group col-lg-6 col-xs-12">

<textarea v-model="input" name="" id="input-3" cols="30" rows="10" class="form-control"></textarea>
</div>

<div class="col-lg-6 col-xs-12" >
<div class="button button-calculate" v-on:click="getResult()">Calculate</div>
</div>
</div>

</div>

<div class="col-sm-12">
 

  <pre id="output-1" class="output" >
  {{result==""?"Result":result}}
  </pre>
 
</div>


  <div  v-if="result!=''"  class="col-sm-12 button-detail" v-on:click="scrollToDetail()" >

&#8595;
     </div>

     </div>
</div>


  
</section>

 <section v-if="result!=''" id="detail" class="container-fluid page page-start  ">

   <div :class="{'content-detail content-detail-group': subStrings.length>10 }">

<table class="table table-dark ">
  <thead>
    <tr>
     
      <th scope="col">SubString</th>
      <th scope="col">Value</th>
    
    </tr>
  </thead>
  <tbody>
    <tr v-for="subString in subStrings" :key="subString.subString">
    
      <td>{{subString.subString}}</td>
      <td>{{subString.value}}</td>
  
    </tr>
    
    
  </tbody>
</table>
   </div>
 </section>
</main>
   
</template>

<script>
export default {
  data(){ 
    return {
        input:"",
        result:"",
        error: "",
        subStrings:[]

    }},
    methods: {
        getResult: function() {
          this.error="";
          this.result="";
            axios.post("api/stringvalue",{
             text: this.input
            }).then(response => {
              this.result = response.data.result
              this.subStrings = response.data.substrings;
  
            }
            ).catch(error => this.error = error.response.data.error);
        },
        scrollToDetail() {
     const el = this.$el.querySelector("#detail");
    if (el) {
      el.scrollIntoView({behavior: 'smooth'});
    }

  }
    }
}
</script>

<style>

</style>