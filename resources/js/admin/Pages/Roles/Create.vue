<template>
  <Head :title="title" />

  <Layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ edit ? "Edit " + title : "Create " + title }}
      </h2>
    </template>
    <Flash />

    <Container>
      <Card>
        <template #body>
          <div class="flex justify-start items-center">
            <h1 class="text-3xl">{{ title }}</h1>
          </div>
          <form @submit.prevent="save" class="mt-6 mb-3">
            <div>
              <div>
                <InputError class="my-1" :message="form.errors.name" />
              </div>
              <Label for="name" value="Name" />
              <Input
                id="name"
                type="text"
                class="mt-1 block w-full rounded-none max-h-8"
                v-model="form.name"
                required
                autocomplete="name"
              />
              <div class="flex justify-end mt-3">
                <Button
                  class="bg-sky-600 hover:bg-sky-500 text-xs flex justify-around items-center rounded-none space-x-2"
                  :disabled="form.processing"
                >
                  <span class="text-xs">{{ form.processing ? "Saving" : "Save" }}</span>
                </Button>
              </div>
            </div>
          </form>
        </template>
      </Card>
    </Container>

    <Permissions v-if="edit" class="mt-6" :role="item" :permissions="permissions" />
  </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Authenticated";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import Label from "@/Components/Label";
import Input from "@/Components/Input";
import Button from "@/Components/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError";
import Permissions from "./Permissions";
import Flash from "@/Components/Flash.vue";

const props = defineProps({
  edit: { type: Boolean, default: false },
  item: { type: Object, default: () => ({}) },
  title: { type: String, default: "" },
  routeResourceName: {
    type: String,
    required: true,
  },
  permissions: {
    type: Array,
  },
});

const form = useForm({
  name: props.item?.name || "",
});

const save = () => {
  props.edit
    ? form.put(route(`admin.${props.routeResourceName}.update`, { id: props.item.id }))
    : form.post(route(`admin.${props.routeResourceName}.store`));
};
</script>

<style lang="scss" scoped></style>
