<template>
<main>
 <section class="container-fluid page page-problem">
     <div class=" button-back" v-on:click="$router.push('/')">
&#8592;
     </div>
<div class="container">

     <div class=" row">

<h1 class="title title-top col-sm-12">
Paddle League
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

  <div  v-if="result!=''"  class="col-sm-12 button-detail" v-on:click="scrollToDetail()" >

&#8595;
     </div>
     </div>
</div>

 </section>

  <section v-if="result!=''" id="detail" class="container-fluid page page-detail  ">
<div class="container">

   <div class="row" :class="{'content-detail content-detail-group': categories.length>3 }">
<div  v-for="category in categories" :key="category" class="container col-lg-4" > 
  

  <label for="">{{category.name}}  </label>
  <div  :class="{'content-detail content-detail-table': category.participants.length>5 }">

<table class="table table-dark ">
  <thead>
    <tr >
     
      <th scope="col">Partnet</th>
      <th scope="col">Score</th>
    
    </tr>
  </thead>
  <tbody>
    <tr v-for="participant in category.participants" :key="participant">
    
      <td>{{participant.name}}</td>
      <td>{{participant.points}}</td>
  
    </tr> 
    
  </tbody>
</table>
  </div>
  </div>
</div>
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
        categories:[]

    }},
    methods: {
        getResult: function() {
          this.error="";
          this.result="";
            axios.post("api/paddleleague",{
             text: this.input
            }).then(response => {
              this.result = response.data.result,
              this.categories = response.data.categories
            }
            ).catch(error => this.error = error.response.data.error);
        }
,
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