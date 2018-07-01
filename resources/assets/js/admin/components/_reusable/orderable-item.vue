<template>
    <div class="orderable-container">
        <div class="left">{{ leftText }}</div>

        <div class="middle">{{ middleText }}</div>

        <div class="right">
            <b-btn variant="outline-info"
                   title="View/Edit"
                   :to="link"
            ><span class="ti-pencil-alt"/></b-btn>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'orderable-item',

    props: {
      leftText: {
        type: [String, Number],
        required: true
      },
      middleText: {
        type: String,
        required: true
      },
      link: {
        type: String,
        required: true
      }
    }
  }
</script>

<style lang="sass" scoped>
    .orderable-container
        display: flex
        justify-content: space-between
        align-items: center
        -webkit-user-select: none
        -moz-user-select: none
        -ms-user-select: none
        user-select: none
        width: 100%
        border-radius: 3px
        -webkit-box-shadow:  0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08)
        -moz-box-shadow:  0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08)
        box-shadow:  0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08)

        .left, .middle
            padding: .5rem 1rem
            color: #fff
            cursor: grab

        .left
            background-color: #005cbf

        .middle
            background-color: #80bdff
            width: 100%
            text-transform: uppercase

        .right
            padding-left: 0

            .btn
                border-top-left-radius: 0
                border-bottom-left-radius: 0
                border-left: 0 none
                padding: 0.42rem 0.75rem
</style>