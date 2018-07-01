<template>
    <span class="text-muted mt-2" v-if="show">Please Wait...</span>
</template>

<script>
  export default {
    name: 'wait-msg',

    props: {
      show: {
        required: true,
        type: Boolean
      }
    }
  }
</script>

