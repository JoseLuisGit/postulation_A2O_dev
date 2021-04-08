<template>
  <main class="container-fluid page page-start">


 <div class="button button-init" v-on:click="menu=!menu" v-if="!menu">
   Let's go
  </div>

  <h1 class="title title-foot"  v-if="!menu">
   Postulation A2O DEV
  </h1>
 

   <transition name="bounce">
 <div v-if="menu" >
      <div class="row">

 <div class="col-md-4">
 <div class="button button-exercise" v-on:click="$router.push('problem-1')" >
   Paddle League
  
 </div>
 </div>
 <div class="col-md-4">
 <div class="button button-exercise" v-on:click="$router.push('problem-2')">
   Queen Attack
 </div>
 </div>
  <div class="col-md-4">
 <div class="button button-exercise" v-on:click="$router.push('problem-3')">
   String Value
 </div>
      </div>
 </div>
 </div>
    </transition>

  </main>
</template>

<script>
export default {
data(){
  return {

    menu:false
  }
}
}
</script>

