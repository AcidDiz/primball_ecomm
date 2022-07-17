<template>
  <div class="bg-white overflow-hidden shadow-lg sm:rounded-md border-b border-gray-200">
    <div v-if="$slots.header" class="py-2 px-6 bg-gray-50">
      <slot name="header" />
    </div>

    <div v-if="$slots.body" class="p-6">

      <slot name="body"> </slot>
    </div>
  </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
