<template>
    <div>
        <transition
            appear
            enter-class=""
            enter-active-class="animate__animated animate__fast"
            leave-class=""
            leave-active-class="animate__animated animate__fast"
        >
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
import 'animate.css'
export default {}
</script>

<style lang="css" scoped>
.animate__animated.animate__fast {
    --animate-duration: 0.4s;
}
</style>
