<template>
    <div>
    <transition name="fade">
  <div class="card">
    <header @click="togglelinks" class="card-header">
      <p class="card-header-title">{{ this.title }} - [{{ this.count }}]</p>
    <span class="card-header-icon"><span class="icon">[{{ this.icon || "" }}]</span></span>
    </header>
    <div v-show="collapsed" class="card-content">
      <div class="content">
        <slot></slot>
      </div>
  </div>
</div>
    </transition>
</div>
</template>

<script>
export default {
    props: ['title', 'icon', 'count'],
    data() {
        return {
            collapsed: true
        }
    },
    methods: {
        togglelinks: function () {
            this.collapsed = ! this.collapsed;
        },
    }
}

</script>

<style lang="scss">

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s
  }
  .fade-enter, .fade-leave-active {
    opacity: 0
  }

</style>
