<template>
  <form action="#" method="post">
    <div class="input-group">
          <span class="input-group-btn">
            <button type="button" class="btn btn-primary btn-flat">
              <i class="fa fa-plus"></i>
            </button>
            <button type="button" class="btn btn-primary btn-flat">
              <i class="fa fa-smile-o"></i>
            </button>
            <button type="button" class="btn btn-primary btn-flat">
              <i class="fa fa-microphone"></i>
            </button>
          </span>
          <input type="text" name="message" placeholder="Type Message ..." class="form-control">
    </div>
  </form>
</template>

<script>
  export default {
    mounted(){
      console.log('message composer mounted');
    }
  }
</script>