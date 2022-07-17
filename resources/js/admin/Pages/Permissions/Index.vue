<template>
  <Head :title="title + 's'" />

  <Layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}s</h2>
    </template>
    <Flash />
    <Container>
      <Filters v-model="filters" />
      <Card>
        <template #body>
          <div class="flex justify-between items-center">
            <h1 class="text-3xl">{{ title }}s Table</h1>
            <Link v-if="href" :href="href">
              <Button
                v-if="can.create"
                class="bg-sky-600 hover:bg-sky-500 text-xs flex justify-around items-center rounded-none space-x-2"
              >
                <New class="w-4 h-4" />
                <span class="text-xs">Add {{ title }} </span>
              </Button>
            </Link>
          </div>
          <Table :headers="headers" :items="items" :isLoading="isLoading">
            <template v-slot="{ item }">
              <Td>
                {{ item.id }}
              </Td>
              <Td>
                {{ item.name }}
              </Td>
              <Td>
                {{ item.created_at_formatted }}
              </Td>
              <Td>
                <Actions
                  :editLink="route(`admin.${routeResourceName}.edit`, item)"
                  :showEdit="item.can.edit"
                  :showDelete="item.can.delete"
                  @deleteClicked="showDeleteModal(item)"
                />
              </Td>
            </template>
          </Table>
        </template>
      </Card>
    </Container>
  </Layout>

  <Modal v-model="deleteModal" :size="`md`" :title="`Delete ${itemToDelete.name}`">
    Are you sure you want to delete this Permission?
    <span class="block font-bold text-red-400"> [{{ itemToDelete.name }}] </span>

    <template #footer>
      <div class="flex space-x-4">
        <Button
          class="bg-red-600 hover:bg-red-500 text-xs flex justify-around items-center rounded-none space-x-2"
          @click="handleDeleteItem"
          :disabled="isDeleting"
        >
          {{ isDeleting ? "Deleting" : "Delete" }}
        </Button>
      </div>
    </template>
  </Modal>
</template>
<script setup>
import { ref } from "vue";
import Layout from "@/Layouts/Authenticated";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import Table from "@/Components/Table/Table";
import Button from "@/Components/Button";
import New from "@/Components/Icons/New";
import Td from "@/Components/Table/Td";
import Actions from "@/Components/Table/Actions";
import Flash from "@/Components/Flash";
import Modal from "@/Components/Modal";
import Filters from "./Filters.vue";

import useDeleteItem from "@/Composables/useDeleteItems";
import useFilters from "@/Composables/useFilters";

const props = defineProps({
  items: {
    type: Object,
    default: () => ({}),
  },
  headers: {
    type: Array,
  },
  title: {
    type: String,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
  routeResourceName: {
    type: String,
    required: true,
  },
  can: {
    type: Object,
  },
});

const href = ref(route(`admin.${props.routeResourceName}.create`));

const {
  deleteModal,
  itemToDelete,
  isDeleting,
  showDeleteModal,
  handleDeleteItem,
} = useDeleteItem({
  routeResourceName: props.routeResourceName,
});

const { filters, isLoading } = useFilters({
  filters: props.filters,
  routeResourceName: props.routeResourceName,
});
</script>
