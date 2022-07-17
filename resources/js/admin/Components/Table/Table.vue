<template>
  <div class="overflow-x-auto relative shadow-lg mt-6 mb-6">
    <div v-if="isLoading" class="w-full bg-gray-50 h-1">
      <div class="animate-progress bg-sky-400 h-1"></div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-white uppercase bg-gray-800">
        <tr>
          <th
            v-for="header in headers"
            :key="header.label"
            scope="col"
            class="py-3 px-6"
            :class="{ 'text-center': header.label === 'Actions' }"
          >
            {{ header.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items.data"
          :key="item.id"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
        >
          <slot :item="item" />
        </tr>
        <tr
          v-if="items.data?.length === 0"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
        >
          <Td :colspan="headers?.length" class="text-center text-red-400 font-bold"
            >No Data Available</Td
          >
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import Th from "./Th.vue";
import Td from "./Td.vue";

defineProps({
  headers: {
    type: Array,
    default: () => [],
  },
  items: {
    type: Object,
    default: () => ({}),
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
});
</script>

<style lang="scss" scoped></style>
