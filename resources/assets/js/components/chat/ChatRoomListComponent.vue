<template>
  <ul class="products-list product-list-in-box">
    <li class="item"  v-for="chatRoom in chatRooms">
      <div class="product-img">
        <span class="direct-chat-img bg-blue">
          <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
        </span>
      </div>
      <div class="product-info">
        <a href="javascript:void(0)" class="product-title">
            {{ chatRoom.name }}
        </a>
        <span class="pull-right">
          <!-- <small class="label ">
            <i class="fa fa-circle text-success"></i>
          </small>
          <small class="label text-black">
            <i class="fa fa-phone"></i>
          </small>
          <small class="label bg-yellow">2</small> -->
        </span>
        <span class="product-description">
          {{ chatRoom.updated_at }}
        </span>
      </div>
    </li>
    <!-- /.item -->
  </ul>
</template>

<script>
  export default{
    props: {
      chatRooms : {
        type : Array,
        default : []
      }
    },
    mounted() {

    }
  }
</script>