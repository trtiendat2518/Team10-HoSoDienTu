<template>
    <div>
        <transition>
            <router-view name="student"></router-view>
        </transition>
    </div>
</template>

<script>
import 'animate.css'
export default {}
</script>

<style lang="css" scoped>
.animate__animated.animate__fast {
    --animate-duration: 0.5s;
}
</style>
