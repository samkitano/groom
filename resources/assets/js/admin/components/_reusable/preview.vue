<template>
    <div class="preview-box mb-4">
        <article :class="item.css_class" :style="css">
            <h1 v-html="item.title[lang]"/>
            <div v-html="item.body[lang]"/>
            <p v-if="item.more">
                <a @click.prevent.stop="noop" :href="`/${item.more}`">{{ $store.state.more[lang] }}</a>
            </p>
        </article>
    </div>
</template>

<script>
  export default {
    computed: {
      css () {
        let arr = this.item.css
        let css = ''

        for (let i in arr) {
          css += `${i}:${arr[i]};`
        }

        if (this.item.image !== null && !this.item.image_outside) {
          css += `background-image: url("/img/${this.item.image}");background-repeat:no-repeat;background-position:center;background-size:cover;`
        }

       return css
      }
    },

    methods: {
      noop () {}
    },

    props: {
      item: {
        required: true,
        type: [Object, Array]
      },
      lang: {
        required: false,
        default: 'en',
        type: String
      }
    },

    name: 'preview'
  }
</script>
