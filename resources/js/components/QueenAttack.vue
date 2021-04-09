<template>

<main>

   <section class="container-fluid page page-problem">
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
<div  v-if="result!=''"  class="col-sm-12 button-detail" v-on:click="scrollToDetail()" >

&#8595;
     </div>
     </div>
</div>

  

   </section>

    <section v-if="result!=''" id="detail" class="container-fluid page page-start  ">
<div class="container">

   <div :class="{'content-board': board.length>15 }">

<table class="board">
	<tr  v-for="cell in board" :key="cell"><td  v-for="celly in cell" :key="celly" >
     {{celly!=0?celly:''}}
    </td></tr>
	
</table>
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
        board: []

    }},
    methods: {
        getResult: function() {
          this.error="";
          this.result="";

            axios.post("api/queenattack",{
             text: this.input
            }).then(response => {
              this.result = response.data.result;
              this.board = response.data.board;
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

<style scoped>
/* board */
.content-board{
  
  overflow-y: scroll;
  height: 500px;
}
table {
	margin: 0 auto;
	border-collapse: collapse;
	background: rgb(12, 114, 51);
}
td{
    width: 30px; height: 30px;
    align-content: center;
    text-align: center;
    font-weight: 700;
    font-family: Arial, Helvetica, sans-serif;
    
}





tr:nth-child(odd) td:nth-child(even), tr:nth-child(even) td:nth-child(odd) {
	background: white;
}
</style>