<template>
  <Transition>
    <div
      v-if="message"
      class="fixed z-50 top-5 right-5 text-white"
      :class="{
        'w-96 py-4 px-8 bg-green-400 border border-green-600 text-center': message,
      }"
    >
      {{ message }}
    </div>
  </Transition>
</template>

<script setup>
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

let message = ref("");
let timeoutHandler = ref(null)


watch(
  () => usePage().props.value.flash?.success,

  (successMessage) => {
    message.value = successMessage;
    clearTimeout(timeoutHandler.value);


   timeoutHandler.value = setTimeout(() => {
      message.value = "";
    }, 1500);
  },

  {
    immediate: true,
  }
);

</script>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.75s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
