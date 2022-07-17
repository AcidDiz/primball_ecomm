<template>
  <div class="flex justify-center items-center space-x-3">
    <button v-if="showEdit" class="py-2 px-2 bg-amber-500">
      <Link :href="editLink">
        <Edit class="w-4 h-4 text-white" />
      </Link>
    </button>
    <button v-if="showDelete" class="py-2 px-2 bg-red-500" @click="$emit('deleteClicked', $event)">
      <Delete class="w-4 h-4 text-white" />
    </button>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Edit from "@/Components/Icons/Edit";
import Delete from "@/Components/Icons/Delete";

defineProps({
  editLink: {
    type: String,
  },
  showEdit: {
    type: Boolean,
    default: false,
  },
  showDelete: {
    type: Boolean,
    default: false,
  },
});
</script>

<style lang="scss" scoped></style>
