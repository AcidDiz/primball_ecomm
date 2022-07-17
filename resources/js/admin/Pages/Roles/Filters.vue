<template>
  <Card class="mb-4">
    <template #header>
      <h3 class="font-bold">Filters</h3>

      <form class="my-3 w-60">
        <div>
          <Label for="name" value="Name" />
          <Input
            id="name"
            type="text"
            class="mt-1 block w-full rounded-none max-h-8"
            v-model="filters.name"
            required
            autocomplete="name"
          />
        </div>
      </form>
    </template>
  </Card>
</template>
<script setup>
import { ref, watch } from "vue";

import Card from "@/Components/Card.vue";
import Label from "@/Components/Label.vue";
import Input from "@/Components/Input.vue";

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({}),
  },
});

const emits = defineEmits(["update:modelValue"]);

const filters = ref({ ...props.modelValue });

watch(
  filters,
  () => {
    emits("update:modelValue", filters.value);
  },
  {
    deep: true,
  }
);
</script>
